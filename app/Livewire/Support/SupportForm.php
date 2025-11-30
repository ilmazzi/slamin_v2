<?php

namespace App\Livewire\Support;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use App\Models\SupportTicket;

class SupportForm extends Component
{
    use WithFileUploads;

    public $name = '';
    public $email = '';
    public $category = '';
    public $subject = '';
    public $message = '';
    public $attachments = [];
    
    public $submitted = false;
    public $ticketId = null;

    public function mount()
    {
        // Pre-fill if user is logged in
        if (Auth::check()) {
            $user = Auth::user();
            $this->name = $user->name;
            $this->email = $user->email;
        }
    }

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'category' => 'required|string|in:technical,account,content,other',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|min:10|max:5000',
            'attachments.*' => 'nullable|file|max:10240', // 10MB max per file
        ];
    }

    protected function messages()
    {
        return [
            'name.required' => __('support.name_required'),
            'email.required' => __('support.email_required'),
            'email.email' => __('support.email_invalid'),
            'category.required' => __('support.category_required'),
            'subject.required' => __('support.subject_required'),
            'message.required' => __('support.message_required'),
            'message.min' => __('support.message_min'),
            'attachments.*.max' => __('support.attachment_max_size'),
        ];
    }

    public function submit()
    {
        $this->validate();

        try {
            // Save attachments
            $savedAttachments = [];
            if (!empty($this->attachments)) {
                foreach ($this->attachments as $attachment) {
                    $path = $attachment->store('support-attachments', 'public');
                    $savedAttachments[] = [
                        'name' => $attachment->getClientOriginalName(),
                        'path' => $path,
                        'size' => $attachment->getSize(),
                    ];
                }
            }

            // Create ticket
            $ticket = SupportTicket::create([
                'user_id' => Auth::id(),
                'name' => $this->name,
                'email' => $this->email,
                'category' => $this->category,
                'subject' => $this->subject,
                'message' => $this->message,
                'attachments' => $savedAttachments,
                'status' => 'open',
            ]);

            // Send email notification (simple version)
            $this->sendNotificationEmail($ticket);

            $this->submitted = true;
            $this->ticketId = $ticket->id;

            $this->dispatch('notify', [
                'type' => 'success',
                'message' => __('support.ticket_created_success')
            ]);

        } catch (\Exception $e) {
            $this->dispatch('notify', [
                'type' => 'error',
                'message' => __('support.ticket_creation_error')
            ]);
        }
    }

    protected function sendNotificationEmail($ticket)
    {
        try {
            // Simple email notification - you can customize this
            Mail::raw(
                "New Support Ticket #{$ticket->id}\n\n" .
                "From: {$ticket->name} ({$ticket->email})\n" .
                "Category: {$ticket->category}\n" .
                "Subject: {$ticket->subject}\n\n" .
                "Message:\n{$ticket->message}",
                function ($message) use ($ticket) {
                    $message->to('mail@slamin.it')
                        ->subject("New Support Ticket #{$ticket->id}: {$ticket->subject}");
                }
            );
        } catch (\Exception $e) {
            // Log error but don't fail the ticket creation
            \Log::error('Failed to send support ticket email', [
                'ticket_id' => $ticket->id,
                'error' => $e->getMessage()
            ]);
        }
    }

    public function render()
    {
        return view('livewire.support.support-form')
            ->layout('components.layouts.app')
            ->title(__('support.page_title'));
    }
}
