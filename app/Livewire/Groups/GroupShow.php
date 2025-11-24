<?php

namespace App\Livewire\Groups;

use Livewire\Component;
use Livewire\Attributes\Title;
use App\Models\Group;
use App\Models\GroupMember;
use App\Models\GroupJoinRequest;
use App\Models\GroupAnnouncement;
use Illuminate\Support\Facades\Auth;

class GroupShow extends Component
{
    public Group $group;
    public $activeSection = 'about';
    
    // Announcement form
    public $showAnnouncementForm = false;
    public $announcementTitle = '';
    public $announcementContent = '';
    public $announcementIsPinned = false;

    public function mount(Group $group)
    {
        $this->group = $group;
    }

    public function title(): string
    {
        return $this->group->name;
    }

    public function switchSection($section)
    {
        $this->activeSection = $section;
    }

    public function joinGroup()
    {
        if (!Auth::check()) {
            return $this->redirect(route('login'));
        }

        $user = Auth::user();

        // Verifica se è già membro
        if ($this->group->hasMember($user)) {
            session()->flash('error', __('groups.already_member'));
            return;
        }

        // Verifica se ha già una richiesta pendente
        if ($this->group->hasPendingJoinRequest($user)) {
            session()->flash('error', __('groups.request_already_sent'));
            return;
        }

        if ($this->group->visibility === 'public') {
            // Aggiungi direttamente
            GroupMember::create([
                'group_id' => $this->group->id,
                'user_id' => $user->id,
                'role' => 'member',
            ]);
            
            session()->flash('success', __('groups.joined_successfully'));
        } else {
            // Crea richiesta
            GroupJoinRequest::create([
                'group_id' => $this->group->id,
                'user_id' => $user->id,
                'status' => 'pending',
            ]);
            
            session()->flash('success', __('groups.request_sent'));
        }

        $this->group->refresh();
    }

    public function leaveGroup()
    {
        if (!Auth::check()) {
            return;
        }

        $user = Auth::user();
        $member = $this->group->members()->where('user_id', $user->id)->first();

        if (!$member) {
            return;
        }

        // Non permettere al creatore di lasciare se è l'unico admin
        if ($member->role === 'admin') {
            $adminCount = $this->group->members()->where('role', 'admin')->count();
            if ($adminCount === 1) {
                session()->flash('error', __('groups.cannot_leave_as_last_admin'));
                return;
            }
        }

        $member->delete();
        
        session()->flash('success', __('groups.left_successfully'));
        
        return $this->redirect(route('groups.index'), navigate: true);
    }

    public function getMembersProperty()
    {
        return $this->group->members()->with('user')->latest()->get();
    }

    public function getAnnouncementsProperty()
    {
        return $this->group->announcements()
            ->with('author')
            ->orderBy('is_pinned', 'desc')
            ->latest()
            ->get();
    }

    public function createAnnouncement()
    {
        if (!Auth::check() || !$this->isModerator) {
            session()->flash('error', 'Non hai i permessi per creare annunci');
            return;
        }

        $this->validate([
            'announcementTitle' => 'required|string|max:255',
            'announcementContent' => 'required|string',
        ]);

        GroupAnnouncement::create([
            'group_id' => $this->group->id,
            'user_id' => Auth::id(),
            'title' => $this->announcementTitle,
            'content' => $this->announcementContent,
            'is_pinned' => $this->announcementIsPinned,
        ]);

        // Reset form
        $this->announcementTitle = '';
        $this->announcementContent = '';
        $this->announcementIsPinned = false;
        $this->showAnnouncementForm = false;

        session()->flash('success', 'Annuncio pubblicato con successo');
    }

    public function togglePinAnnouncement($announcementId)
    {
        if (!Auth::check() || !$this->isModerator) {
            session()->flash('error', 'Non hai i permessi per modificare annunci');
            return;
        }

        $announcement = GroupAnnouncement::findOrFail($announcementId);
        
        if ($announcement->group_id !== $this->group->id) {
            return;
        }

        $announcement->update(['is_pinned' => !$announcement->is_pinned]);
        
        session()->flash('success', $announcement->is_pinned ? 'Annuncio fissato' : 'Annuncio sbloccato');
    }

    public function deleteAnnouncement($announcementId)
    {
        if (!Auth::check() || !$this->isModerator) {
            session()->flash('error', 'Non hai i permessi per eliminare annunci');
            return;
        }

        $announcement = GroupAnnouncement::findOrFail($announcementId);
        
        if ($announcement->group_id !== $this->group->id) {
            return;
        }

        $announcement->delete();
        
        session()->flash('success', 'Annuncio eliminato con successo');
    }

    public function getEventsProperty()
    {
        return $this->group->linkedEvents()->latest()->take(10)->get();
    }

    public function getUserRoleProperty()
    {
        if (!Auth::check()) {
            return null;
        }
        return $this->group->getUserRole(Auth::user());
    }

    public function getIsMemberProperty()
    {
        if (!Auth::check()) {
            return false;
        }
        return $this->group->hasMember(Auth::user());
    }

    public function getIsAdminProperty()
    {
        if (!Auth::check()) {
            return false;
        }
        return $this->group->hasAdmin(Auth::user());
    }

    public function getIsModeratorProperty()
    {
        if (!Auth::check()) {
            return false;
        }
        return $this->group->hasModerator(Auth::user());
    }

    public function render()
    {
        return view('livewire.groups.group-show', [
            'members' => $this->members,
            'announcements' => $this->announcements,
            'events' => $this->events,
            'userRole' => $this->userRole,
            'isMember' => $this->isMember,
            'isAdmin' => $this->isAdmin,
            'isModerator' => $this->isModerator,
        ]);
    }
}
