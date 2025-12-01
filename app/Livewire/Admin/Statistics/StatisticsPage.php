<?php

namespace App\Livewire\Admin\Statistics;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Services\Statistics\UserStatistics;
use App\Services\Statistics\EventStatistics;
use App\Services\Statistics\ContentStatistics;
use App\Services\Statistics\GroupStatistics;
use App\Services\Statistics\ForumStatistics;
use App\Services\Statistics\GigStatistics;
use App\Services\Statistics\OtherStatistics;

class StatisticsPage extends Component
{
    public $cacheMinutes = 15;
    public $refreshKey = 1;

    public function mount()
    {
        if (!Auth::check() || !Auth::user()->hasRole('admin')) {
            abort(403, 'Accesso negato');
        }
    }

    public function refresh()
    {
        // Invalida tutte le cache delle statistiche
        \Illuminate\Support\Facades\Cache::forget('statistics:users:all');
        \Illuminate\Support\Facades\Cache::forget('statistics:events:all');
        \Illuminate\Support\Facades\Cache::forget('statistics:content:all');
        \Illuminate\Support\Facades\Cache::forget('statistics:groups:all');
        \Illuminate\Support\Facades\Cache::forget('statistics:forum:all');
        \Illuminate\Support\Facades\Cache::forget('statistics:gigs:all');
        \Illuminate\Support\Facades\Cache::forget('statistics:other:all');
        
        $this->refreshKey++;
        session()->flash('message', __('admin.statistics.refreshed'));
    }

    public function getUserStatsProperty()
    {
        return UserStatistics::getAll($this->cacheMinutes);
    }

    public function getEventStatsProperty()
    {
        return EventStatistics::getAll($this->cacheMinutes);
    }

    public function getContentStatsProperty()
    {
        return ContentStatistics::getAll($this->cacheMinutes);
    }

    public function getGroupStatsProperty()
    {
        return GroupStatistics::getAll($this->cacheMinutes);
    }

    public function getForumStatsProperty()
    {
        return ForumStatistics::getAll($this->cacheMinutes);
    }

    public function getGigStatsProperty()
    {
        return GigStatistics::getAll($this->cacheMinutes);
    }

    public function getOtherStatsProperty()
    {
        return OtherStatistics::getAll($this->cacheMinutes);
    }

    public function render()
    {
        return view('livewire.admin.statistics.statistics-page')
            ->layout('components.layouts.app')
            ->title(__('admin.statistics.title'));
    }
}

