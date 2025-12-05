<?php

namespace App\Livewire\Admin\Newsletter;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\NewsletterSubscriber;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class NewsletterManagement extends Component
{
    use WithPagination;

    // Tabs
    public $activeTab = 'subscribers'; // subscribers, send, statistics

    // Subscribers list
    public $search = '';
    public $statusFilter = 'all'; // all, active, unsubscribed

    // Send newsletter
    public $showSendModal = false;
    public $subject = '';
    public $content = '';
    public $sendTo = 'all'; // all, active, custom
    public $customEmails = '';
    public $sending = false;

    // Statistics
    public $stats = [];

    public function mount()
    {
        $this->loadStats();
    }

    public function loadStats()
    {
        $this->stats = [
            'total' => NewsletterSubscriber::count(),
            'active' => NewsletterSubscriber::where('status', 'active')->count(),
            'unsubscribed' => NewsletterSubscriber::where('status', 'unsubscribed')->count(),
            'bounced' => NewsletterSubscriber::where('status', 'bounced')->count(),
            'this_month' => NewsletterSubscriber::whereMonth('subscribed_at', now()->month)
                ->whereYear('subscribed_at', now()->year)
                ->count(),
        ];
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedStatusFilter()
    {
        $this->resetPage();
    }

    public function getSubscribersProperty()
    {
        $query = NewsletterSubscriber::query();

        if ($this->search) {
            $query->where(function($q) {
                $q->where('email', 'like', '%' . $this->search . '%')
                  ->orWhere('name', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->statusFilter !== 'all') {
            $query->where('status', $this->statusFilter);
        }

        return $query->orderBy('subscribed_at', 'desc')->paginate(20);
    }

    public function toggleStatus($id)
    {
        $subscriber = NewsletterSubscriber::findOrFail($id);
        
        if ($subscriber->status === 'active') {
            $subscriber->unsubscribe();
            session()->flash('success', 'Iscritto disattivato con successo');
        } else {
            $subscriber->resubscribe();
            session()->flash('success', 'Iscritto riattivato con successo');
        }

        $this->loadStats();
    }

    public function deleteSubscriber($id)
    {
        NewsletterSubscriber::findOrFail($id)->delete();
        session()->flash('success', 'Iscritto eliminato con successo');
        $this->loadStats();
    }

    public function openSendModal()
    {
        $this->showSendModal = true;
        $this->subject = '';
        $this->content = '';
        $this->sendTo = 'all';
        $this->customEmails = '';
    }

    public function closeSendModal()
    {
        $this->showSendModal = false;
        $this->sending = false;
    }

    public function sendNewsletter()
    {
        $this->validate([
            'subject' => 'required|string|max:255',
            'content' => 'required|string|min:10',
            'sendTo' => 'required|in:all,custom',
            'customEmails' => 'required_if:sendTo,custom|string',
        ], [
            'subject.required' => 'Il soggetto è obbligatorio',
            'content.required' => 'Il contenuto è obbligatorio',
            'content.min' => 'Il contenuto deve essere di almeno 10 caratteri',
            'customEmails.required_if' => 'Inserisci almeno un indirizzo email',
        ]);

        $this->sending = true;

        try {
            // Get recipients
            $recipients = [];
            
            if ($this->sendTo === 'all') {
                // Tutti gli iscritti attivi alla newsletter
                $recipients = NewsletterSubscriber::where('status', 'active')->pluck('email')->toArray();
            } elseif ($this->sendTo === 'custom') {
                $emails = array_map('trim', explode(',', $this->customEmails));
                $emails = array_filter($emails, function($email) {
                    return filter_var($email, FILTER_VALIDATE_EMAIL);
                });
                $recipients = array_values($emails);
            }

            if (empty($recipients)) {
                session()->flash('error', 'Nessun destinatario valido trovato');
                $this->sending = false;
                return;
            }

            // Send emails
            $sent = 0;
            $failed = 0;

            foreach ($recipients as $email) {
                try {
                    $subscriber = NewsletterSubscriber::where('email', $email)->first();
                    
                    Mail::to($email)->send(new \App\Mail\NewsletterEmail(
                        $this->subject,
                        $this->content,
                        $subscriber
                    ));
                    
                    $sent++;
                } catch (\Exception $e) {
                    Log::error('Error sending newsletter email', [
                        'email' => $email,
                        'error' => $e->getMessage()
                    ]);
                    $failed++;
                }
            }

            session()->flash('success', "Newsletter inviata! Inviate: {$sent}, Fallite: {$failed}");
            $this->closeSendModal();
            
        } catch (\Exception $e) {
            Log::error('Error sending newsletter', [
                'error' => $e->getMessage()
            ]);
            session()->flash('error', 'Errore durante l\'invio della newsletter: ' . $e->getMessage());
            $this->sending = false;
        }
    }

    public function render()
    {
        return view('livewire.admin.newsletter.newsletter-management', [
            'subscribers' => $this->subscribers,
        ]);
    }
}
