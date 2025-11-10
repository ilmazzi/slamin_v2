<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Event;
use App\Models\Gig;

class RegenerateEventGigs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gigs:regenerate-from-events {--force : Force regeneration even if gigs have applications}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Regenerate gigs from existing events with positions';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🔄 Starting gig regeneration from events...');

        // Get all events that have gig_positions
        $events = Event::whereNotNull('gig_positions')
            ->whereJsonLength('gig_positions', '>', 0)
            ->get();

        if ($events->isEmpty()) {
            $this->warn('⚠️  No events with positions found.');
            return 0;
        }

        $this->info("Found {$events->count()} events with positions.");

        $created = 0;
        $deleted = 0;
        $skipped = 0;

        foreach ($events as $event) {
            $this->line("\n📋 Processing: {$event->title} (ID: {$event->id})");

            // Count existing gigs for this event
            $existingGigs = $event->gigs()->where('gig_type', 'event')->get();

            if ($existingGigs->isNotEmpty()) {
                $this->line("   Found {$existingGigs->count()} existing gigs");

                // Check if any have applications
                $gigsWithApplications = $existingGigs->filter(function ($gig) {
                    return $gig->applications()->exists();
                });

                if ($gigsWithApplications->isNotEmpty() && !$this->option('force')) {
                    $this->warn("   ⚠️  Skipping: {$gigsWithApplications->count()} gigs have applications. Use --force to regenerate anyway.");
                    $skipped++;
                    continue;
                }

                // Delete existing gigs
                if ($this->option('force')) {
                    $deletedCount = $event->gigs()->where('gig_type', 'event')->delete();
                    $this->line("   🗑️  Deleted {$deletedCount} existing gigs (forced)");
                    $deleted += $deletedCount;
                } else {
                    $deletedCount = $event->gigs()
                        ->where('gig_type', 'event')
                        ->whereDoesntHave('applications')
                        ->delete();
                    $this->line("   🗑️  Deleted {$deletedCount} gigs without applications");
                    $deleted += $deletedCount;
                }
            }

            // Create new gigs from positions
            $positionsCount = count($event->gig_positions);
            $event->createGigsFromPositions();
            $this->info("   ✅ Created {$positionsCount} new gigs");
            $created += $positionsCount;
        }

        $this->newLine();
        $this->info('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
        $this->info('📊 Summary:');
        $this->info("   ✅ Created: {$created} gigs");
        $this->info("   🗑️  Deleted: {$deleted} old gigs");
        if ($skipped > 0) {
            $this->info("   ⚠️  Skipped: {$skipped} events (use --force to regenerate)");
        }
        $this->info('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');

        return 0;
    }
}
