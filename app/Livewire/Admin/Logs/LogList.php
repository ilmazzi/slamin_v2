<?php

namespace App\Livewire\Admin\Logs;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Url;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;

class LogList extends Component
{
    use WithPagination;

    #[Url]
    public $type = 'activity'; // activity, errors

    #[Url]
    public $hours = 24;

    #[Url]
    public $level = 'all'; // all, info, warning, error, critical

    #[Url]
    public $category = 'all';

    #[Url]
    public $user = 'all';

    #[Url]
    public $file = 'all'; // For error logs: all, errors, laravel, security, api

    // Modal per dettagli log
    public $showLogModal = false;
    public $selectedLog = null;

    public function mount()
    {
        if (!Auth::check() || !Auth::user()->hasRole('admin')) {
            abort(403, 'Accesso negato');
        }
    }

    public function updatingHours()
    {
        $this->resetPage();
    }

    public function updatingLevel()
    {
        $this->resetPage();
    }

    public function updatingCategory()
    {
        $this->resetPage();
    }

    public function updatingUser()
    {
        $this->resetPage();
    }

    public function updatingFile()
    {
        $this->resetPage();
    }

    public function getStatsProperty()
    {
        if ($this->type === 'activity') {
            return $this->getActivityLogStats();
        } else {
            return $this->getErrorLogStats();
        }
    }

    private function getActivityLogStats()
    {
        $since = Carbon::now()->subHours($this->hours);

        return [
            'total' => ActivityLog::where('created_at', '>=', $since)->count(),
            'info' => ActivityLog::where('created_at', '>=', $since)->where('level', 'info')->count(),
            'warning' => ActivityLog::where('created_at', '>=', $since)->where('level', 'warning')->count(),
            'error' => ActivityLog::where('created_at', '>=', $since)->where('level', 'error')->count(),
            'critical' => ActivityLog::where('created_at', '>=', $since)->where('level', 'critical')->count(),
        ];
    }

    private function getErrorLogStats()
    {
        // TODO: Implementare statistiche errori da file log
        return [
            'total' => 0,
            'errors' => 0,
            'warnings' => 0,
        ];
    }

    public function getCategoriesProperty()
    {
        return ActivityLog::distinct()->pluck('category')->sort()->values();
    }

    public function getUsersProperty()
    {
        return ActivityLog::with('user')
            ->whereNotNull('user_id')
            ->distinct()
            ->pluck('user_id')
            ->map(function($userId) {
                $log = ActivityLog::where('user_id', $userId)->first();
                return [
                    'id' => $userId,
                    'name' => $log->user->name ?? 'Unknown'
                ];
            })
            ->sortBy('name')
            ->values();
    }

    public function showLog($logId)
    {
        $this->selectedLog = ActivityLog::with('user')->findOrFail($logId);
        $this->showLogModal = true;
    }

    public function closeLogModal()
    {
        $this->showLogModal = false;
        $this->selectedLog = null;
    }

    public function clearLogs()
    {
        try {
            $since = Carbon::now()->subHours($this->hours);
            
            if ($this->type === 'activity') {
                ActivityLog::where('created_at', '>=', $since)->delete();
            } else {
                // TODO: Implementare pulizia file log
            }

            session()->flash('message', 'Log cancellati con successo');
            $this->resetPage();
        } catch (\Exception $e) {
            session()->flash('error', 'Errore durante la cancellazione: ' . $e->getMessage());
        }
    }

    public function render()
    {
        if ($this->type === 'activity') {
            $query = ActivityLog::with('user');

            // Filtro tempo
            if ($this->hours > 0) {
                $since = Carbon::now()->subHours($this->hours);
                $query->where('created_at', '>=', $since);
            }

            // Filtri
            if ($this->level !== 'all') {
                $query->where('level', $this->level);
            }

            if ($this->category !== 'all') {
                $query->where('category', $this->category);
            }

            if ($this->user !== 'all') {
                $query->where('user_id', $this->user);
            }

            $logs = $query->orderBy('created_at', 'desc')->paginate(50);
        } else {
            // TODO: Implementare visualizzazione error log da file
            $logs = collect([]);
        }

        return view('livewire.admin.logs.log-list', [
            'logs' => $logs,
        ])->layout('components.layouts.app');
    }
}

