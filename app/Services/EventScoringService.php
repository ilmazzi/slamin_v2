<?php

namespace App\Services;

use App\Models\Event;
use App\Models\EventRanking;
use App\Models\EventParticipant;
use App\Models\Badge;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class EventScoringService
{
    /**
     * Calculate rankings for an event
     */
    public function calculateRankings(Event $event): void
    {
        DB::beginTransaction();

        try {
            // Delete existing rankings
            $event->rankings()->delete();

            // Get all participants with scores
            $participants = $event->participants()
                ->with('scores')
                ->whereIn('status', ['performed', 'confirmed'])
                ->get();

            $rankings = [];

            foreach ($participants as $participant) {
                $scores = $participant->scores;
                
                if ($scores->count() === 0) {
                    continue; // Skip participants without scores
                }

                // Calculate total score based on scoring type
                $totalScore = $this->calculateTotalScore($scores, $event);
                $roundScores = $scores->pluck('score', 'round')->toArray();

                $rankings[] = [
                    'participant' => $participant,
                    'total_score' => $totalScore,
                    'round_scores' => $roundScores,
                ];
            }

            // Sort by total score (descending)
            usort($rankings, function ($a, $b) {
                return $b['total_score'] <=> $a['total_score'];
            });

            // Assign positions and save rankings
            foreach ($rankings as $position => $rankingData) {
                $finalPosition = $position + 1;
                $badgeId = $this->getBadgeForPosition($finalPosition);

                Log::info('Creating ranking', [
                    'event_id' => $event->id,
                    'participant_id' => $rankingData['participant']->id,
                    'position' => $finalPosition,
                    'total_score' => $rankingData['total_score'],
                    'badge_id' => $badgeId,
                ]);

                EventRanking::create([
                    'event_id' => $event->id,
                    'participant_id' => $rankingData['participant']->id,
                    'position' => $finalPosition,
                    'total_score' => $rankingData['total_score'],
                    'round_scores' => $rankingData['round_scores'],
                    'badge_id' => $badgeId,
                    'badge_awarded' => false,
                ]);
            }

            DB::commit();

            Log::info('Event rankings calculated', [
                'event_id' => $event->id,
                'participants_ranked' => count($rankings)
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error calculating rankings', [
                'event_id' => $event->id,
                'error' => $e->getMessage()
            ]);
            throw $e;
        }
    }

    /**
     * Award badges to winners
     */
    public function awardBadgesToWinners(Event $event): int
    {
        $badgesAwarded = 0;
        $badgeService = app(BadgeService::class);

        $rankings = $event->rankings()
            ->with(['participant.user', 'badge'])
            ->where('badge_awarded', false)
            ->whereNotNull('badge_id')
            ->orderBy('position') // Ensure we process in order
            ->get();

        foreach ($rankings as $ranking) {
            $participant = $ranking->participant;
            
            // Only award to registered users
            if (!$participant->user) {
                continue;
            }

            if ($ranking->badge) {
                // Double-check that the badge matches the position
                $expectedBadgeId = $this->getBadgeForPosition($ranking->position);
                
                if ($expectedBadgeId !== $ranking->badge_id) {
                    Log::error('Badge mismatch detected!', [
                        'event_id' => $event->id,
                        'participant_id' => $participant->id,
                        'position' => $ranking->position,
                        'expected_badge_id' => $expectedBadgeId,
                        'actual_badge_id' => $ranking->badge_id,
                        'actual_badge_name' => $ranking->badge->name,
                    ]);
                    
                    // Fix the badge
                    $correctBadge = Badge::find($expectedBadgeId);
                    if ($correctBadge) {
                        $ranking->badge_id = $expectedBadgeId;
                        $ranking->save();
                        $ranking->refresh();
                        $ranking->load('badge');
                        
                        Log::info('Badge corrected', [
                            'event_id' => $event->id,
                            'participant_id' => $participant->id,
                            'position' => $ranking->position,
                            'correct_badge_id' => $expectedBadgeId,
                            'correct_badge_name' => $correctBadge->name,
                        ]);
                    }
                }

                Log::info('Awarding badge to participant', [
                    'event_id' => $event->id,
                    'participant_id' => $participant->id,
                    'user_id' => $participant->user->id,
                    'position' => $ranking->position,
                    'badge_id' => $ranking->badge->id,
                    'badge_name' => $ranking->badge->name,
                ]);

                if (!$participant->user->badges()->where('badges.id', $ranking->badge->id)->exists()) {
                    $badgeService->manuallyAwardBadge(
                        $participant->user,
                        $ranking->badge,
                        auth()->user(),
                        "Vinto {$ranking->position}° posto all'evento: {$event->title}"
                    );

                    $badgesAwarded++;
                } else {
                    Log::info('Badge already exists for user', [
                        'user_id' => $participant->user->id,
                        'badge_id' => $ranking->badge->id,
                        'badge_name' => $ranking->badge->name,
                    ]);
                }
            } else {
                Log::warning('No badge found for ranking', [
                    'event_id' => $event->id,
                    'participant_id' => $participant->id,
                    'position' => $ranking->position,
                ]);
            }

            // Mark as awarded
            $ranking->badge_awarded = true;
            $ranking->save();

            // Award participation badge
            $this->awardParticipationBadge($participant->user, $event);
        }

        return $badgesAwarded;
    }

    /**
     * Calculate total score based on scoring type
     */
    protected function calculateTotalScore($scores, Event $event): float
    {
        $round = $event->rounds()->first();
        $scoringType = $round ? $round->scoring_type : 'average';

        return match($scoringType) {
            'sum' => $scores->sum('score'),
            'best_of' => $scores->max('score'),
            'average' => $scores->avg('score'),
            default => $scores->avg('score'),
        };
    }

    /**
     * Get badge ID for a position
     */
    protected function getBadgeForPosition(int $position): ?int
    {
        $badgeName = match($position) {
            1 => 'Campione - Oro',
            2 => 'Finalista - Argento',
            3 => 'Podio - Bronzo',
            default => null,
        };

        if (!$badgeName) {
            return null;
        }

        // Search for badge by name, type and category to ensure we get the correct one
        $badge = Badge::where('name', $badgeName)
            ->where('type', 'event')
            ->where('category', 'event_wins')
            ->where('criteria_type', 'special') // Only special badges for podium positions
            ->first();

        if (!$badge) {
            Log::warning('Badge not found for position', [
                'position' => $position,
                'badge_name' => $badgeName
            ]);
        }

        return $badge?->id;
    }

    /**
     * Award participation badge
     */
    protected function awardParticipationBadge($user, Event $event): void
    {
        if (!$user) {
            return;
        }

        $badgeService = app(BadgeService::class);
        $badgeService->checkAndAwardBadge($user, 'event_participation', $event);
    }
}

