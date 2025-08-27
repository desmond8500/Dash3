<?php

namespace App\Livewire;

use App\Models\Myproject;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;
use Livewire\WithPagination;

class MyprojectsPage extends Component
{
    use WithPagination;
    use WithFileUploads;

    public $search = '';

    public function render()
    {
        return view('livewire.myprojects-page',[
            'projects' => Myproject::search($this->search)->paginate(20)
        ]);
    }


}
