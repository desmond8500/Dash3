<?php

namespace App\Livewire\Settings;

use App\Models\User;
use Livewire\Component;

class Userslist extends Component
{
    public $search;
    public $selected;

    public function render()
    {
        return view('livewire.settings.userslist',[
            'users' => User::search($this->search, 'firstname')
                ->search($this->search, 'lasttname')
                ->search($this->search, 'email')
                ->paginate(5)
                ,
        ]);
    }

    function select_user($user_id){
        $this->selected = User::find($user_id);
    }
}
