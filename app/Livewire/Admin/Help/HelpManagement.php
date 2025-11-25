<?php

namespace App\Livewire\Admin\Help;

use Livewire\Component;
use App\Models\Help;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;

class HelpManagement extends Component
{
    use WithPagination;

    public $showModal = false;
    public $editingId = null;
    public $type = 'faq'; // 'help' o 'faq'
    public $locale = 'it';
    public $title = '';
    public $content = '';
    public $category = '';
    public $order = 0;
    public $isActive = true;
    public $filterType = 'all'; // 'all', 'faq', 'help'
    public $filterLocale = 'all'; // 'all' o codice lingua
    public $search = '';

    protected $paginationTheme = 'tailwind';

    protected function rules()
    {
        return [
            'type' => 'required|in:help,faq',
            'locale' => 'required|string|max:5',
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category' => 'nullable|string|max:100',
            'order' => 'required|integer|min:0',
            'isActive' => 'boolean',
        ];
    }

    public function mount()
    {
        if (!Auth::check() || !Auth::user()->hasRole('admin')) {
            abort(403, 'Accesso negato');
        }
    }

    public function openModal($id = null)
    {
        $this->resetForm();
        if ($id) {
            $help = Help::findOrFail($id);
            $this->editingId = $help->id;
            $this->type = $help->type;
            $this->locale = $help->locale;
            $this->title = $help->title;
            $this->content = $help->content;
            $this->category = $help->category ?? '';
            $this->order = $help->order;
            $this->isActive = $help->is_active;
        } else {
            $this->type = $this->filterType !== 'all' ? $this->filterType : 'faq';
            $this->locale = $this->filterLocale !== 'all' ? $this->filterLocale : app()->getLocale();
        }
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->editingId = null;
        $this->type = 'faq';
        $this->locale = app()->getLocale();
        $this->title = '';
        $this->content = '';
        $this->category = '';
        $this->order = 0;
        $this->isActive = true;
    }

    public function save()
    {
        $this->validate();

        Help::updateOrCreate(
            ['id' => $this->editingId],
            [
                'type' => $this->type,
                'locale' => $this->locale,
                'title' => $this->title,
                'content' => $this->content,
                'category' => $this->category ?: null,
                'order' => $this->order,
                'is_active' => $this->isActive,
                'created_by' => Auth::id(),
            ]
        );

        session()->flash('success', $this->editingId ? __('admin.help.updated') : __('admin.help.created'));
        $this->closeModal();
    }

    public function delete($id)
    {
        Help::findOrFail($id)->delete();
        session()->flash('success', __('admin.help.deleted'));
    }

    public function toggleActive($id)
    {
        $help = Help::findOrFail($id);
        $help->update(['is_active' => !$help->is_active]);
        session()->flash('success', __('admin.help.status_updated'));
    }

    public function getHelpsProperty()
    {
        $query = Help::query();

        if ($this->filterType !== 'all') {
            $query->where('type', $this->filterType);
        }

        if ($this->filterLocale !== 'all') {
            $query->where('locale', $this->filterLocale);
        }

        if ($this->search) {
            $query->where(function($q) {
                $q->where('title', 'like', '%' . $this->search . '%')
                  ->orWhere('content', 'like', '%' . $this->search . '%')
                  ->orWhere('category', 'like', '%' . $this->search . '%');
            });
        }

        return $query->orderBy('order')->orderBy('created_at', 'desc')->paginate(15);
    }

    public function getLanguagesProperty()
    {
        return \App\Helpers\LanguageHelper::getAvailableLanguages();
    }

    public function getCategoriesProperty()
    {
        return Help::whereNotNull('category')
            ->distinct()
            ->pluck('category')
            ->sort()
            ->values();
    }

    public function render()
    {
        return view('livewire.admin.help.help-management', [
            'helps' => $this->helps,
            'categories' => $this->categories,
            'languages' => $this->languages,
        ])->layout('components.layouts.app');
    }
}

