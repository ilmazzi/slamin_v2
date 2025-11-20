<?php

namespace App\Livewire\Admin\Gigs;

use Livewire\Component;
use App\Models\GigPosition;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class GigPositionList extends Component
{
    public $positions = [];
    public $showForm = false;
    public $editingId = null;
    public $formData = [
        'name' => '',
        'key' => '',
        'description' => '',
        'is_active' => true,
        'sort_order' => 0,
    ];

    public function mount()
    {
        if (!Auth::check() || !Auth::user()->hasRole('admin')) {
            abort(403, 'Accesso negato');
        }

        $this->loadPositions();
    }

    public function loadPositions()
    {
        $this->positions = GigPosition::orderBy('sort_order', 'asc')->get()->toArray();
    }

    public function create()
    {
        $this->resetForm();
        $this->showForm = true;
        $this->editingId = null;
    }

    public function edit($id)
    {
        $position = GigPosition::findOrFail($id);
        $this->formData = $position->toArray();
        $this->editingId = $id;
        $this->showForm = true;
    }

    public function save()
    {
        $validated = $this->validate([
            'formData.name' => 'required|string|max:255',
            'formData.key' => 'required|string|max:255|unique:gig_positions,key,' . ($this->editingId ?? 'NULL'),
            'formData.description' => 'nullable|string',
            'formData.is_active' => 'boolean',
            'formData.sort_order' => 'integer|min:0',
        ]);

        try {
            if ($this->editingId) {
                $position = GigPosition::findOrFail($this->editingId);
                $position->update($validated['formData']);
                session()->flash('success', __('admin.gig_positions.updated_success'));
            } else {
                GigPosition::create($validated['formData']);
                session()->flash('success', __('admin.gig_positions.created_success'));
            }

            $this->loadPositions();
            $this->resetForm();
            $this->showForm = false;
        } catch (\Exception $e) {
            session()->flash('error', __('admin.gig_positions.save_error') . ': ' . $e->getMessage());
        }
    }

    public function delete($id)
    {
        $position = GigPosition::findOrFail($id);

        if ($position->gigs()->count() > 0) {
            session()->flash('error', __('admin.gig_positions.cannot_delete_in_use'));
            return;
        }

        try {
            $position->delete();
            session()->flash('success', __('admin.gig_positions.deleted_success'));
            $this->loadPositions();
        } catch (\Exception $e) {
            session()->flash('error', __('admin.gig_positions.delete_error') . ': ' . $e->getMessage());
        }
    }

    public function toggleStatus($id)
    {
        $position = GigPosition::findOrFail($id);
        $position->update(['is_active' => !$position->is_active]);
        $this->loadPositions();
        session()->flash('success', __('admin.gig_positions.status_updated'));
    }

    private function resetForm()
    {
        $this->formData = [
            'name' => '',
            'key' => '',
            'description' => '',
            'is_active' => true,
            'sort_order' => 0,
        ];
        $this->editingId = null;
    }

    public function render()
    {
        return view('livewire.admin.gigs.gig-position-list')
            ->layout('components.layouts.app');
    }
}

