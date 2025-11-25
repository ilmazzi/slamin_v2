<?php

namespace App\Livewire\Admin\Carousels;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Livewire\Attributes\Url;
use App\Models\Carousel;
use App\Models\Video;
use App\Models\Event;
use App\Models\User;
use App\Models\Poem;
use App\Models\Article;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CarouselList extends Component
{
    use WithPagination, WithFileUploads;

    #[Url]
    public $search = '';

    // Modal create/edit
    public $showModal = false;
    public $isEditing = false;
    public $editingCarouselId = null;

    // Form fields
    public $title = '';
    public $description = '';
    public $content_type = '';
    public $content_id = null;
    public $image;
    public $existing_image = null;
    public $video;
    public $existing_video = null;
    public $link_url = '';
    public $link_text = '';
    public $order = 0;
    public $is_active = true;
    public $start_date = '';
    public $end_date = '';
    public $use_original_image = true;

    // Content search
    public $contentSearch = '';
    public $contentSearchResults = [];
    public $showContentSearch = false;

    public function mount()
    {
        if (!Auth::check() || !Auth::user()->hasRole('admin')) {
            abort(403, 'Accesso negato');
        }
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function create()
    {
        $this->resetForm();
        $this->isEditing = false;
        $this->showModal = true;
    }

    public function edit($carouselId)
    {
        $carousel = Carousel::findOrFail($carouselId);
        $this->editingCarouselId = $carousel->id;
        $this->title = $carousel->title ?? '';
        $this->description = $carousel->description ?? '';
        $this->content_type = $carousel->content_type ?? '';
        $this->content_id = $carousel->content_id;
        $this->existing_image = $carousel->image_path;
        $this->existing_video = $carousel->video_path;
        $this->link_url = $carousel->link_url ?? '';
        $this->link_text = $carousel->link_text ?? '';
        $this->order = $carousel->order ?? 0;
        $this->is_active = $carousel->is_active ?? true;
        $this->start_date = $carousel->start_date ? $carousel->start_date->format('Y-m-d') : '';
        $this->end_date = $carousel->end_date ? $carousel->end_date->format('Y-m-d') : '';
        $this->use_original_image = empty($carousel->image_path) || $carousel->isContentReference();
        $this->isEditing = true;
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->isEditing = false;
        $this->editingCarouselId = null;
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->reset([
            'title', 'description', 'content_type', 'content_id',
            'image', 'existing_image', 'video', 'existing_video',
            'link_url', 'link_text', 'order', 'is_active',
            'start_date', 'end_date', 'use_original_image',
            'contentSearch', 'contentSearchResults', 'showContentSearch'
        ]);
    }

    public function searchContent()
    {
        if (strlen($this->contentSearch) < 2) {
            $this->contentSearchResults = [];
            return;
        }

        $this->contentSearchResults = [];
        $search = '%' . $this->contentSearch . '%';

        // Cerca in base al content_type selezionato
        if ($this->content_type) {
            switch ($this->content_type) {
                case 'video':
                    $this->contentSearchResults = Video::where('title', 'like', $search)
                        ->limit(10)
                        ->get()
                        ->map(fn($v) => ['id' => $v->id, 'title' => $v->title, 'type' => 'video']);
                    break;
                case 'event':
                    $this->contentSearchResults = Event::where('title', 'like', $search)
                        ->limit(10)
                        ->get()
                        ->map(fn($e) => ['id' => $e->id, 'title' => $e->title, 'type' => 'event']);
                    break;
                case 'poem':
                    $this->contentSearchResults = Poem::whereRaw("JSON_EXTRACT(title, '$.it') LIKE ?", [$search])
                        ->limit(10)
                        ->get()
                        ->map(fn($p) => ['id' => $p->id, 'title' => $p->title['it'] ?? 'N/A', 'type' => 'poem']);
                    break;
                case 'article':
                    $this->contentSearchResults = Article::whereRaw("JSON_EXTRACT(title, '$.it') LIKE ?", [$search])
                        ->limit(10)
                        ->get()
                        ->map(fn($a) => ['id' => $a->id, 'title' => $a->title['it'] ?? 'N/A', 'type' => 'article']);
                    break;
            }
        }
    }

    public function selectContent($contentId)
    {
        $this->content_id = $contentId;
        $this->contentSearch = '';
        $this->contentSearchResults = [];
        $this->showContentSearch = false;
    }

    public function save()
    {
        // Validazione in base a se è contenuto referenziato o upload
        if ($this->content_type && $this->content_id) {
            // Contenuto referenziato
            $this->validate([
                'content_type' => 'required|string|in:video,event,user,poem,article',
                'content_id' => 'required|integer',
                'title' => 'nullable|string|max:255',
                'description' => 'nullable|string|max:1000',
                'link_url' => 'nullable|url|max:255',
                'link_text' => 'nullable|string|max:100',
                'order' => 'nullable|integer|min:0',
                'is_active' => 'boolean',
                'start_date' => 'nullable|date',
                'end_date' => 'nullable|date|after:start_date',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);
        } else {
            // Upload tradizionale
            $this->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string|max:1000',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
                'video' => 'nullable|file|mimes:mp4,avi,mov,mkv,webm,flv|max:10240',
                'link_url' => 'nullable|url|max:255',
                'link_text' => 'nullable|string|max:100',
                'order' => 'nullable|integer|min:0',
                'is_active' => 'boolean',
                'start_date' => 'nullable|date',
                'end_date' => 'nullable|date|after:start_date',
            ]);
        }

        try {
            $data = [
                'title' => $this->title,
                'description' => $this->description,
                'link_url' => $this->link_url,
                'link_text' => $this->link_text,
                'order' => $this->order ?? 0,
                'is_active' => $this->is_active,
                'start_date' => $this->start_date ?: null,
                'end_date' => $this->end_date ?: null,
            ];

            if ($this->content_type && $this->content_id) {
                $data['content_type'] = $this->content_type;
                $data['content_id'] = $this->content_id;
                
                // Gestione immagine per contenuti referenziati
                if (!$this->use_original_image && $this->image) {
                    if ($this->existing_image) {
                        Storage::disk('public')->delete($this->existing_image);
                    }
                    $data['image_path'] = $this->image->store('carousel', 'public');
                } else {
                    $data['image_path'] = null; // Usa immagine originale
                }
            } else {
                // Upload tradizionale
                if ($this->image) {
                    if ($this->existing_image) {
                        Storage::disk('public')->delete($this->existing_image);
                    }
                    $data['image_path'] = $this->image->store('carousel', 'public');
                }

                if ($this->video) {
                    if ($this->existing_video) {
                        Storage::disk('public')->delete($this->existing_video);
                    }
                    $data['video_path'] = $this->video->store('carousel', 'public');
                }
            }

            if ($this->isEditing) {
                $carousel = Carousel::findOrFail($this->editingCarouselId);
                $carousel->update($data);
                $carousel->updateContentCache();
            } else {
                $carousel = Carousel::create($data);
                $carousel->updateContentCache();
            }

            session()->flash('message', $this->isEditing ? __('admin.sections.carousels.messages.updated') : __('admin.sections.carousels.messages.created'));
            $this->closeModal();
        } catch (\Exception $e) {
            session()->flash('error', 'Errore durante il salvataggio: ' . $e->getMessage());
        }
    }

    public function delete($carouselId)
    {
        $carousel = Carousel::findOrFail($carouselId);

        if ($carousel->image_path) {
            Storage::disk('public')->delete($carousel->image_path);
        }

        if ($carousel->video_path) {
            Storage::disk('public')->delete($carousel->video_path);
        }

        $carousel->delete();

        session()->flash('message', __('admin.sections.carousels.messages.deleted'));
    }

    public function toggleActive($carouselId)
    {
        $carousel = Carousel::findOrFail($carouselId);
        $carousel->update(['is_active' => !$carousel->is_active]);
        session()->flash('message', $carousel->is_active ? __('admin.sections.carousels.messages.activated') : __('admin.sections.carousels.messages.deactivated'));
    }

    public function updateOrder($carouselIds)
    {
        foreach ($carouselIds as $index => $carouselId) {
            Carousel::where('id', $carouselId)->update(['order' => $index]);
        }

        session()->flash('message', __('admin.sections.carousels.messages.order_updated'));
    }

    public function getAvailableContentTypesProperty()
    {
        return [
            'video' => __('admin.sections.carousels.form.content_type_video'),
            'event' => __('admin.sections.carousels.form.content_type_event'),
            'user' => __('admin.sections.carousels.form.content_type_user'),
            'poem' => __('admin.sections.carousels.form.content_type_poem'),
            'article' => __('admin.sections.carousels.form.content_type_article'),
        ];
    }

    public function render()
    {
        $query = Carousel::query()
            ->orderBy('order', 'asc');

        if ($this->search) {
            $query->where('title', 'like', '%' . $this->search . '%')
                  ->orWhere('description', 'like', '%' . $this->search . '%');
        }

        $carousels = $query->paginate(20);

        return view('livewire.admin.carousels.carousel-list', [
            'carousels' => $carousels,
        ])->layout('components.layouts.app');
    }
}

