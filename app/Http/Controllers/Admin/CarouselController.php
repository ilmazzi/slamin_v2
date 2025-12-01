<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Carousel;
use App\Models\Video;
use App\Models\Event;
use App\Models\Poem;
use App\Models\Article;

class CarouselController extends Controller
{
    public function addToCarousel($type, $id)
    {
        if (!Auth::check() || !Auth::user()->hasRole(['admin', 'editor'])) {
            abort(403, 'Accesso negato');
        }

        // Verifica che il contenuto esista
        $contentExists = false;
        switch ($type) {
            case 'video':
                $contentExists = Video::find($id) !== null;
                break;
            case 'event':
                $contentExists = Event::find($id) !== null;
                break;
            case 'poem':
                $contentExists = Poem::find($id) !== null;
                break;
            case 'article':
                $contentExists = Article::find($id) !== null;
                break;
        }

        if (!$contentExists) {
            return redirect()->back()->with('error', __('admin.sections.carousels.messages.content_not_found'));
        }

        // Crea la slide del carousel
        $carousel = Carousel::create([
            'content_type' => $type,
            'content_id' => $id,
            'title' => null, // Verrà preso dal contenuto
            'description' => null,
            'order' => Carousel::max('order') + 1,
            'is_active' => true,
            'use_original_image' => true,
        ]);

        $carousel->updateContentCache();

        return redirect()->route('admin.carousels.index')->with('message', __('admin.sections.carousels.messages.added_to_carousel'));
    }
}
