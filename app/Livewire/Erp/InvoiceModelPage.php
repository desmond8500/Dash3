<?php

namespace App\Livewire\Erp;

use App\Livewire\Forms\InvoiceModelForm;
use App\Livewire\Forms\InvoiceSystemForm;
use App\Models\Article;
use App\Models\Brand;
use App\Models\InvoiceModel;
use App\Models\InvoiceSystem;
use App\Models\Provider;
use Livewire\Component;
use Livewire\WithPagination;

class InvoiceModelPage extends Component
{
    use WithPagination;
    public $breadcrumbs;
    protected $paginationTheme = 'bootstrap';

    public $search;

    public $brand_id;
    public $provider_id;
    public $priorite_id = 25;

    public $priorites;

    public function mount(){
        $this->breadcrumbs = array(
            array('name' => 'Modèles de devis', 'route' => route('invoice_model')),
        );
    }

    public function render()
    {
        return view('livewire.erp.invoice-model-page',[
            'systems' => InvoiceSystem::all(),
            'articles' => $this->get_articles(),
            'providers' => Provider::all(),
            'brands' => Brand::all(),
        ]);
    }

    function get_articles()
    {
        if ($this->brand_id) {
            return Article::orderByDesc('id')->where('brand_id', $this->brand_id)->articleSearch($this->search)->paginate(8);
        }
        if ($this->provider_id) {
            return Article::orderByDesc('id')->where('provider_id', $this->provider_id)->articleSearch($this->search)->paginate(8);
        }
        if ($this->priorite_id != 25) {
            return Article::orderByDesc('id')->where('priority_id', $this->priorite_id)->articleSearch($this->search)->paginate(8);
        }
        return Article::orderByDesc('id')->articleSearch($this->search)->paginate(8);
    }

    // iNVOICE
    public InvoiceSystemForm $systeme_form;
    function store_system(){
        $this->systeme_form->store();
        $this->dispatch('close-addSystem');
    }
    function edit_system($id){
        $this->systeme_form->set($id);
        $this->dispatch('open-editSystem');
    }
    function update_system()
    {
        $this->systeme_form->update();
        $this->dispatch('close-editSystem');
    }

    // Models
    public InvoiceModelForm $model_form;
    function add_model($system_id)
    {
        $this->model_form->invoice_system_id = $system_id;
        $this->dispatch('open-addModel');
    }
    function store_model()
    {
        $this->model_form->store();
        $this->dispatch('close-addModel');
    }
    function edit_model($id)
    {
        $this->model_form->set($id);
        $this->dispatch('open-editModel');
    }
    function update_model()
    {
        $this->model_form->update();
        $this->dispatch('close-editModel');
    }
    function delete_model($id)
    {
        $this->model_form->delete($id);
        $this->dispatch('close-editModel');
    }

    public $selected_model;
    function select_model($id){
        $this->selected_model = InvoiceModel::find($id);
    }

    // Add Article row

    function add_article(){
        $this->dispatch('open-addArticle');
    }

    public $row_tab = 1, $row_class = '';

    // Systemes
    public $selected_system;

    function select_system($system_id){
        $this->selected_system = InvoiceSystem::find($system_id);
    }
}
