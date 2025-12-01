<?php

namespace App\Livewire\Admin\Categories;

use App\Models\ArticleCategory;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Str;

class ArticleCategoryList extends Component
{
    use WithPagination;

    public $showModal = false;
    public $editingId = null;
    
    // Form fields
    public $name_it = '';
    public $name_en = '';
    public $name_fr = '';
    public $description_it = '';
    public $description_en = '';
    public $description_fr = '';
    public $slug = '';
    public $color = '#007bff';
    public $icon = '';
    public $is_active = true;
    public $sort_order = 0;
    
    // Search
    public $search = '';

    protected function rules()
    {
        $rules = [
            'name_it' => 'required|string|max:255',
            'name_en' => 'nullable|string|max:255',
            'name_fr' => 'nullable|string|max:255',
            'description_it' => 'nullable|string',
            'description_en' => 'nullable|string',
            'description_fr' => 'nullable|string',
            'slug' => 'required|string|max:255|unique:article_categories,slug',
            'color' => 'required|string|max:7',
            'icon' => 'nullable|string|max:255',
            'is_active' => 'boolean',
            'sort_order' => 'integer|min:0',
        ];

        if ($this->editingId) {
            $rules['slug'] = 'required|string|max:255|unique:article_categories,slug,' . $this->editingId;
        }

        return $rules;
    }

    public function updatedNameIt()
    {
        if (!$this->editingId) {
            $this->slug = Str::slug($this->name_it);
        }
    }

    public function openCreateModal()
    {
        $this->resetForm();
        $this->showModal = true;
    }

    public function openEditModal($id)
    {
        $category = ArticleCategory::findOrFail($id);
        
        $this->editingId = $category->id;
        
        $nameTranslations = $category->name_translations;
        $this->name_it = $nameTranslations['it'] ?? '';
        $this->name_en = $nameTranslations['en'] ?? '';
        $this->name_fr = $nameTranslations['fr'] ?? '';
        
        $description = is_string($category->description) ? json_decode($category->description, true) : $category->description;
        $this->description_it = $description['it'] ?? '';
        $this->description_en = $description['en'] ?? '';
        $this->description_fr = $description['fr'] ?? '';
        
        $this->slug = $category->slug;
        $this->color = $category->color;
        $this->icon = $category->icon ?? '';
        $this->is_active = $category->is_active;
        $this->sort_order = $category->sort_order;
        
        $this->showModal = true;
    }

    public function save()
    {
        $this->validate();

        $data = [
            'name' => [
                'it' => $this->name_it,
                'en' => $this->name_en ?: $this->name_it,
                'fr' => $this->name_fr ?: $this->name_it,
            ],
            'description' => [
                'it' => $this->description_it,
                'en' => $this->description_en ?: $this->description_it,
                'fr' => $this->description_fr ?: $this->description_it,
            ],
            'slug' => $this->slug,
            'color' => $this->color,
            'icon' => $this->icon,
            'is_active' => $this->is_active,
            'sort_order' => $this->sort_order,
        ];

        if ($this->editingId) {
            $category = ArticleCategory::findOrFail($this->editingId);
            $category->update($data);
            session()->flash('message', 'Categoria aggiornata con successo!');
        } else {
            ArticleCategory::create($data);
            session()->flash('message', 'Categoria creata con successo!');
        }

        $this->closeModal();
    }

    public function delete($id)
    {
        $category = ArticleCategory::findOrFail($id);
        
        if ($category->articles()->count() > 0) {
            session()->flash('error', 'Impossibile eliminare: ci sono articoli associati a questa categoria.');
            return;
        }
        
        $category->delete();
        session()->flash('message', 'Categoria eliminata con successo!');
    }

    public function toggleActive($id)
    {
        $category = ArticleCategory::findOrFail($id);
        $category->update(['is_active' => !$category->is_active]);
        
        session()->flash('message', 'Stato categoria aggiornato!');
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetForm();
    }

    private function resetForm()
    {
        $this->editingId = null;
        $this->name_it = '';
        $this->name_en = '';
        $this->name_fr = '';
        $this->description_it = '';
        $this->description_en = '';
        $this->description_fr = '';
        $this->slug = '';
        $this->color = '#007bff';
        $this->icon = '';
        $this->is_active = true;
        $this->sort_order = 0;
        $this->resetErrorBag();
    }

    public function render()
    {
        $categories = ArticleCategory::query()
            ->when($this->search, function($query) {
                $query->where('slug', 'like', '%' . $this->search . '%');
            })
            ->orderBy('sort_order')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('livewire.admin.categories.article-category-list', [
            'categories' => $categories
        ])->layout('components.layouts.app')->title('Gestione Categorie Articoli');
    }
}
