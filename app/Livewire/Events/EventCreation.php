<?php

namespace App\Livewire\Events;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\On;
use App\Models\Event;
use App\Models\User;
use App\Models\RecentVenue;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class EventCreation extends Component
{
    use WithFileUploads;

    // ========================================
    // STEP MANAGEMENT
    // ========================================
    public $currentStep = 1;
    public $totalSteps = 5;

    // ========================================
    // STEP 1: BASIC INFORMATION
    // ========================================
    public $title = '';
    public $has_subtitle = false;
    public $subtitle = '';
    public $description = '';
    public $requirements = '';
    public $category = '';
    public $is_public = true;

    // ========================================
    // STEP 2: DATE & LOCATION
    // ========================================
    // Dates
    public $start_datetime = '';
    public $end_datetime = '';
    public $registration_deadline = '';
    public $invitation_deadline = '';

    // Availability-based settings
    public $is_availability_based = false;
    public $availability_deadline = '';
    public $availability_instructions = '';
    public $availability_options = [];

    // Location
    public $is_online = false;
    public $online_url = '';
    public $timezone = 'Europe/Rome';
    public $venue_name = '';
    public $venue_address = '';
    public $city = '';
    public $postcode = '';
    public $country = 'IT';
    public $latitude = '';
    public $longitude = '';

    // Recurrence
    public $is_recurring = false;
    public $recurrence_type = '';
    public $recurrence_interval = 1;
    public $recurrence_count = '';
    public $recurrence_weekdays = [];
    public $recurrence_monthday = '';

    // ========================================
    // STEP 3: DETAILS
    // ========================================
    // Media
    public $event_image;
    public $promotional_video = '';

    // Payment
    public $is_paid_event = false;
    public $ticket_price = 0;
    public $ticket_currency = 'EUR';

    // Groups
    public $is_linked_to_group = false;
    public $selected_groups = [];
    public $groupSearch = '';
    public $searchedGroups = [];

    // Festival
    public $is_festival_event = false;
    public $festival_id = '';
    public $selected_festival_events = [];
    public $festivalEventSearch = '';

    // Gig Positions
    public $gig_positions = [];

    // ========================================
    // STEP 4: INVITATIONS & SETTINGS
    // ========================================
    // Registration deadline
    public $has_registration_deadline = false;
    public $registration_deadline_date = '';
    public $registration_deadline_time = '';

    // Status
    public $status = 'published';

    // Event settings
    public $max_participants = '';
    public $has_capacity_limit = false;
    public $allow_requests = false;

    // Invitations
    public $invitation_role = 'performer';
    public $private_invited_users = [];
    public $artist_invited_users = [];
    public $invitations = [];
    public $performer_invitations = [];
    public $audienceInvitations = [];
    
    // User search for invitations
    public $userSearchQuery = '';
    public $audienceSearchQuery = '';
    public $searchResults = [];
    public $audienceSearchResults = [];
    public $searching = false;
    
    // Email invitation fields
    public $emailInvitationName = '';
    public $emailInvitationEmail = '';
    public $emailInvitationRole = 'performer';

    // Group search
    public $groupSearchQuery = '';
    public $groupSearchResults = [];

    // Tags
    public $tags = [];

    // ========================================
    // RECENT VENUES
    // ========================================
    public $recentVenues = [];
    public $selectedRecentVenue = '';

    // ========================================
    // STEP 5: PREVIEW (auto-generated)
    // ========================================

    // ========================================
    // VALIDATION RULES
    // ========================================
    protected function rules()
    {
        return [
            // Step 1: Basic Information
            'title' => 'required|string|max:255',
            'has_subtitle' => 'boolean',
            'subtitle' => $this->has_subtitle ? 'required|string|max:255' : 'nullable|string|max:255',
            'description' => 'nullable|string',
            'requirements' => 'nullable|string',
            'category' => 'required|string|in:' . implode(',', array_keys(Event::getCategories())),
            'is_public' => 'required|boolean',

            // Step 2: Date & Location
            'start_datetime' => $this->is_availability_based ? 'nullable|date' : 'required|date|after:now',
            'end_datetime' => $this->is_availability_based ? 'nullable|date|after:start_datetime' : 'required|date|after:start_datetime',
            'is_online' => 'boolean',
            'online_url' => $this->is_online ? 'required|url' : 'nullable|url',
            'timezone' => $this->is_online ? 'required|string' : 'nullable|string',
            'venue_name' => !$this->is_online ? 'nullable|string|max:255' : 'nullable',
            'venue_address' => !$this->is_online ? 'nullable|string' : 'nullable',
            'city' => !$this->is_online ? 'nullable|string|max:255' : 'nullable',
            'postcode' => 'nullable|string|max:10',
            'country' => 'nullable|string|size:2',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',

            // Recurrence
            'is_recurring' => 'boolean',
            'recurrence_type' => $this->is_recurring ? 'required|in:daily,weekly,monthly,yearly' : 'nullable',
            'recurrence_interval' => $this->is_recurring ? 'required|integer|min:1' : 'nullable',
            'recurrence_count' => $this->is_recurring ? 'nullable|integer|min:1|max:100' : 'nullable',

            // Step 3: Details
            'event_image' => 'nullable|image|max:2048',
            'promotional_video' => 'nullable|url',
            'ticket_price' => 'nullable|numeric|min:0',
            'ticket_currency' => 'nullable|string|size:3',

            // Step 4: Settings
            'max_participants' => 'nullable|integer|min:1',
            'status' => 'required|in:draft,published',
        ];
    }

    protected $messages = [
        'title.required' => 'Il titolo è obbligatorio',
        'title.max' => 'Il titolo non può superare 255 caratteri',
        'category.required' => 'La categoria è obbligatoria',
        'category.in' => 'La categoria selezionata non è valida',
        'start_datetime.required' => 'La data di inizio è obbligatoria',
        'start_datetime.after' => 'La data di inizio deve essere futura',
        'end_datetime.required' => 'La data di fine è obbligatoria',
        'end_datetime.after' => 'La data di fine deve essere dopo la data di inizio',
        'online_url.required' => 'L\'URL dell\'evento online è obbligatorio',
        'online_url.url' => 'L\'URL deve essere un link valido',
        'timezone.required' => 'Il fuso orario è obbligatorio per eventi online',
        'event_image.image' => 'Il file deve essere un\'immagine',
        'event_image.max' => 'L\'immagine non può superare 2MB',
        'promotional_video.url' => 'L\'URL del video deve essere un link valido',
        'recurrence_type.required' => 'Il tipo di ricorrenza è obbligatorio',
        'recurrence_interval.required' => 'L\'intervallo di ricorrenza è obbligatorio',
        'recurrence_interval.min' => 'L\'intervallo deve essere almeno 1',
        'recurrence_count.max' => 'Il numero di occorrenze non può superare 100',
    ];

    // ========================================
    // LIFECYCLE METHODS
    // ========================================
    public function mount()
    {
        // Set default values
        $this->timezone = config('app.timezone', 'Europe/Rome');
        $this->country = 'IT';
        $this->is_public = true;
        $this->status = 'published';
        $this->ticket_currency = 'EUR';
        $this->invitation_role = 'performer';

        // Check permissions
        $user = Auth::user();
        if (!$user) {
            abort(403, 'Devi essere autenticato per creare eventi');
        }

        // Check if user can organize events (admin, moderator, or organizer)
        if (!$user->canOrganizeEvents()) {
            abort(403, 'Non hai i permessi per creare eventi. Richiedi il ruolo di organizzatore.');
        }

        // Se c'è un parametro date nella query string, precompila la data di inizio
        if (request()->has('date')) {
            $date = request()->query('date');
            try {
                $parsedDate = \Carbon\Carbon::parse($date);
                // Imposta la data alle 18:00 di default
                $this->start_datetime = $parsedDate->setTime(18, 0)->format('Y-m-d\TH:i');
            } catch (\Exception $e) {
                // Ignora se la data non è valida
            }
        }

        // Load recent venues - convert to array for Livewire compatibility
        $this->recentVenues = RecentVenue::getPopularVenues(8)->toArray();
    }

    // ========================================
    // STEP NAVIGATION
    // ========================================
    public function nextStep()
    {
        $this->validateCurrentStep();

        if ($this->currentStep < $this->totalSteps) {
            $this->currentStep++;
            // Scroll to top dopo il cambio step
            $this->dispatch('scroll-to-top');
        }
    }

    public function prevStep()
    {
        if ($this->currentStep > 1) {
            $this->currentStep--;
        }
    }

    public function goToStep($step)
    {
        if ($step >= 1 && $step <= $this->totalSteps) {
            $this->currentStep = $step;
        }
    }

    // ========================================
    // TOGGLE METHODS
    // ========================================
    public function toggleSubtitle()
    {
        $this->has_subtitle = !$this->has_subtitle;

        // Se disattiviamo il sottotitolo, svuotiamo il campo
        if (!$this->has_subtitle) {
            $this->subtitle = '';
        }
    }

    // ========================================
    // VALIDATION
    // ========================================
    public function validateCurrentStep()
    {
        switch ($this->currentStep) {
            case 1:
                return $this->validate([
                    'title' => 'required|string|max:255',
                    'has_subtitle' => 'boolean',
                    'subtitle' => $this->has_subtitle ? 'required|string|max:255' : 'nullable|string|max:255',
                    'description' => 'nullable|string',
                    'requirements' => 'nullable|string',
                    'category' => 'required|string|in:' . implode(',', array_keys(Event::getCategories())),
                    'is_public' => 'required|boolean',
                ]);

            case 2:
                $rules = [
                    'is_online' => 'boolean',
                    'registration_deadline' => 'nullable|date|before:start_datetime',
                    'invitation_deadline' => 'nullable|date|before:start_datetime',
                    'is_availability_based' => 'boolean',
                    'availability_deadline' => 'nullable|date|after:now',
                    'availability_instructions' => 'nullable|string|max:500',
                    'is_recurring' => 'boolean',
                ];

                // Only validate recurrence fields if recurring is enabled
                if ($this->is_recurring) {
                    $rules['recurrence_type'] = 'required|string|in:daily,weekly,monthly,yearly';
                    $rules['recurrence_interval'] = 'required|integer|min:1|max:365';
                    $rules['recurrence_count'] = 'nullable|integer|min:1|max:100';
                    
                    // Validate weekdays only if recurrence type is weekly
                    if ($this->recurrence_type === 'weekly') {
                        $rules['recurrence_weekdays'] = 'required|array|min:1';
                    }
                    
                    // Validate monthday only if recurrence type is monthly
                    if ($this->recurrence_type === 'monthly') {
                        $rules['recurrence_monthday'] = 'required|integer|min:1|max:31';
                    }
                }

                if ($this->is_availability_based) {
                    $rules['start_datetime'] = 'nullable|date';
                    $rules['end_datetime'] = 'nullable|date|after:start_datetime';
                } else {
                    $rules['start_datetime'] = 'required|date|after:now';
                    $rules['end_datetime'] = 'required|date|after:start_datetime';
                }

                if ($this->is_online) {
                    $rules['online_url'] = 'required|url';
                    $rules['timezone'] = 'required|string';
                } else {
                    $rules['venue_name'] = 'nullable|string|max:255';
                    $rules['venue_address'] = 'nullable|string|max:500';
                    $rules['city'] = 'nullable|string|max:100';
                    $rules['postcode'] = 'nullable|string|max:10';
                    $rules['country'] = 'nullable|string|size:2';
                    $rules['latitude'] = 'nullable|numeric|between:-90,90';
                    $rules['longitude'] = 'nullable|numeric|between:-180,180';
                }

                return $this->validate($rules);

            case 3:
                return $this->validate([
                    'event_image' => 'nullable|image|max:2048',
                    'promotional_video' => 'nullable|url',
                    'ticket_price' => 'nullable|numeric|min:0',
                ]);

            case 4:
                return $this->validate([
                    'max_participants' => 'nullable|integer|min:1',
                    'status' => 'required|in:draft,published',
                ]);

            default:
                return true;
        }
    }

    // ========================================
    // REAL-TIME VALIDATION
    // ========================================
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
        
        // Emit event when is_online changes
        if ($propertyName === 'is_online') {
            $this->dispatch('location-mode-changed', isOnline: $this->is_online);
        }
    }

    public function updatedLatitude()
    {
        // Aggiorna il pin sulla mappa quando cambia la latitudine
        if ($this->latitude && $this->longitude) {
            $this->dispatch('update-map-location', 
                latitude: floatval($this->latitude), 
                longitude: floatval($this->longitude)
            );
        }
    }

    public function updatedLongitude()
    {
        // Aggiorna il pin sulla mappa quando cambia la longitudine
        if ($this->latitude && $this->longitude) {
            $this->dispatch('update-map-location', 
                latitude: floatval($this->latitude), 
                longitude: floatval($this->longitude)
            );
        }
    }

    #[On('map-clicked')]
    public function handleMapClick($latitude, $longitude, $city, $address, $postcode, $country)
    {
        $this->latitude = $latitude;
        $this->longitude = $longitude;
        $this->city = $city;
        $this->venue_address = $address;
        $this->postcode = $postcode;
        $this->country = $country;
    }

    public function getFullAddressProperty()
    {
        // Build full address for geocoding
        $addressParts = array_filter([
            $this->venue_address,
            $this->postcode,
            $this->city,
            $this->country
        ]);
        
        return implode(', ', $addressParts);
    }

    public function getFilteredFestivalEventsProperty()
    {
        $query = Event::where('category', '!=', 'festival')
            ->where('status', 'published')
            ->where(function($q) {
                $q->whereNull('start_datetime')
                  ->orWhere('start_datetime', '>=', now());
            });

        if (strlen($this->festivalEventSearch) >= 2) {
            $query->where(function($q) {
                $q->where('title', 'like', '%' . $this->festivalEventSearch . '%')
                  ->orWhere('city', 'like', '%' . $this->festivalEventSearch . '%');
            });
        }

        return $query->orderBy('start_datetime', 'asc')->get();
    }

    // Load a recent venue from select dropdown
    public function loadRecentVenueFromSelect()
    {
        if (empty($this->selectedRecentVenue) || $this->selectedRecentVenue === '') {
            return;
        }

        $venueIndex = (int) $this->selectedRecentVenue;
        
        if (!isset($this->recentVenues[$venueIndex])) {
            return;
        }

        $venue = $this->recentVenues[$venueIndex];
        
        // Populate venue fields
        $this->venue_name = $venue['venue_name'] ?? '';
        $this->venue_address = $venue['venue_address'] ?? '';
        $this->city = $venue['city'] ?? '';
        $this->postcode = $venue['postcode'] ?? '';
        $this->country = $venue['country'] ?? 'IT';
        $this->latitude = $venue['latitude'] ?? '';
        $this->longitude = $venue['longitude'] ?? '';
        
        // Update map location if coordinates are available
        if ($this->latitude && $this->longitude) {
            $this->dispatch('update-map-location', 
                latitude: floatval($this->latitude), 
                longitude: floatval($this->longitude)
            );
        }

        // Dispatch event to update map
        if ($this->latitude && $this->longitude) {
            $this->dispatch('update-map-location', 
                latitude: floatval($this->latitude), 
                longitude: floatval($this->longitude)
            );
        }

        session()->flash('success', 'Venue caricato con successo');
    }

    // ========================================
    // USER SEARCH & INVITATIONS
    // ========================================
    public function updatedUserSearchQuery()
    {
        if (strlen($this->userSearchQuery) < 2) {
            $this->searchResults = [];
            return;
        }

        $this->searching = true;

        $this->searchResults = User::where(function ($q) {
                $q->where('name', 'like', "%{$this->userSearchQuery}%")
                  ->orWhere('email', 'like', "%{$this->userSearchQuery}%")
                  ->orWhere('nickname', 'like', "%{$this->userSearchQuery}%");
            })
            ->where('id', '!=', Auth::id())
            ->whereNotIn('id', collect($this->invitations)->pluck('user_id'))
            ->limit(10)
            ->get()
            ->map(function ($user) {
                return [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'nickname' => $user->nickname,
                    'avatar' => $user->avatar_url ?? null,
                ];
            })
            ->toArray();

        $this->searching = false;
    }

    public function updatedGroupSearchQuery()
    {
        // Group search disabled - Group model not implemented yet
        $this->groupSearchResults = [];
    }

    public function updatedAudienceSearchQuery()
    {
        if (strlen($this->audienceSearchQuery) < 2) {
            $this->audienceSearchResults = [];
            return;
        }

        $this->audienceSearchResults = User::where(function ($q) {
                $q->where('name', 'like', "%{$this->audienceSearchQuery}%")
                  ->orWhere('email', 'like', "%{$this->audienceSearchQuery}%")
                  ->orWhere('nickname', 'like', "%{$this->audienceSearchQuery}%");
            })
            ->where('id', '!=', Auth::id())
            ->whereNotIn('id', collect($this->audienceInvitations)->pluck('user_id'))
            ->limit(10)
            ->get()
            ->map(function ($user) {
                return [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'nickname' => $user->nickname,
                    'avatar' => $user->avatar_url ?? null,
                ];
            })
            ->toArray();
    }

    public function addAudienceInvitation($userId)
    {
        if (collect($this->audienceInvitations)->contains('user_id', $userId)) {
            return;
        }

        $user = User::find($userId);
        if (!$user) {
            return;
        }

        $this->audienceInvitations[] = [
            'user_id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
        ];

        $this->audienceSearchQuery = '';
        $this->audienceSearchResults = [];
    }

    public function removeAudienceInvitation($index)
    {
        unset($this->audienceInvitations[$index]);
        $this->audienceInvitations = array_values($this->audienceInvitations);
    }

    public function addInvitation($userId, $role = 'performer')
    {
        // Check if user already invited
        if (collect($this->invitations)->contains('user_id', $userId)) {
            session()->flash('warning', 'Utente già invitato');
            return;
        }

        $user = User::find($userId);
        if (!$user) {
            return;
        }

        $invitation = [
            'user_id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'role' => $role,
        ];

        $this->invitations[] = $invitation;

        // Also add to performer_invitations if role is performer
        if ($role === 'performer') {
            $this->performer_invitations[] = $invitation;
        }

        // Clear search
        $this->userSearchQuery = '';
        $this->searchResults = [];

        session()->flash('success', "Invito aggiunto per {$user->name}");
    }

    public function addEmailInvitation()
    {
        // Validate email
        if (empty($this->emailInvitationEmail) || !filter_var($this->emailInvitationEmail, FILTER_VALIDATE_EMAIL)) {
            session()->flash('error', 'Inserisci un indirizzo email valido');
            return;
        }

        // Check if email already invited
        if (collect($this->invitations)->contains('email', $this->emailInvitationEmail)) {
            session()->flash('warning', 'Email già invitata');
            return;
        }

        // Check if user with this email exists
        $existingUser = User::where('email', $this->emailInvitationEmail)->first();
        if ($existingUser) {
            // User exists, use normal invitation
            $this->addInvitation($existingUser->id, $this->emailInvitationRole);
            $this->emailInvitationName = '';
            $this->emailInvitationEmail = '';
            return;
        }

        // Add email invitation
        $invitation = [
            'user_id' => null,
            'name' => $this->emailInvitationName ?: 'Utente non registrato',
            'email' => $this->emailInvitationEmail,
            'role' => $this->emailInvitationRole,
            'is_email_invitation' => true,
        ];

        $this->invitations[] = $invitation;

        // Also add to performer_invitations if role is performer
        if ($this->emailInvitationRole === 'performer') {
            $this->performer_invitations[] = $invitation;
        }

        // Clear fields
        $this->emailInvitationName = '';
        $this->emailInvitationEmail = '';

        session()->flash('success', "Invito via email aggiunto per {$invitation['email']}");
    }

    public function removeInvitation($index)
    {
        if (isset($this->invitations[$index])) {
            $userName = $this->invitations[$index]['name'];
            $userId = $this->invitations[$index]['user_id'];
            $role = $this->invitations[$index]['role'];
            
            unset($this->invitations[$index]);
            $this->invitations = array_values($this->invitations); // Re-index array
            
            // Also remove from performer_invitations if role was performer
            if ($role === 'performer') {
                $this->performer_invitations = collect($this->performer_invitations)
                    ->reject(fn($inv) => $inv['user_id'] === $userId)
                    ->values()
                    ->toArray();
            }
            
            session()->flash('success', "Invito rimosso per {$userName}");
        }
    }

    public function updateInvitationRole($index, $role)
    {
        if (isset($this->invitations[$index])) {
            $this->invitations[$index]['role'] = $role;
        }
    }

    // Gig Positions Management
    public function addGigPosition()
    {
        $this->gig_positions[] = [
            'type' => '',
            'quantity' => 1,
            'language' => '',
            'has_cachet' => false,
            'cachet_amount' => '',
            'cachet_currency' => 'EUR',
            'has_travel' => false,
            'travel_max' => '',
            'travel_currency' => 'EUR',
            'has_accommodation' => false,
            'accommodation_details' => '',
        ];
    }

    public function removeGigPosition($index)
    {
        if (isset($this->gig_positions[$index])) {
            unset($this->gig_positions[$index]);
            $this->gig_positions = array_values($this->gig_positions); // Re-index
        }
    }

    // Availability Options Management
    public function addAvailabilityOption()
    {
        $this->availability_options[] = [
            'datetime' => '',
            'description' => '',
        ];
    }

    public function removeAvailabilityOption($index)
    {
        if (isset($this->availability_options[$index])) {
            unset($this->availability_options[$index]);
            $this->availability_options = array_values($this->availability_options); // Re-index
        }
    }

    // ========================================
    // SAVE EVENT
    // ========================================
    public function save()
    {
        try {
            // Final validation
            $this->validate();
            
            // Handle image upload
            $imagePath = null;
            if ($this->event_image) {
                $storedPath = $this->event_image->store('events', 'public');
                $imagePath = '/storage/' . $storedPath;
            }

            // Prepare gig positions
            $gigPositions = !empty($this->gig_positions) ? array_values($this->gig_positions) : null;

            // Prepare tags
            $tagsArray = !empty($this->tags) ? $this->tags : null;

            // Handle festival events
            $festivalEvents = null;
            if ($this->category === Event::CATEGORY_FESTIVAL && !empty($this->selected_festival_events)) {
                $festivalEvents = $this->selected_festival_events;
            }

            // Create event
            $event = Event::create([
                // Basic Information
                'title' => $this->title,
                'subtitle' => $this->subtitle,
                'description' => $this->description,
                'requirements' => $this->requirements,
                'category' => $this->category,
                'is_public' => $this->is_public,

                // Date & Time
                'start_datetime' => $this->start_datetime ?: null,
                'end_datetime' => $this->end_datetime ?: null,
                'registration_deadline' => $this->has_registration_deadline && $this->registration_deadline_date && $this->registration_deadline_time
                    ? $this->registration_deadline_date . ' ' . $this->registration_deadline_time
                    : null,
                'invitation_deadline' => $this->invitation_deadline ?: null,

                // Availability
                'is_availability_based' => $this->is_availability_based,
                'availability_deadline' => $this->availability_deadline ?: null,
                'availability_instructions' => $this->availability_instructions,

                // Location
                'is_online' => $this->is_online,
                'online_url' => $this->online_url,
                'timezone' => $this->timezone,
                'venue_name' => $this->venue_name,
                'venue_address' => $this->venue_address,
                'city' => $this->city,
                'postcode' => $this->postcode,
                'country' => $this->country,
                'latitude' => $this->latitude ?: null,
                'longitude' => $this->longitude ?: null,

                // Recurrence
                'is_recurring' => $this->is_recurring,
                'recurrence_type' => $this->is_recurring && $this->recurrence_type ? $this->recurrence_type : null,
                'recurrence_interval' => $this->is_recurring ? $this->recurrence_interval : null,
                'recurrence_count' => $this->is_recurring && $this->recurrence_count ? $this->recurrence_count : null,
                'recurrence_weekdays' => $this->is_recurring && !empty($this->recurrence_weekdays) ? $this->recurrence_weekdays : null,
                'recurrence_monthday' => $this->is_recurring && $this->recurrence_monthday ? $this->recurrence_monthday : null,

                // Details
                'image_url' => $imagePath,
                'entry_fee' => $this->is_paid_event ? $this->ticket_price : 0,
                'gig_positions' => $gigPositions,
                'tags' => $tagsArray,

                // Settings
                'max_participants' => $this->max_participants ?: null,
                'allow_requests' => false, // Sempre false, solo ingaggi e inviti
                'status' => $this->status,

                // Festival
                'festival_id' => $this->category !== Event::CATEGORY_FESTIVAL && $this->festival_id ? $this->festival_id : null,
                'festival_events' => $festivalEvents,

                // Organizer
                'organizer_id' => Auth::id(),
                
                // Moderation (auto-approve for now)
                'moderation_status' => 'approved',
            ]);

            // Attach groups - Disabled for now (Group model not implemented)
            // if ($this->is_linked_to_group && !empty($this->selected_groups)) {
            //     $event->groups()->attach($this->selected_groups);
            // }

            // Handle invitations (participants)
            if (!empty($this->invitations)) {
                foreach ($this->invitations as $invitation) {
                    $isEmailInvitation = isset($invitation['is_email_invitation']) && $invitation['is_email_invitation'];
                    
                    if ($isEmailInvitation) {
                        // Email invitation for non-registered user
                        $eventInvitation = $event->invitations()->create([
                            'invited_user_id' => null,
                            'invited_email' => $invitation['email'],
                            'invited_name' => $invitation['name'],
                            'inviter_id' => Auth::id(),
                            'role' => $invitation['role'],
                            'status' => 'pending',
                        ]);

                        // Send email invitation
                        \Illuminate\Support\Facades\Mail::to($invitation['email'])->send(
                            new \App\Mail\EventInvitationEmail($eventInvitation, $event)
                        );
                    } else {
                        // Regular invitation for registered user
                        $eventInvitation = $event->invitations()->create([
                            'invited_user_id' => $invitation['user_id'],
                            'inviter_id' => Auth::id(),
                            'role' => $invitation['role'],
                            'status' => 'pending',
                        ]);
                        
                        // Send notification to invited user
                        $invitedUser = \App\Models\User::find($invitation['user_id']);
                        if ($invitedUser) {
                            $invitedUser->notify(new \App\Notifications\EventInvitationNotification($eventInvitation));
                        }
                    }
                }
            }

            // Handle audience invitations
            if (!empty($this->audienceInvitations)) {
                foreach ($this->audienceInvitations as $audience) {
                    $eventInvitation = $event->invitations()->create([
                        'invited_user_id' => $audience['user_id'],
                        'inviter_id' => Auth::id(),
                        'role' => 'audience',
                        'status' => 'pending',
                    ]);
                    
                    // Send notification to invited user
                    $invitedUser = \App\Models\User::find($audience['user_id']);
                    if ($invitedUser) {
                        $invitedUser->notify(new \App\Notifications\EventInvitationNotification($eventInvitation));
                    }
                }
            }

            // Handle availability options
            if ($this->is_availability_based && !empty($this->availability_options)) {
                foreach ($this->availability_options as $option) {
                    if (is_array($option) && !empty($option['datetime'])) {
                        $event->availabilityOptions()->create([
                            'datetime' => $option['datetime'],
                            'description' => $option['description'] ?? null,
                        ]);
                    }
                }
            }

            // Save recent venue if it's a physical event
            if (!$this->is_online && $this->venue_name) {
                \App\Models\RecentVenue::saveRecentVenue([
                    'venue_name' => $this->venue_name,
                    'venue_address' => $this->venue_address,
                    'city' => $this->city,
                    'postcode' => $this->postcode,
                    'country' => $this->country,
                    'latitude' => $this->latitude ?: null,
                    'longitude' => $this->longitude ?: null,
                ]);
            }

            // Create gigs from positions
            if (!empty($this->gig_positions)) {
                $event->createGigsFromPositions();
            }

            // Attach groups
            if ($this->is_linked_to_group && !empty($this->selected_groups)) {
                $event->groups()->attach($this->selected_groups);
            }

            session()->flash('success', 'Evento creato con successo!');
            
            return redirect()->route('events.show', $event);

        } catch (\Illuminate\Validation\ValidationException $e) {
            // Validation errors - let Livewire handle them
            throw $e;
        } catch (\Exception $e) {
            Log::error('Event creation failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'user_id' => Auth::id(),
            ]);

            session()->flash('error', 'Errore durante la creazione dell\'evento: ' . $e->getMessage());
        }
    }

    // ========================================
    // GROUP MANAGEMENT
    // ========================================
    public function updatedGroupSearch()
    {
        if (strlen($this->groupSearch) >= 2) {
            $user = Auth::user();
            
            // Cerca solo nei gruppi di cui l'utente è membro o moderatore
            $this->searchedGroups = \App\Models\Group::where(function($query) {
                $query->where('name', 'like', '%' . $this->groupSearch . '%')
                      ->orWhere('description', 'like', '%' . $this->groupSearch . '%');
            })
            ->where(function($query) use ($user) {
                $query->where('visibility', 'public')
                      ->orWhereHas('members', function($q) use ($user) {
                          $q->where('user_id', $user->id);
                      });
            })
            ->withCount('members')
            ->limit(10)
            ->get();
        } else {
            $this->searchedGroups = [];
        }
    }

    public function toggleGroup($groupId)
    {
        if (in_array($groupId, $this->selected_groups)) {
            // Rimuovi
            $this->selected_groups = array_values(array_filter($this->selected_groups, function($id) use ($groupId) {
                return $id !== $groupId;
            }));
        } else {
            // Aggiungi
            $this->selected_groups[] = $groupId;
        }
    }

    // ========================================
    // RENDER
    // ========================================
    public function render()
    {
        return view('livewire.events.event-creation', [
            'categories' => Event::getCategories(),
        ])->layout('components.layouts.app');
    }
}

