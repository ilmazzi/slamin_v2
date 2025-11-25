<?php

namespace App\Livewire\Help;

use Livewire\Component;
use App\Models\Help;

class FaqIndex extends Component
{
    public $selectedCategory = 'all';
    public $search = '';

    public function getFaqsProperty()
    {
        $query = Help::active()
            ->ofType('faq')
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
            ->ofType('faq')
            ->inLocale(app()->getLocale())
            ->whereNotNull('category')
            ->distinct()
            ->pluck('category')
            ->sort()
            ->values();
    }

    public function render()
    {
        return view('livewire.help.faq-index', [
            'faqs' => $this->faqs,
            'categories' => $this->categories,
        ])->layout('components.layouts.app');
    }
}

