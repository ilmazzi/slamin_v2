<?php

namespace App\Livewire\Profile;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use App\Services\PeerTubeService;

class DeleteAccount extends Component
{
    public $password = '';
    public $reason = '';
    public $confirmText = '';
    
    protected function rules()
    {
        return [
            'password' => 'required|string',
            'reason' => 'nullable|string|max:1000',
            'confirmText' => 'required|string',
        ];
    }
    
    protected function messages()
    {
        return [
            'password.required' => __('account_deletion.password_required'),
            'confirmText.required' => __('account_deletion.confirm_text_required'),
            'confirmText.in' => __('account_deletion.confirm_text_invalid'),
        ];
    }
    
    public function deleteAccount()
    {
        $this->validate();
        
        // Verify confirmation text based on language
        $validConfirmTexts = ['ELIMINA', 'DELETE', 'SUPPRIMER'];
        if (!in_array(strtoupper($this->confirmText), $validConfirmTexts)) {
            $this->addError('confirmText', __('account_deletion.confirm_text_invalid'));
            return;
        }
        
        $user = Auth::user();
        
        // Verify password
        if (!Hash::check($this->password, $user->password)) {
            $this->addError('password', __('account_deletion.password_incorrect'));
            return;
        }
        
        // Delete PeerTube account if exists
        if ($user->peertube_user_id) {
            try {
                $peerTubeService = app(PeerTubeService::class);
                $deleted = $peerTubeService->deleteUser($user->peertube_user_id);
                
                if ($deleted) {
                    Log::info('Account PeerTube eliminato con successo', [
                        'user_id' => $user->id,
                        'peertube_user_id' => $user->peertube_user_id
                    ]);
                } else {
                    Log::warning('Impossibile eliminare account PeerTube, continuo con eliminazione locale', [
                        'user_id' => $user->id,
                        'peertube_user_id' => $user->peertube_user_id
                    ]);
                }
            } catch (\Exception $e) {
                Log::error('Errore eliminazione account PeerTube', [
                    'user_id' => $user->id,
                    'peertube_user_id' => $user->peertube_user_id,
                    'error' => $e->getMessage()
                ]);
                // Continua comunque con l'eliminazione locale
            }
        }
        
        // Save deletion reason
        $user->deletion_reason = $this->reason;
        $user->save();
        
        // Soft delete the account
        $user->delete();
        
        // Logout the user
        Auth::logout();
        
        // Invalidate the session
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        
        // Redirect to home with message
        session()->flash('message', __('account_deletion.success'));
        return redirect()->route('home');
    }
    
    public function render()
    {
        return view('livewire.profile.delete-account');
    }
}
