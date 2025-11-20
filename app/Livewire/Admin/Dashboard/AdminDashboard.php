<?php

namespace App\Livewire\Admin\Dashboard;

use Livewire\Component;
use App\Models\User;
use App\Models\Event;
use App\Models\Gig;
use App\Models\GigApplication;
// use App\Models\TranslationPayment; // Non esiste ancora in slamin_v2
use App\Models\Video;
use App\Models\Poem;
// use App\Models\Group; // Verificare se esiste
// use App\Models\ChatMessage; // Verificare se esiste
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
            'total_payments' => 0, // TranslationPayment non esiste ancora
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
                $query->where('status', 'active');
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
        // TODO: Implementare quando TranslationPayment sarà disponibile
        return [
            'total_revenue' => 0,
            'today_revenue' => 0,
            'this_week_revenue' => 0,
            'this_month_revenue' => 0,
            'pending_payments' => 0,
            'completed_payments' => 0,
            'failed_payments' => 0,
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
            'total_groups' => 0, // TODO: Implementare quando Group sarà disponibile
            'total_messages' => 0, // TODO: Implementare quando ChatMessage sarà disponibile
            'videos_this_month' => Video::where('created_at', '>=', Carbon::now()->startOfMonth())->count(),
            'poems_this_month' => Poem::where('created_at', '>=', Carbon::now()->startOfMonth())->count(),
            'groups_this_month' => 0, // TODO: Implementare quando Group sarà disponibile
            'messages_this_month' => 0, // TODO: Implementare quando ChatMessage sarà disponibile
        ];
    }

    /**
     * Attività recente
     */
    public function getRecentActivityProperty()
    {
        $recentUsers = User::latest()->take(5)->get();
        $recentEvents = Event::latest()->take(5)->get();
        // TODO: Implementare quando TranslationPayment sarà disponibile
        $recentPayments = collect([]);
        $recentGigs = Gig::latest()->take(5)->get();

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
