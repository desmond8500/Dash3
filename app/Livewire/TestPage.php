<?php

namespace App\Livewire;

use App\Models\Brand;
use App\Models\Demo;
use App\Models\Provider;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class TestPage extends Component
{
    use WithFileUploads;
    public $content = 'ff';

    public function updatedContent()
    {
        $this->dispatchBrowserEvent('contentUpdated');
    }

    function get($content){
        $this->content = $content ?? 'ret';
    }

    function mount(){
        $this->widgets = (object) array(
            (object) array(
                'id'=> 1,
                'name' => 'Invoice resume card',
                'view'=> '_card.invoice_resume_card',
                'class' => '',
                'type' => 'include',
                'link'=>''),
            (object) array(
                'id'=> 1,
                'name' => 'Invoice resume card',
                'view'=> '_card.invoice_resume_card',
                'class' => '',
                'type' => 'include',
                'link'=>''),
            (object) array(
                'id'=> 2,
                'name' => 'Calcul de batteries',
                'view'=> 'tools.battery_calc',
                'class' => '',
                'type' => 'livewire',
                'link'=>''),
            (object) array(
                'id'=> 3,
                'name' => 'User card card',
                'view'=> '_card.user_card',
                'class' => 'col-md-4',
                'type' => 'include',
                'link'=> 'https://dribbble.com/shots/24839357-Meet-our-magic-team-Untitled-UI'),
            (object) array(
                'id' => 5,
                'name' => 'Modal',
                'view' => 'modal',
                'class' => '',
                'type' => 'livewire',
                'link' => ''
            ),
            (object) array(
                'id' => 6,
                'name' => 'Task card 1',
                'view' => '_card.task1_card',
                'class' => '',
                'type' => 'include',
                'link' => ''
            ),
            (object) array(
                'id' => 7,
                'name' => 'Article card 1',
                'view' => '_card.articleCard1',
                'class' => '',
                'type' => 'include',
                'link' => ''
            ),
            (object) array(
                'id' => 8,
                'name' => 'Article card 2',
                'view' => '_card.articleCard2',
                'class' => '',
                'type' => 'include',
                'link' => ''
            ),
            (object) array(
                'id' => 9,
                'name' => 'Article card 3',
                'view' => '_card.articleCard3',
                'class' => '',
                'type' => 'include',
                'link' => ''
            ),
            // (object) array( 'id'=> 3, 'name' => 'Article card', 'view'=> '_card.articleCard'),
        );
    }

    public function render(){
        return view('livewire.test-page',[
            'providers' => Provider::all(),
            'brands' => Brand::all(),
            'demos' => Demo::all(),
        ]);
    }

    public $title;
    public $selected_widget = 0;
    public $widgets;

    public function trix_save($content)
    {
       $this->title = $content;
    }

    function store(){
        $url = "http://www.google.co.in/intl/en_com/images/srpr/logo1w.png";
        $contents = file_get_contents($url);
        $name = substr($url, strrpos($url, '/') + 1);
        $dir = "test/avatar";
        Storage::disk('public')->put("$dir/$name", $contents);
        dd("storage/$dir/$name");
    }

    public $name;
    public $description;

    function add_demo(){
        Demo::create([
            'name' => $this->name,
            'description' => $this->description,
        ]);
        $this->reset('name', 'description');
    }

    function delete_demo($id){
        Demo::find($id)->delete();
    }
}

