<?php

namespace App\Livewire\Admin\Dashboard;

use Livewire\Component;
use App\Models\User;
use App\Models\Event;
use App\Models\Gig;
use App\Models\GigApplication;
use App\Models\TranslationPayment;
use App\Models\Video;
use App\Models\Poem;
use App\Models\Article;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class AdminDashboard extends Component
{
    // Statistiche (calcolate come computed properties)
    
    public function mount()
    {
        // Verifica che l'utente sia admin
        if (!Auth::check() || !Auth::user()->hasRole('admin')) {
            abort(403, 'Accesso negato');
        }
    }

    /**
     * Statistiche generali
     */
    public function getGeneralStatsProperty()
    {
        return [
            'total_users' => User::count(),
            'total_events' => Event::count(),
            'total_gigs' => Gig::count(),
            'total_payments' => TranslationPayment::where('status', 'completed')->count(),
            'total_videos' => Video::count(),
            'total_poems' => Poem::count(),
            'total_groups' => 0, // TODO: Implementare quando Group sarà disponibile
            'total_messages' => 0, // TODO: Implementare quando ChatMessage sarà disponibile
        ];
    }

    /**
     * Statistiche utenti
     */
    public function getUserStatsProperty()
    {
        $today = Carbon::today();
        $thisWeek = Carbon::now()->startOfWeek();
        $thisMonth = Carbon::now()->startOfMonth();

        return [
            'new_today' => User::whereDate('created_at', $today)->count(),
            'new_this_week' => User::where('created_at', '>=', $thisWeek)->count(),
            'new_this_month' => User::where('created_at', '>=', $thisMonth)->count(),
            'active_users' => User::where('updated_at', '>=', Carbon::now()->subDays(7))->count(),
            'premium_users' => User::whereHas('subscriptions', function($query) {
                $query->where('status', 'active')
                      ->where('end_date', '>', Carbon::now());
            })->count(),
            'translators' => User::whereHas('languages')->count(), // Approssimazione
        ];
    }

    /**
     * Statistiche eventi
     */
    public function getEventStatsProperty()
    {
        $today = Carbon::today();
        $thisWeek = Carbon::now()->startOfWeek();
        $thisMonth = Carbon::now()->startOfMonth();

        return [
            'events_today' => Event::whereDate('start_datetime', $today)->count(),
            'events_this_week' => Event::whereBetween('start_datetime', [$thisWeek, Carbon::now()->endOfWeek()])->count(),
            'events_this_month' => Event::whereMonth('start_datetime', Carbon::now()->month)->count(),
            'upcoming_events' => Event::where('start_datetime', '>=', $today)->count(),
            'past_events' => Event::where('start_datetime', '<', $today)->count(),
            'active_gigs' => Gig::where('is_closed', false)->count(),
        ];
    }

    /**
     * Statistiche pagamenti
     */
    public function getPaymentStatsProperty()
    {
        $today = Carbon::today();
        $thisWeek = Carbon::now()->startOfWeek();
        $thisMonth = Carbon::now()->startOfMonth();
        
        return [
            'total_revenue' => TranslationPayment::where('status', 'completed')->sum('commission_total') ?? 0,
            'today_revenue' => TranslationPayment::where('status', 'completed')
                ->whereDate('created_at', $today)
                ->sum('commission_total') ?? 0,
            'this_week_revenue' => TranslationPayment::where('status', 'completed')
                ->where('created_at', '>=', $thisWeek)
                ->sum('commission_total') ?? 0,
            'this_month_revenue' => TranslationPayment::where('status', 'completed')
                ->where('created_at', '>=', $thisMonth)
                ->sum('commission_total') ?? 0,
            'pending_payments' => TranslationPayment::where('status', 'pending')->count(),
            'completed_payments' => TranslationPayment::where('status', 'completed')->count(),
            'failed_payments' => TranslationPayment::where('status', 'failed')->count(),
        ];
    }

    /**
     * Statistiche contenuti
     */
    public function getContentStatsProperty()
    {
        return [
            'total_videos' => Video::count(),
            'total_poems' => Poem::count(),
            'videos_this_month' => Video::where('created_at', '>=', Carbon::now()->startOfMonth())->count(),
            'poems_this_month' => Poem::where('created_at', '>=', Carbon::now()->startOfMonth())->count(),
            'articles_this_month' => Article::where('created_at', '>=', Carbon::now()->startOfMonth())->count(),
        ];
    }

    /**
     * Attività recente
     */
    public function getRecentActivityProperty()
    {
        $recentUsers = User::latest()->take(5)->get();
        $recentEvents = Event::with('organizer')->latest()->take(5)->get();
        $recentPayments = TranslationPayment::with(['client', 'translator'])
            ->where('status', 'completed')
            ->latest()
            ->take(5)
            ->get();
        $recentGigs = Gig::with('user')->latest()->take(5)->get();

        return [
            'recent_users' => $recentUsers,
            'recent_events' => $recentEvents,
            'recent_payments' => $recentPayments,
            'recent_gigs' => $recentGigs,
        ];
    }

    /**
     * Utenti online
     */
    public function getOnlineUsersProperty()
    {
        return User::where('updated_at', '>=', Carbon::now()->subMinutes(5))->count();
    }

    public function render()
    {
        return view('livewire.admin.dashboard.admin-dashboard')
            ->layout('components.layouts.app');
    }
}
