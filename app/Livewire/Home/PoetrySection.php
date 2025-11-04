<?php

namespace App\Livewire\Home;

use Livewire\Component;
use App\Models\Poem;
use App\Models\UnifiedLike;
use Illuminate\Support\Facades\Auth;

class PoetrySection extends Component
{
    public $contentType = 'new'; // 'new' o 'popular'

    public function toggleContent($type)
    {
        $this->contentType = $type;
    }

    public function render()
    {
        if ($this->contentType === 'popular') {
            $poems = Poem::where('moderation_status', 'approved')
                ->where('is_public', true)
                ->with('user')
                ->withCount(['views', 'likes', 'comments'])
                ->orderBy('views_count', 'desc')
                ->limit(6)
                ->get();
        } else {
            $poems = Poem::where('moderation_status', 'approved')
                ->where('is_public', true)
                ->with('user')
                ->withCount(['views', 'likes', 'comments'])
                ->orderBy('created_at', 'desc')
                ->limit(6)
                ->get();
        }
        
        // Check if user has liked each poem
        if (Auth::check()) {
            foreach ($poems as $poem) {
                $poem->is_liked = UnifiedLike::where('user_id', Auth::id())
                    ->where('likeable_type', Poem::class)
                    ->where('likeable_id', $poem->id)
                    ->exists();
            }
        } else {
            foreach ($poems as $poem) {
                $poem->is_liked = false;
            }
        }
        
        return view('livewire.home.poetry-section', [
            'poems' => $poems
        ]);
    }
}
