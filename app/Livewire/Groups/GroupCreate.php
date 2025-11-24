<?php

namespace App\Livewire\Groups;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use App\Models\Group;
use App\Models\GroupMember;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

#[Title('Crea Gruppo')]
class GroupCreate extends Component
{
    use WithFileUploads;

    #[Validate('required|string|min:3|max:255')]
    public $name = '';
    
    #[Validate('nullable|string|max:1000')]
    public $description = '';
    
    #[Validate('nullable|image|max:2048')]
    public $image;
    
    #[Validate('required|in:public,private')]
    public $visibility = 'public';
    
    #[Validate('nullable|url|max:255')]
    public $website = '';
    
    #[Validate('nullable|url|max:255')]
    public $social_facebook = '';
    
    #[Validate('nullable|url|max:255')]
    public $social_instagram = '';
    
    #[Validate('nullable|url|max:255')]
    public $social_youtube = '';
    
    #[Validate('nullable|url|max:255')]
    public $social_twitter = '';
    
    #[Validate('nullable|url|max:255')]
    public $social_tiktok = '';
    
    #[Validate('nullable|url|max:255')]
    public $social_linkedin = '';

    public function save()
    {
        $this->validate();

        $imagePath = null;
        if ($this->image) {
            $imagePath = $this->image->store('groups', 'public');
        }

        $group = Group::create([
            'name' => $this->name,
            'description' => $this->description,
            'image' => $imagePath,
            'visibility' => $this->visibility,
            'created_by' => Auth::id(),
            'website' => $this->website,
            'social_facebook' => $this->social_facebook,
            'social_instagram' => $this->social_instagram,
            'social_youtube' => $this->social_youtube,
            'social_twitter' => $this->social_twitter,
            'social_tiktok' => $this->social_tiktok,
            'social_linkedin' => $this->social_linkedin,
        ]);

        // Il creatore viene aggiunto automaticamente come admin dal GroupObserver

        session()->flash('success', __('groups.group_created'));
        
        return $this->redirect(route('groups.show', $group), navigate: true);
    }

    public function render()
    {
        return view('livewire.groups.group-create');
    }
}
