<?php

namespace App\Livewire\Media;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use App\Models\Photo;
use App\Models\SystemSetting;
use App\Services\ImageService;

class PhotoUpload extends Component
{
    use WithFileUploads;

    public $title = '';
    public $description = '';
    public $alt_text = '';
    public $photo_file = null;
    public $photoPreview = null;

    protected function rules()
    {
        $maxSize = SystemSetting::get('image_max_size', 10240); // Default 10MB in KB
        
        return [
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:1000',
            'alt_text' => 'nullable|string|max:255',
            'photo_file' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:' . $maxSize,
        ];
    }

    public function mount()
    {
        $user = Auth::user();

        // Verifica permessi
        if (!$user->canUploadPhoto()) {
            abort(403, __('media.upload_not_allowed'));
        }

        // Verifica limiti upload
        if (!$user->canUploadMorePhotos()) {
            return $this->redirect(route('media.upload-limit'), navigate: false);
        }
    }

    public function updatedPhotoFile()
    {
        $this->validateOnly('photo_file');
        
        if ($this->photo_file) {
            $this->photoPreview = $this->photo_file->temporaryUrl();
        }
    }

    public function submitUpload()
    {
        $user = Auth::user();

        // Verifica che il file foto sia presente
        if (!$this->photo_file) {
            $this->addError('photo_file', __('media.photo_file_required'));
            return;
        }

        // Verifica limiti prima dell'upload
        if (!$user->canUploadMorePhotos()) {
            $this->addError('limit', __('media.upload_limit_reached'));
            return $this->redirect(route('media.upload-limit'), navigate: false);
        }

        // Validazione
        try {
            $validated = $this->validate();
        } catch (\Illuminate\Validation\ValidationException $e) {
            throw $e;
        }

        try {
            Log::info('📸 Inizio upload foto Livewire', [
                'user_id' => $user->id,
                'title' => $this->title
            ]);

            // Usa ImageService per processare e salvare l'immagine
            $imageService = app(ImageService::class);
            $photoPath = $imageService->organizeUserPhotos($user->id);
            
            // Converti e salva l'immagine in WebP
            $imageData = $imageService->convertAndSaveImage(
                $this->photo_file,
                $photoPath,
                85 // Qualità WebP
            );

            Log::info('✅ Immagine salvata', [
                'path' => $imageData['path'],
                'width' => $imageData['width'],
                'height' => $imageData['height']
            ]);

            // Crea thumbnail
            $thumbnailPath = 'photos/users/' . $user->id . '/thumbnails/' . $imageData['filename'];
            $thumbnailData = $imageService->createThumbnail(
                $imageData['path'],
                $thumbnailPath,
                300,
                300
            );

            Log::info('✅ Thumbnail creato', [
                'path' => $thumbnailData['path']
            ]);

            // Prepara metadati
            $metadata = [
                'width' => $imageData['width'],
                'height' => $imageData['height'],
                'size' => $imageData['size'],
                'mime_type' => $imageData['mime_type'],
                'original_name' => $this->photo_file->getClientOriginalName(),
            ];

            // Crea record foto
            $photo = Photo::create([
                'user_id' => $user->id,
                'title' => $this->title ?: null,
                'description' => $this->description ?: null,
                'alt_text' => $this->alt_text ?: null,
                'image_path' => $imageData['path'],
                'thumbnail_path' => $thumbnailData['path'],
                'status' => 'approved', // Le foto sono approvate di default (o 'pending' se serve moderazione)
                'moderation_status' => 'approved',
                'metadata' => $metadata,
            ]);

            Log::info('✅ Foto creata nel database', [
                'photo_id' => $photo->id,
                'user_id' => $user->id
            ]);

            session()->flash('success', __('media.photo_uploaded_successfully'));
            
            // Reset form
            $this->reset(['title', 'description', 'alt_text', 'photo_file', 'photoPreview']);

            // Redirect
            $this->redirect(route('media.index'), navigate: true);

        } catch (\Exception $e) {
            Log::error('💥 Errore critico durante upload foto', [
                'user_id' => $user->id,
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);

            $this->addError('upload', __('media.upload_error') . ': ' . $e->getMessage());
        }
    }
    
    public function render()
    {
        $user = Auth::user();
        $maxSize = SystemSetting::get('image_max_size', 10240); // Default 10MB in KB
        
        return view('livewire.media.photo-upload', [
            'user' => $user,
            'currentPhotoCount' => $user->current_photo_count,
            'currentPhotoLimit' => $user->current_photo_limit,
            'remainingUploads' => $user->remaining_photo_uploads,
            'maxSizeMB' => round($maxSize / 1024, 1), // Converti in MB per la visualizzazione
        ]);
    }
}

