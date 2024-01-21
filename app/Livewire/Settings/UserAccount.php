<?php

namespace App\Livewire\Settings;

use App\Livewire\Forms\UserForm;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class UserAccount extends Component
{
    use WithFileUploads;
    public UserForm $userForm;

    public function render()
    {
        $this->setUser();
        return view('livewire.settings.user-account',[
            'user' => auth()->user()
        ]);
    }

    function setUser(){
        $user = auth()->user();
        $this->firstname = $user->firstname;
        $this->lastname = $user->lastname;
    }

    public $avatar;
    function updateAvatar(){
        $this->userForm->updateAvatar($this->avatar);
        $this->reset('avatar');
    }

    public $firstname, $lastname;
    function nameUpdate(){
        $user = auth()->user();
        $user->firstname = $this->firstname;
        $user->lastname = $this->lastname;
        $user->save();
    }
}
