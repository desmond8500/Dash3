<?php

namespace App\Livewire;

use App\Livewire\Forms\UserForm;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class ProfilePage extends Component
{
    use WithFileUploads;

    public $breadcrumbs;
    public UserForm $user_form;

    public function mount(){
        $this->breadcrumbs = array(
            array('name' => 'Réglages', 'route' => route('settings')),
            array('name' => 'Profile', 'route' => route('profile')),
        );
    }

    public function render()
    {
        return view('livewire.profile-page',[
            'user' => auth()->user()
        ]);
    }

    function edit(){
        $this->user_form->set();
        $this->dispatch('open-editUser');
    }

    function update(){
        $this->user_form->update();
        $this->dispatch('close-editUser');
    }

    // Avatar
    public $avatar;

    function edit_avatar()
    {
        $this->dispatch('open-editUserAvatar');
    }

    function update_avatar()
    {
        $this->user_form->set();
        $this->user_form->updateAvatar($this->avatar);
        $this->dispatch('close-editUserAvatar');
        $this->reset('avatar', );
    }

    // Password
    function edit_password()
    {
        $this->dispatch('open-editPassword');
    }

    function update_password()
    {
        $this->user_form->set();
        $this->user_form->updateAvatar($this->avatar);
        $this->dispatch('close-editPassword');
        $this->reset('avatar', );
    }
}
