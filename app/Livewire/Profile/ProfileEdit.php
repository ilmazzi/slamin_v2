<?php

namespace App\Livewire\Profile;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Services\ImageService;

class ProfileEdit extends Component
{
    use WithFileUploads;

    public $user;
    
    // Profile fields
    public $name;
    public $nickname;
    public $email;
    public $bio;
    public $location;
    public $website;
    public $birth_date;
    public $phone;
    
    // Social links
    public $social_facebook;
    public $social_instagram;
    public $social_twitter;
    public $social_youtube;
    public $social_linkedin;
    
    // Avatar and banner
    public $avatar;
    public $banner;
    public $avatarPreview;
    public $bannerPreview;
    
    // Privacy settings
    public $is_public = true;
    public $show_email = false;
    public $show_phone = false;
    public $show_birth_date = false;

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'nickname' => 'required|string|max:50|unique:users,nickname,' . $this->user->id,
            'email' => 'required|email|unique:users,email,' . $this->user->id,
            'bio' => 'nullable|string|max:1000',
            'location' => 'nullable|string|max:255',
            'website' => 'nullable|url|max:255',
            'birth_date' => 'nullable|date|before:today',
            'phone' => 'nullable|string|max:20',
            'social_facebook' => 'nullable|url|max:255',
            'social_instagram' => 'nullable|url|max:255',
            'social_twitter' => 'nullable|url|max:255',
            'social_youtube' => 'nullable|url|max:255',
            'social_linkedin' => 'nullable|url|max:255',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'banner' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'is_public' => 'boolean',
            'show_email' => 'boolean',
            'show_phone' => 'boolean',
            'show_birth_date' => 'boolean',
        ];
    }

    public function mount()
    {
        $this->user = Auth::user();
        $this->loadUserData();
    }

    public function loadUserData()
    {
        $this->name = $this->user->name;
        $this->nickname = $this->user->nickname;
        $this->email = $this->user->email;
        $this->bio = $this->user->bio;
        $this->location = $this->user->location;
        $this->website = $this->user->website;
        $this->birth_date = $this->user->birth_date?->format('Y-m-d');
        $this->phone = $this->user->phone;
        
        $this->social_facebook = $this->user->social_facebook;
        $this->social_instagram = $this->user->social_instagram;
        $this->social_twitter = $this->user->social_twitter;
        $this->social_youtube = $this->user->social_youtube;
        $this->social_linkedin = $this->user->social_linkedin;
        
        $this->is_public = $this->user->is_public ?? true;
        $this->show_email = $this->user->show_email ?? false;
        $this->show_phone = $this->user->show_phone ?? false;
        $this->show_birth_date = $this->user->show_birth_date ?? false;
    }

    public function updatedAvatar()
    {
        $this->validateOnly('avatar');
        if ($this->avatar) {
            $this->avatarPreview = $this->avatar->temporaryUrl();
        }
    }

    public function updatedBanner()
    {
        $this->validateOnly('banner');
        if ($this->banner) {
            $this->bannerPreview = $this->banner->temporaryUrl();
        }
    }

    public function removeAvatar()
    {
        $this->avatar = null;
        $this->avatarPreview = null;
        
        if ($this->user->profile_photo) {
            Storage::disk('public')->delete($this->user->profile_photo);
            $this->user->update(['profile_photo' => null, 'avatar_thumbnail' => null]);
            session()->flash('success', __('profile.avatar_removed'));
        }
    }

    public function removeBanner()
    {
        $this->banner = null;
        $this->bannerPreview = null;
        
        if ($this->user->banner_image) {
            Storage::disk('public')->delete($this->user->banner_image);
            $this->user->update(['banner_image' => null]);
            session()->flash('success', __('profile.banner_removed'));
        }
    }

    /**
     * Normalizza un URL aggiungendo https:// se manca il protocollo
     */
    private function normalizeUrl($url)
    {
        if (empty($url)) {
            return null;
        }
        
        $url = trim($url);
        
        // Se l'URL non inizia con http:// o https://, aggiungi https://
        if (!preg_match('/^https?:\/\//i', $url)) {
            $url = 'https://' . $url;
        }
        
        return $url;
    }

    // Livewire lifecycle hooks - normalizza gli URL quando vengono aggiornati
    public function updatedWebsite($value)
    {
        $this->website = $this->normalizeUrl($value);
    }

    public function updatedSocialFacebook($value)
    {
        $this->social_facebook = $this->normalizeUrl($value);
    }

    public function updatedSocialInstagram($value)
    {
        $this->social_instagram = $this->normalizeUrl($value);
    }

    public function updatedSocialTwitter($value)
    {
        $this->social_twitter = $this->normalizeUrl($value);
    }

    public function updatedSocialYoutube($value)
    {
        $this->social_youtube = $this->normalizeUrl($value);
    }

    public function updatedSocialLinkedin($value)
    {
        $this->social_linkedin = $this->normalizeUrl($value);
    }

    public function save()
    {
        try {
            // Normalizza gli URL prima della validazione (doppia sicurezza)
            $this->website = $this->normalizeUrl($this->website);
            $this->social_facebook = $this->normalizeUrl($this->social_facebook);
            $this->social_instagram = $this->normalizeUrl($this->social_instagram);
            $this->social_twitter = $this->normalizeUrl($this->social_twitter);
            $this->social_youtube = $this->normalizeUrl($this->social_youtube);
            $this->social_linkedin = $this->normalizeUrl($this->social_linkedin);
            
            $rules = [
                'name' => 'required|string|max:255',
                'nickname' => 'required|string|max:50|unique:users,nickname,' . $this->user->id,
                'email' => 'required|email|unique:users,email,' . $this->user->id,
                'bio' => 'nullable|string|max:1000',
                'location' => 'nullable|string|max:255',
                'website' => 'nullable|url|max:255',
                'birth_date' => 'nullable|date|before:today',
                'phone' => 'nullable|string|max:20',
                'social_facebook' => 'nullable|url|max:255',
                'social_instagram' => 'nullable|url|max:255',
                'social_twitter' => 'nullable|url|max:255',
                'social_youtube' => 'nullable|url|max:255',
                'social_linkedin' => 'nullable|url|max:255',
                'is_public' => 'nullable|boolean',
                'show_email' => 'nullable|boolean',
                'show_phone' => 'nullable|boolean',
                'show_birth_date' => 'nullable|boolean',
            ];
            
            if ($this->avatar) {
                $rules['avatar'] = 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048';
            }
            if ($this->banner) {
                $rules['banner'] = 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120';
            }

            $this->validate($rules);

            $data = [
                'name' => $this->name,
                'nickname' => $this->nickname,
                'email' => $this->email,
                'bio' => $this->bio,
                'location' => $this->location,
                'website' => $this->website,
                'birth_date' => $this->birth_date,
                'phone' => $this->phone,
                'social_facebook' => $this->social_facebook,
                'social_instagram' => $this->social_instagram,
                'social_twitter' => $this->social_twitter,
                'social_youtube' => $this->social_youtube,
                'social_linkedin' => $this->social_linkedin,
                'is_public' => $this->is_public,
                'show_email' => $this->show_email,
                'show_phone' => $this->show_phone,
                'show_birth_date' => $this->show_birth_date,
            ];

            // Handle avatar upload
            if ($this->avatar) {
                if ($this->user->profile_photo) {
                    Storage::disk('public')->delete($this->user->profile_photo);
                    if ($this->user->avatar_thumbnail) {
                        Storage::disk('public')->delete($this->user->avatar_thumbnail);
                    }
                }
                
                $avatarPath = $this->avatar->store('avatars', 'public');
                $data['profile_photo'] = $avatarPath;
                
                // Generate thumbnail if ImageService exists
                if (class_exists(ImageService::class)) {
                    try {
                        $imageService = app(ImageService::class);
                        $thumbnailPath = 'avatars/thumbnails/' . basename($avatarPath);
                        $thumbnailInfo = $imageService->createThumbnail($avatarPath, $thumbnailPath, 150, 150);
                        $data['avatar_thumbnail'] = $thumbnailInfo['path'];
                    } catch (\Exception $e) {
                        // Skip thumbnail if service not available
                    }
                }
            }

            // Handle banner upload
            if ($this->banner) {
                if ($this->user->banner_image) {
                    Storage::disk('public')->delete($this->user->banner_image);
                }
                
                $bannerPath = $this->banner->store('banners', 'public');
                $data['banner_image'] = $bannerPath;
            }

            $this->user->update($data);
            
            session()->flash('success', __('profile.updated_successfully'));
            
            $this->user->refresh();
            $this->loadUserData();
            
            $this->dispatch('profile-updated');
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            throw $e;
        } catch (\Exception $e) {
            \Log::error('Profile update error', [
                'user_id' => $this->user->id,
                'error' => $e->getMessage(),
            ]);
            session()->flash('error', __('profile.update_error') . ': ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.profile.profile-edit')
            ->layout('components.layouts.app');
    }
}

