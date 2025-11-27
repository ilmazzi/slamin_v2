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
        // Non filtriamo per locale perché le traduzioni sono nella tabella help_translations
        // Il modello usa gli accessor translated_title e translated_content
        $query = Help::active()
            ->ofType('faq')
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
        // Non filtriamo per locale perché le categorie sono le stesse per tutte le lingue
        return Help::active()
            ->ofType('faq')
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

