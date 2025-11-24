<?php

namespace App\Livewire\Forum;

use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\WithFileUploads;
use App\Models\Subreddit;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class SubredditSettings extends Component
{
    use WithFileUploads;

    public Subreddit $subreddit;
    public $name;
    public $description;
    public $rules;
    public $color;
    public $is_private;
    public $icon;
    public $banner;

    public function mount(Subreddit $subreddit)
    {
        // Only admins can edit settings
        if (!$subreddit->isAdmin(Auth::user())) {
            abort(403, 'Solo gli admin possono modificare le impostazioni');
        }

        $this->subreddit = $subreddit;
        $this->name = $subreddit->name;
        $this->description = $subreddit->description;
        $this->rules = $subreddit->rules;
        $this->color = $subreddit->color;
        $this->is_private = $subreddit->is_private;
    }

    public function title(): string
    {
        return 'Impostazioni - ' . $this->subreddit->name;
    }

    public function updateSettings()
    {
        $this->validate([
            'name' => 'required|string|min:3|max:50|unique:subreddits,name,' . $this->subreddit->id,
            'description' => 'required|string|min:10|max:500',
            'rules' => 'nullable|string|max:5000',
            'color' => 'required|regex:/^#[0-9A-Fa-f]{6}$/',
            'is_private' => 'boolean',
            'icon' => 'nullable|image|max:2048',
            'banner' => 'nullable|image|max:5120',
        ]);

        $data = [
            'name' => $this->name,
            'description' => $this->description,
            'rules' => $this->rules,
            'color' => $this->color,
            'is_private' => $this->is_private,
        ];

        // Handle icon upload
        if ($this->icon) {
            // Delete old icon
            if ($this->subreddit->icon) {
                Storage::disk('public')->delete($this->subreddit->icon);
            }

            $manager = new ImageManager(new Driver());
            $image = $manager->read($this->icon->getRealPath());
            
            // Resize to square 256x256
            $image->cover(256, 256);
            
            $filename = 'subreddit_icon_' . $this->subreddit->id . '.webp';
            $path = 'forum/icons/' . $filename;
            
            Storage::disk('public')->put($path, $image->toWebp(85));
            $data['icon'] = $path;
        }

        // Handle banner upload
        if ($this->banner) {
            // Delete old banner
            if ($this->subreddit->banner) {
                Storage::disk('public')->delete($this->subreddit->banner);
            }

            $manager = new ImageManager(new Driver());
            $image = $manager->read($this->banner->getRealPath());
            
            // Resize to 1920x384 (banner ratio)
            $image->cover(1920, 384);
            
            $filename = 'subreddit_banner_' . $this->subreddit->id . '.webp';
            $path = 'forum/banners/' . $filename;
            
            Storage::disk('public')->put($path, $image->toWebp(85));
            $data['banner'] = $path;
        }

        $this->subreddit->update($data);

        session()->flash('success', 'Impostazioni aggiornate');
        
        return $this->redirect(route('forum.subreddit.show', $this->subreddit), navigate: true);
    }

    public function deleteSubreddit()
    {
        // Only creator or site admin can delete
        if ($this->subreddit->created_by !== Auth::id() && !Auth::user()->hasRole('admin')) {
            session()->flash('error', 'Solo il creatore può eliminare il subreddit');
            return;
        }

        $this->subreddit->delete();

        return $this->redirect(route('forum.index'), navigate: true);
    }

    public function render()
    {
        return view('livewire.forum.subreddit-settings');
    }
}

