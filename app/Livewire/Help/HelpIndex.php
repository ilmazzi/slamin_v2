<?php

namespace App\Livewire\Help;

use Livewire\Component;
use App\Models\Help;

class HelpIndex extends Component
{
    public $selectedCategory = 'all';
    public $search = '';

    public function getHelpsProperty()
    {
        $query = Help::active()
            ->ofType('help')
            ->inLocale(app()->getLocale())
            ->ordered();

        if ($this->selectedCategory !== 'all') {
            $query->where('category', $this->selectedCategory);
        }

        if ($this->search) {
            $query->where(function($q) {
                $q->where('title', 'like', '%' . $this->search . '%')
                  ->orWhere('content', 'like', '%' . $this->search . '%');
            });
        }

        return $query->get();
    }

    public function getCategoriesProperty()
    {
        return Help::active()
            ->ofType('help')
            ->inLocale(app()->getLocale())
            ->whereNotNull('category')
            ->distinct()
            ->pluck('category')
            ->sort()
            ->values();
    }

    public function render()
    {
        return view('livewire.help.help-index', [
            'helps' => $this->helps,
            'categories' => $this->categories,
        ])->layout('components.layouts.app');
    }
}

