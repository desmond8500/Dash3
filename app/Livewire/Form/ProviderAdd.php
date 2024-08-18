<?php

namespace App\Livewire\Form;

use App\Models\Provider;
use Livewire\Attributes\Validate;
use Livewire\Component;

class ProviderAdd extends Component
{
    #[Validate('required')]
    public $name;
    public $logo;
    public $address;
    public $description;

    public function render()
    {
        return view('livewire.form.provider-add');
    }

    function store(){
        $this->validate();

        Provider::create([
            'name' => ucfirst($this->name),
            'address' => ucfirst($this->address),
            'description' => ucfirst($this->description),
        ]);
        // session()->flash('status', 'Post successfully updated.');
        $this->dispatch('close-addProvider');
        $this->dispatch('grefresh-article');
    }
}


// Model
// #[Validate('required')]
// public $name;
// public $logo;
// public $address;
// public $description;

// function store(){
//     $this->validate();
//     Model::create([
//         'attr1' => ucfirst($this->attr1),
//         'attr2' => $this->attr2,
//         'attr3' => $this->attr3,
//     ]);
//     $this->dispatchBrowserEvent('close-modal');
// }

// function edit($model_id){
//     $this->model_id = $model_id;
//     $model = Model::find($model_id);
//     $this->attr1 = $model->attr1;
//     $this->attr2 = $model->attr2;
//     $this->attr3 = $model->attr3;
// }

// function update(){
//     $model = Model::find($this->model_id);
//     $model->attr1 = $this->attr1;
//     $model->attr2 = $this->attr2;
//     $model->attr3 = $this->attr3;
//     $model->save();
//     $this->reset('model_id');
//     $this->render();
// }
// function delete()
// {
//     $model = Model::find($this->model_id);

//     $model->delete();
//     $this->render();
// }
