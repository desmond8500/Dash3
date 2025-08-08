<?php

namespace App\Livewire\Dashboard;

use App\Livewire\Forms\WebpageCategoryForm;
use App\Livewire\Forms\WebpageForm;
use App\Models\Webpage;
use App\Models\WebpageCategory;
use Livewire\Attributes\Session;
use Livewire\Component;
use Livewire\WithFileUploads;

class Dashboard1Page extends Component
{
    public WebpageForm $webpage_form;
    public WebpageCategoryForm $webpage_category_form;
    use WithFileUploads;

    public function render()
    {
        return view('livewire.dashboard.dashboard1-page',[
            'websites' => $this->getWebsites(),
            'categories' => WebpageCategory::all(),
        ]);
    }

    #[Session]
    public $selected = 1;
    public $edit= 0;

    function getWebsites(){
        return Webpage::where('webpage_category_id', $this->selected)->get();
    }

    function selectCategory($id){
        $this->selected = $id;
    }

    // Webpage

    function store(){
        $this->webpage_form->store();
        $this->dispatch('close-addWebpage');
    }
    function delete($id){
        $this->webpage_form->delete($id);
    }

    // WebpageCategory

    function store_category(){
        $this->webpage_category_form->store();
        $this->dispatch('close-addWebpageCategory');
    }

    function edit_category($id){
        $this->webpage_category_form->set($id);
        $this->dispatch('open-editWebpageCategory');
    }

    function update_category(){
        $this->webpage_category_form->update();
        $this->dispatch('close-editWebpageCategory');
    }
    function delete_category($id){
        $this->webpage_category_form->delete($id);
        $this->dispatch('close-editWebpageCategory');
    }
}
