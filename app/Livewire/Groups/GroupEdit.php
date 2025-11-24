<?php

namespace App\Livewire\Groups;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use App\Models\Group;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

#[Title('Modifica Gruppo')]
class GroupEdit extends Component
{
    use WithFileUploads, AuthorizesRequests;

    public Group $group;
    
    #[Validate('required|string|min:3|max:255')]
    public $name;
    
    #[Validate('nullable|string|max:1000')]
    public $description;
    
    #[Validate('nullable|image|max:2048')]
    public $image;
    
    #[Validate('required|in:public,private')]
    public $visibility;
    
    #[Validate('nullable|url|max:255')]
    public $website;
    
    #[Validate('nullable|url|max:255')]
    public $social_facebook;
    
    #[Validate('nullable|url|max:255')]
    public $social_instagram;
    
    #[Validate('nullable|url|max:255')]
    public $social_youtube;
    
    #[Validate('nullable|url|max:255')]
    public $social_twitter;
    
    #[Validate('nullable|url|max:255')]
    public $social_tiktok;
    
    #[Validate('nullable|url|max:255')]
    public $social_linkedin;

    public function mount(Group $group)
    {
        // Verifica che l'utente sia admin del gruppo
        if (!$group->hasAdmin(Auth::user())) {
            abort(403);
        }

        $this->group = $group;
        $this->name = $group->name;
        $this->description = $group->description;
        $this->visibility = $group->visibility;
        $this->website = $group->website;
        $this->social_facebook = $group->social_facebook;
        $this->social_instagram = $group->social_instagram;
        $this->social_youtube = $group->social_youtube;
        $this->social_twitter = $group->social_twitter;
        $this->social_tiktok = $group->social_tiktok;
        $this->social_linkedin = $group->social_linkedin;
    }

    public function save()
    {
        $this->validate();

        $data = [
            'name' => $this->name,
            'description' => $this->description,
            'visibility' => $this->visibility,
            'website' => $this->website,
            'social_facebook' => $this->social_facebook,
            'social_instagram' => $this->social_instagram,
            'social_youtube' => $this->social_youtube,
            'social_twitter' => $this->social_twitter,
            'social_tiktok' => $this->social_tiktok,
            'social_linkedin' => $this->social_linkedin,
        ];

        if ($this->image) {
            // Elimina vecchia immagine
            if ($this->group->image) {
                Storage::disk('public')->delete($this->group->image);
            }
            $data['image'] = $this->image->store('groups', 'public');
        }

        $this->group->update($data);

        session()->flash('success', __('groups.group_updated'));
        
        return $this->redirect(route('groups.show', $this->group), navigate: true);
    }

    public function deleteGroup()
    {
        // Verifica che l'utente sia admin
        if (!$this->group->hasAdmin(Auth::user())) {
            abort(403);
        }

        // Elimina immagine
        if ($this->group->image) {
            Storage::disk('public')->delete($this->group->image);
        }

        $this->group->delete();

        session()->flash('success', __('groups.group_deleted'));
        
        return $this->redirect(route('groups.index'), navigate: true);
    }

    public function render()
    {
        return view('livewire.groups.group-edit');
    }
}
