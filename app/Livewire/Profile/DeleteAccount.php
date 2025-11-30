<?php

namespace App\Livewire\Profile;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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
