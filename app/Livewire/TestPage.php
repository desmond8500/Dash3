<?php

namespace App\Livewire;

use App\Http\Controllers\PDFController;
use App\Models\Article;
use App\Models\Brand;
use App\Models\Demo;
use App\Models\Provider;
use Barryvdh\DomPDF\PDF;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Spatie\Browsershot\Browsershot;

class TestPage extends Component
{
    use WithFileUploads;
    public $content = 'ff';
    public $cartes;
    public $selected_card = 0;

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
                'link'=>'',
                'description' => '',
                "data" => 0,
                "data_name" => "",
            ),
            (object) array(
                'id'=> 2,
                'name' => 'Calcul de batteries',
                'view'=> 'tools.battery_calc',
                'class' => '',
                'type' => 'livewire',
                'link'=>'',
                'description' => '',
                "data" => 0,
                "data_name" => "",
            ),
            (object) array(
                'id'=> 3,
                'name' => 'User card card',
                'view'=> '_card.user_card',
                'class' => 'col-md-4',
                'type' => 'include',
                'link'=> 'https://dribbble.com/shots/24839357-Meet-our-magic-team-Untitled-UI',
                'description' => '',
                "data" => 0,
                "data_name" => "",
            ),
            (object) array(
                'id' => 5,
                'name' => 'Modal',
                'view' => 'modal',
                'class' => '',
                'type' => 'livewire',
                'link' => '',
                'description' => '',
                "data" => 0,
                "data_name" => "",
            ),
            (object) array(
                'id' => 6,
                'name' => 'Task card 1',
                'view' => '_card.task1_card',
                'class' => '',
                'type' => 'include',
                'link' => '',
                'description' => '',
                "data" => 0,
                "data_name" => "",
            ),
            (object) array(
                'id' => 4,
                'name' => 'Article card',
                'view' => '_card.articleCard',
                'class' => '',
                'type' => 'include',
                'link' => '',
                'description' => '',
                "data" => Article::find(1),
                "data_name" => "article",
            ),
            (object) array(
                'id' => 7,
                'name' => 'Article card 1',
                'view' => '_card.articleCard1',
                'class' => '',
                'type' => 'include',
                'link' => '',
                'description' => '',
                "data" => 0,
                "data_name" => "",
            ),
            (object) array(
                'id' => 8,
                'name' => 'Article card 2',
                'view' => '_card.articleCard2',
                'class' => '',
                'type' => 'include',
                'link' => '',
                'description' => '',
                "data" => 0,
                "data_name" => "",
            ),
            (object) array(
                'id' => 9,
                'name' => 'Article card 3',
                'view' => '_card.articleCard3',
                'class' => '',
                'type' => 'include',
                'link' => '',
                'description' => '',
                "data" => 0,
                "data_name" => "",
            ),
            (object) array(
                'id' => 10,
                'name' => 'Statut',
                'view' => 'volt.progress',
                'class' => '',
                'type' => 'livewire',
                'link' => '',
                'description' => 'Gestion des statuts dans des badges',
                "data" => 0,
                "data_name" => "",
            ),
            (object) array(
                'id' => 10,
                'name' => 'fabric',
                'view' => 'test.fabric-test',
                'class' => '',
                'type' => 'livewire',
                'link' => '',
                'description' => 'Dessins graphiques',
                "data" => 0,
                "data_name" => "",
            ),
            // (object) array( 'id'=> 3, 'name' => 'Article card', 'view'=> '_card.articleCard'),
        );

        $this->size = (object) array('height' => 1500, 'width' => 600);

        $this->cartes = glob('../resources/views/_card/*');
        // $this->cartes = Storage::disk('local')->directories("");
    }

    public $images = [
        ['url' => 'img/icons/001-shield.png', 'title' => 'Image 1'],
        ['url' => 'img/icons/002-cyber-security.png', 'title' => 'Image 2'],
    ];

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
    public $size;

    public $height = 600;
    public $width = 600;

    function add_demo(){
        Demo::create([
            'name' => $this->name,
            'description' => $this->description,
            "data" => 0,
            "data_name" => "",
        ]);
        $this->reset('name', 'description');
    }

    function delete_demo($id){
        Demo::find($id)->delete();
    }

    function pdf(){
        $template = view('_pdf.test')->render();
        return Browsershot::html($template)->save('example3.pdf');
    }

    public $shapes = [];

    public $count = 'bet';
    public $cercle =  array(
        'x' => 400,
        'y' => 100,
        'radius' => 70,
        'fill' => 'yellow',
        'stroke' => 'black',
        'strokeWidth' => 4,
    );

    public function addCircle()
    {
        $this->shapes[] = [
            'type' => 'circle',
            'x' => rand(50, 300),
            'y' => rand(50, 300),
            'radius' => 30,
            'fill' => 'red',
        ];
    }


    function test(){
        $this->js('alert("test");');
    }


    public $items = [];
    public $subitems = [];
    public function addItem(){
        $this->items[] = (object) array('name' => '', 'quantity' => 1, 'subitems' => (object) array());
    }
    public function addSubItem(object $item){
        $item[] = ['name' => '', 'quantity' => 1];
    }

    function testpdf(){
        return PDFController::pdf_v1();
    }
}

