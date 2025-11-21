<?php

namespace App\Livewire\Media;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use App\Models\Video;
use App\Models\SystemSetting;
use App\Services\PeerTubeService;

class VideoUpload extends Component
{
    use WithFileUploads;

    public $title = '';
    public $description = '';
    public $tags = '';
    public $is_public = true;
    public $thumbnail;
    public $video_file = null; // Inizializzato a null per evitare errori

    public $uploadProgress = 0;
    public $isUploading = false;
    public $uploadPhase = '';
    public $isSubmitting = false; // Stato immediato quando si clicca submit

    protected function rules()
    {
        $maxSize = SystemSetting::get('video_max_size', 102400); // Default 100MB in KB
        
        return [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'video_file' => 'required|file|mimes:mp4,avi,mov,mkv,webm,flv|max:' . $maxSize,
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg|max:1024',
            'tags' => 'nullable|string|max:255',
            'is_public' => 'boolean',
        ];
    }

    public function mount()
    {
        $user = Auth::user();

        // Verifica permessi
        if (!$user->canUploadVideo()) {
            abort(403, __('media.upload_not_allowed'));
        }

        // Verifica che l'utente abbia un account PeerTube
        if (!$user->hasPeerTubeAccount()) {
            session()->flash('error', __('media.peertube_account_required'));
            $this->redirect(route('media.index'), navigate: true);
            return;
        }

        // Verifica limiti upload
        if (!$user->canUploadMoreVideos()) {
            $this->redirect(route('media.upload-limit'), navigate: true);
            return;
        }
    }

    public function updatedVideoFile()
    {
        $this->validateOnly('video_file');
    }

    public function updatedThumbnail()
    {
        $this->validateOnly('thumbnail');
    }
    
    public function updatedTitle()
    {
        // Debug: verifica che title venga aggiornato
        Log::info('Title updated', ['title' => $this->title]);
        $this->validateOnly('title');
    }

