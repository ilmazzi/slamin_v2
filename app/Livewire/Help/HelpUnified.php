<?php

namespace App\Livewire\Help;

use Livewire\Component;
use App\Models\Help;

class HelpUnified extends Component
{
    public $selectedCategory = 'all';
    public $selectedType = 'all'; // 'all', 'faq', 'help'
    public $search = '';

    public function getHelpsProperty()
    {
        $query = Help::active()
            ->inLocale(app()->getLocale())
            ->ordered();

        if ($this->selectedType !== 'all') {
            $query->ofType($this->selectedType);
        }

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
            ->inLocale(app()->getLocale())
            ->whereNotNull('category')
            ->distinct()
            ->pluck('category')
            ->sort()
            ->values();
    }

    public function getFaqsProperty()
    {
        return $this->helps->where('type', 'faq');
    }

    public function getHelpItemsProperty()
    {
        return $this->helps->where('type', 'help');
    }

    public function render()
    {
        return view('livewire.help.help-unified', [
            'helps' => $this->helps,
            'faqs' => $this->faqs,
            'helpItems' => $this->helpItems,
            'categories' => $this->categories,
        ])->layout('components.layouts.app');
    }
}

