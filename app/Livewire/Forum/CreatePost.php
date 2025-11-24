<?php

namespace App\Livewire\Forum;

use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\WithFileUploads;
use App\Models\Subreddit;
use App\Models\ForumPost;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class CreatePost extends Component
{
    use WithFileUploads;

    public Subreddit $subreddit;
    public $postType = 'text'; // text, link, image
    public $title = '';
    public $content = '';
    public $url = '';
    public $image;
    public $imagePreview;

    #[Title('Crea Post - Forum')]

    public function mount(Subreddit $subreddit)
    {
        if (!Auth::check()) {
            return $this->redirect(route('login'));
        }

        $this->subreddit = $subreddit;

        if (!$subreddit->canPost(Auth::user())) {
            abort(403, 'Non puoi pubblicare in questo subreddit');
        }
    }

    public function updatedPostType()
    {
        // Reset fields when type changes
        $this->content = '';
        $this->url = '';
        $this->image = null;
        $this->imagePreview = null;
    }

    public function updatedImage()
    {
        $this->validate([
            'image' => 'image|max:10240',
        ]);

        $this->imagePreview = $this->image->temporaryUrl();
    }

    public function createPost()
    {
        $rules = [
            'title' => 'required|string|min:3|max:300',
        ];

        if ($this->postType === 'text') {
            $rules['content'] = 'required|string|min:1|max:40000';
        } elseif ($this->postType === 'link') {
            $rules['url'] = 'required|url|max:2000';
        } elseif ($this->postType === 'image') {
            $rules['image'] = 'required|image|max:10240'; // 10MB
        }

        $this->validate($rules);

        $postData = [
            'subreddit_id' => $this->subreddit->id,
            'user_id' => Auth::id(),
            'title' => $this->title,
            'type' => $this->postType,
        ];

        if ($this->postType === 'text') {
            $postData['content'] = $this->content;
        } elseif ($this->postType === 'link') {
            $postData['url'] = $this->url;
        } elseif ($this->postType === 'image' && $this->image) {
            // Process and save image as WebP
            $manager = new ImageManager(new Driver());
            $image = $manager->read($this->image->getRealPath());

            // Resize if too large
            if ($image->width() > 1920 || $image->height() > 1920) {
                $image->scale(width: 1920);
            }

            // Save as WebP
            $filename = uniqid('forum_') . '.webp';
            $path = 'forum/images/' . $filename;
            
            Storage::disk('public')->put($path, $image->toWebp(85));

            $postData['image_path'] = $path;
            $postData['original_image_name'] = $this->image->getClientOriginalName();
        }

        $post = ForumPost::create($postData);

        $this->subreddit->incrementPostsCount();

        return $this->redirect(route('forum.post.show', [$this->subreddit, $post]), navigate: true);
    }

    public function render()
    {
        return view('livewire.forum.create-post');
    }
}