    public function submitUpload()
    {
        $user = Auth::user();

        // Verifica che il file video sia presente e sia un oggetto valido
        if (!$this->video_file) {
            $this->addError('video_file', __('media.video_file_required'));
            $this->resetUploadState();
            return;
        }

        // Verifica che sia un oggetto con i metodi necessari
        if (!is_object($this->video_file) || !method_exists($this->video_file, 'getClientOriginalName')) {
            Log::error('Video file is not a valid upload object', [
                'type' => gettype($this->video_file),
                'video_file' => $this->video_file
            ]);
            $this->addError('video_file', __('media.video_file_required'));
            $this->resetUploadState();
            return;
        }

        // Imposta stato immediato di invio (mostra feedback subito)
        $this->isSubmitting = true;
        $this->isUploading = true;
        $this->uploadPhase = __('media.preparing_file');
        $this->uploadProgress = 1;

        // Verifica limiti prima dell'upload
        if (!$user->canUploadMoreVideos()) {
            $this->resetUploadState();
            $this->addError('limit', __('media.upload_limit_reached'));
            return;
        }

        // Validazione
        try {
            $validated = $this->validate();
        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->resetUploadState();
            throw $e;
        }

        // Prosegue con l'upload
        $this->uploadPhase = __('media.preparing_file');
        $this->uploadProgress = 5;

        try {
            Log::info('🎬 Inizio upload video Livewire', [
                'user_id' => $user->id,
                'title' => $this->title
            ]);

            // Salva temporaneamente il file video
            $this->uploadPhase = __('media.saving_temp_file');
            $this->uploadProgress = 10;

            $tempPath = $this->video_file->store('temp-videos', 'local');
            $fullTempPath = Storage::disk('local')->path($tempPath);

            Log::info('✅ File video salvato temporaneamente', [
                'temp_path' => $tempPath,
                'full_path' => $fullTempPath
            ]);

            // Prepara i dati per PeerTube
            $this->uploadPhase = __('media.preparing_peertube_data');
            $this->uploadProgress = 20;

            $videoData = [
                'name' => $this->title,
                'description' => $this->description ?? '',
                'privacy' => $this->is_public ? 1 : 3, // 1 = Public, 3 = Private
                'category' => 1, // Music
                'licence' => 1, // Attribution
                'language' => app()->getLocale(),
                'downloadEnabled' => true,
                'commentsPolicy' => 1, // Enabled
                'nsfw' => false,
            ];

            // Elabora tags se presenti
            if (!empty($this->tags)) {
                $tags = array_map('trim', explode(',', $this->tags));
                $tags = array_filter($tags, function($tag) {
                    return strlen($tag) >= 2 && strlen($tag) <= 30;
                });
                if (!empty($tags)) {
                    $videoData['tags'] = array_slice($tags, 0, 5); // Max 5 tags
                }
            }

            // Gestione thumbnail se presente
            if ($this->thumbnail) {
                $thumbnailPath = $this->thumbnail->store('temp-thumbnails', 'local');
                $fullThumbnailPath = Storage::disk('local')->path($thumbnailPath);
                $videoData['thumbnail_path'] = $fullThumbnailPath;
            }

            // Upload su PeerTube
            $this->uploadPhase = __('media.uploading_to_peertube');
            $this->uploadProgress = 40;

            $peerTubeService = new PeerTubeService();
            $peerTubeVideo = $peerTubeService->uploadVideo($user, $fullTempPath, $videoData);

            if (!$peerTubeVideo) {
                Log::error('❌ Upload PeerTube fallito');
                
                // Pulisci file temporanei
                Storage::disk('local')->delete($tempPath);
                if (isset($thumbnailPath)) {
                    Storage::disk('local')->delete($thumbnailPath);
                }

                $this->addError('upload', __('media.peertube_upload_failed'));
                $this->resetUploadState();
                return;
            }

            $this->uploadPhase = __('media.creating_video_record');
            $this->uploadProgress = 60;

            Log::info('✅ Upload PeerTube completato', ['peer_tube_video' => $peerTubeVideo]);

            // Costruisci URL video PeerTube
            $videoUrl = $peerTubeService->getBaseUrl() . '/videos/watch/' . ($peerTubeVideo['shortUUID'] ?? $peerTubeVideo['uuid']);

            // Prepara dati per il database
            $localVideoData = [
                'title' => $this->title,
                'description' => $this->description,
                'user_id' => $user->id,
                'video_url' => $videoUrl,
                'peertube_video_id' => $peerTubeVideo['id'],
                'peertube_uuid' => $peerTubeVideo['uuid'],
                'peertube_short_uuid' => $peerTubeVideo['shortUUID'] ?? null,
                'peertube_url' => $videoUrl,
                'peertube_status' => 'processing',
                'is_public' => $this->is_public,
                'status' => 'processing',
                'file_size' => $this->video_file->getSize(),
            ];

            // Recupera thumbnail da PeerTube (potrebbe non essere disponibile subito, ma proviamo)
            $thumbnailUrl = null;
            
            // Prova a recuperare dalla risposta PeerTube
            if (isset($peerTubeVideo['thumbnailPath']) && !empty($peerTubeVideo['thumbnailPath'])) {
                $peerTubeBaseUrl = $peerTubeService->getBaseUrl();
                $thumbnailUrl = rtrim($peerTubeBaseUrl, '/') . $peerTubeVideo['thumbnailPath'];
            } elseif (isset($peerTubeVideo['thumbnailUrl']) && !empty($peerTubeVideo['thumbnailUrl'])) {
                $thumbnailUrl = $peerTubeVideo['thumbnailUrl'];
            }
            
            // Se non è nella risposta, prova a recuperarla dall'API PeerTube
            if (!$thumbnailUrl && isset($peerTubeVideo['id'])) {
                Log::info('🔍 Thumbnail non nella risposta, recupero da API PeerTube', [
                    'peertube_video_id' => $peerTubeVideo['id']
                ]);
                
                try {
                    $peerTubeBaseUrl = $peerTubeService->getBaseUrl();
                    $response = \Illuminate\Support\Facades\Http::timeout(10)
                        ->get($peerTubeBaseUrl . '/api/v1/videos/' . $peerTubeVideo['id']);
                    
                    if ($response->successful()) {
                        $videoData = $response->json();
                        
                        if (isset($videoData['thumbnailPath']) && !empty($videoData['thumbnailPath'])) {
                            $thumbnailUrl = rtrim($peerTubeBaseUrl, '/') . $videoData['thumbnailPath'];
                        } elseif (isset($videoData['thumbnailUrl']) && !empty($videoData['thumbnailUrl'])) {
                            $thumbnailUrl = $videoData['thumbnailUrl'];
                        }
                        
                        Log::info('📡 Risposta API PeerTube per thumbnail', [
                            'has_thumbnail' => !empty($thumbnailUrl),
                            'thumbnail_url' => $thumbnailUrl,
                            'video_data_keys' => array_keys($videoData)
                        ]);
                    }
                } catch (\Exception $e) {
                    Log::warning('⚠️ Errore recupero thumbnail da API PeerTube', [
                        'error' => $e->getMessage()
                    ]);
                }
            }
            
            // Salva thumbnail se recuperata
            if ($thumbnailUrl) {
                $localVideoData['peertube_thumbnail_url'] = $thumbnailUrl;
                $localVideoData['thumbnail_path'] = $thumbnailUrl;
                
                Log::info('✅ Thumbnail PeerTube salvata', [
                    'thumbnail_url' => $thumbnailUrl
                ]);
            } else {
                Log::warning('⚠️ Thumbnail non disponibile subito, verrà recuperata quando PeerTube avrà finito il processing');
            }

            // Salva tags se presenti
            if (!empty($videoData['tags'])) {
                $localVideoData['tags'] = implode(',', $videoData['tags']);
                $localVideoData['peertube_tags'] = $videoData['tags'];
            }

            // Salva thumbnail manuale solo se non abbiamo già una thumbnail da PeerTube
            // La thumbnail da PeerTube ha sempre priorità!
            if ($this->thumbnail && empty($localVideoData['peertube_thumbnail_url'])) {
                $this->uploadPhase = __('media.saving_thumbnail');
                $this->uploadProgress = 70;

                $thumbnailStoragePath = $this->thumbnail->store('video-thumbnails', 'public');
                $localVideoData['thumbnail'] = $thumbnailStoragePath;
                $localVideoData['thumbnail_path'] = $thumbnailStoragePath;
            }

            // Crea record video
            $this->uploadPhase = __('media.finalizing');
            $this->uploadProgress = 85;

            $video = Video::create($localVideoData);

            Log::info('✅ Video creato nel database', [
                'video_id' => $video->id,
                'peertube_uuid' => $video->peertube_uuid,
                'peertube_thumbnail_url' => $video->peertube_thumbnail_url,
                'thumbnail_path' => $video->thumbnail_path
            ]);

            // Se non abbiamo la thumbnail da PeerTube, proviamo a recuperarla subito dopo la creazione
            if (empty($video->peertube_thumbnail_url) && $video->peertube_video_id) {
                $this->uploadPhase = __('media.retrieving_thumbnail');
                $this->uploadProgress = 90;
                
                try {
                    $thumbnailService = app(\App\Services\ThumbnailService::class);
                    $thumbnailUrl = $thumbnailService->getPeerTubeThumbnailUrl($video);
                    
                    if ($thumbnailUrl) {
                        // Aggiorna il video con la thumbnail recuperata
                        $video->update([
                            'peertube_thumbnail_url' => $thumbnailUrl,
                            'thumbnail_path' => $thumbnailUrl
                        ]);
                        
                        Log::info('✅ Thumbnail PeerTube recuperata dopo la creazione del video', [
                            'video_id' => $video->id,
                            'thumbnail_url' => $thumbnailUrl
                        ]);
                    } else {
                        Log::warning('⚠️ Thumbnail PeerTube non ancora disponibile, sarà recuperata quando PeerTube avrà finito il processing', [
                            'video_id' => $video->id
                        ]);
                    }
                } catch (\Exception $e) {
                    Log::warning('⚠️ Errore recupero thumbnail PeerTube dopo creazione video', [
                        'video_id' => $video->id,
                        'error' => $e->getMessage()
                    ]);
                }
            }

            // Pulisci file temporanei
            Storage::disk('local')->delete($tempPath);
            if (isset($thumbnailPath)) {
                Storage::disk('local')->delete($thumbnailPath);
            }

            $this->uploadProgress = 100;
            $this->uploadPhase = __('media.upload_complete');

            Log::info('🎉 Upload video completato con successo', [
                'video_id' => $video->id,
                'user_id' => $user->id
            ]);

            session()->flash('success', __('media.video_uploaded_successfully'));
            
            // Reset form
            $this->reset(['title', 'description', 'tags', 'is_public', 'thumbnail', 'video_file', 'uploadProgress', 'isUploading', 'uploadPhase']);

            // Redirect dopo breve delay
            $this->redirect(route('media.index'), navigate: true);

        } catch (\Exception $e) {
            Log::error('💥 Errore critico durante upload video', [
                'user_id' => $user->id,
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);

            // Pulisci file temporanei in caso di errore
            if (isset($tempPath)) {
                Storage::disk('local')->delete($tempPath);
            }
            if (isset($thumbnailPath)) {
                Storage::disk('local')->delete($thumbnailPath);
            }

            $this->addError('upload', __('media.upload_error') . ': ' . $e->getMessage());
            $this->resetUploadState();
        }
    }
    
    private function resetUploadState()
    {
        $this->isSubmitting = false;
        $this->isUploading = false;
        $this->uploadProgress = 0;
        $this->uploadPhase = '';
    }
    
    public function render()
    {
        $user = Auth::user();
        
        return view('livewire.media.video-upload', [
            'user' => $user,
            'currentVideoCount' => $user->current_video_count,
            'currentVideoLimit' => $user->current_video_limit,
            'remainingUploads' => $user->remaining_video_uploads,
        ]);
    }
}

