<?php

namespace App\Livewire\Student\Settings;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class Password extends Component {

    /**
     * Property: Current password input by the user
     */
    public string $currentPassword = '';

    /**
     * Property: New password input by the user
     */
    public string $newPassword = '';

    /**
     * Property: New password confirmation input by the user
     */
    public string $newPasswordConfirmation = '';

    /**
     * Lifecycle hook: Render the component view
     */
    public function render() {
        return view('livewire.student.settings.password');
    }

    /**
     * Handle the password update form submission
     */
    public function save() {
        $this->validate([
            'currentPassword' => 'required',
            'newPassword' => 'required|string|min:8|max:255',
            'newPasswordConfirmation' => 'required|string|min:8|max:255',
        ]);

        $user = User::find(Auth::id());

        if ($this->newPassword !== $this->newPasswordConfirmation) {
            $this->addError('newPasswordConfirmation', 'La conferma della nuova password non corrisponde.');
            return;
        }

        if (!Hash::check($this->currentPassword, $user->password)) {
            $this->addError('currentPassword', 'La password attuale è errata.');
            return;
        }

        $user->password = Hash::make($this->newPassword);
        $user->save();

        session()->flash('passwordSuccess', 'Password aggiornata con successo.');
    }
}
