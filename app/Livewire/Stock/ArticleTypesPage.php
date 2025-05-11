<?php

namespace App\Livewire\Stock;

use Livewire\Attributes\Session;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Spatie\Tags\Tag;

class ArticleTypesPage extends Component
{
    use WithPagination;
    use WithFileUploads;

    public $search = '';
    public $breadcrumbs;

    public function mount()
    {
        $this->breadcrumbs = array(
            array('name' => 'Stock', 'route' => route('stock')),
            array('name' => 'Types d\'articles', 'route' => route('article_types')),
        );
    }

    public function render()
    {
        return view('livewire.stock.article-types-page',[
            'types' => Tag::getTypes(),
            'tags' => Tag::getWithType($this->name ?? ''),
        ]);
    }

    #[Session]
    public $name;


    function add_type(){

    }

    function select_type($type){
        $this->name = $type;
    }

    function edit_type($type){
        $this->name = $type;
        $this->dispatch('open-editType');
    }

    function update_type(){

    }

    public $selected_tag;
    public $tag_name;
    public $tag_type;

    function edit_tag($tag){
        $this->selected_tag = Tag::find($tag);
        $this->tag_name = $this->selected_tag->name;
        $this->tag_type = $this->selected_tag->type;
        $this->dispatch('open-editTag');
    }

    function update_tag(){
        $this->selected_tag->name = $this->tag_name;
        $this->selected_tag->type = $this->tag_type;
        $this->selected_tag->save();
        $this->dispatch('close-editTag');
    }

    function delete_tag($tag){
        $tag = Tag::find($tag);
        $tag->delete();
    }
}
