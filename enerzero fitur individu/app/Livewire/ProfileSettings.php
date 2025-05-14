<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\UserProfile;
use Illuminate\Support\Facades\Auth;

class ProfileSettings extends Component
{
    public $name, $email, $phone;

    public function mount()
    {
        $profile = UserProfile::where('user_id', Auth::id())->first();
        if ($profile) {
            $this->name = $profile->name;
            $this->email = $profile->email;
            $this->phone = $profile->phone;
        }
    }

    public function updateProfile()
    {
        $this->validate([
            'name' => 'required',
            'email' => 'required|email',
        ]);

        $profile = UserProfile::where('user_id', Auth::id())->first();
        if ($profile) {
            $profile->update([
                'name' => $this->name,
                'email' => $this->email,
                'phone' => $this->phone,
            ]);
        }

        session()->flash('message', 'Profil berhasil diperbarui.');
    }

    public function render()
    {
        return view('livewire.profile-settings');
    }
}
