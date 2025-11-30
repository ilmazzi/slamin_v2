<?php

namespace App\Livewire\Profile;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Services\UserDataExportService;

class ExportData extends Component
{
    public $exportInProgress = false;
    public $exportReady = false;
    public $exportPath = null;
    
    protected $exportService;
    
    public function boot(UserDataExportService $exportService)
    {
        $this->exportService = $exportService;
    }
    
    public function generateExport()
    {
        $this->exportInProgress = true;
        
        try {
            $user = Auth::user();
            $this->exportPath = $this->exportService->generateDownloadableFile($user);
            
            $this->exportReady = true;
            $this->dispatch('notify', [
                'type' => 'success',
                'message' => __('data_export.export_success')
            ]);
        } catch (\Exception $e) {
            $this->dispatch('notify', [
                'type' => 'error',
                'message' => __('data_export.export_error')
            ]);
        } finally {
            $this->exportInProgress = false;
        }
    }
    
    public function downloadExport()
    {
        if (!$this->exportReady || !$this->exportPath) {
            return;
        }
        
        return Storage::disk('local')->download($this->exportPath);
    }
    
    public function render()
    {
        return view('livewire.profile.export-data');
    }
}
