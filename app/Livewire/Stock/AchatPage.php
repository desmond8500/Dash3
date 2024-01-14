<?php

namespace App\Livewire\Stock;

use App\Models\Achat;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class AchatPage extends Component
{
    use WithPagination;
    use WithFileUploads;

    protected $paginationTheme = 'bootstrap';
    public $search ='';
    public $breadcrumbs;
    public $achat_id;
    public $achat;

    public function mount($achat_id){
        $this->achat = Achat::find($achat_id);
        $this->breadcrumbs = array(
            array('name' => 'Stock', 'route' => route('stock')),
            array('name' => 'Achats', 'route' => route('achats')),
            array('name' => 'Achat', 'route' => route('achat',['achat_id'=>$achat_id])),
        );
    }

    function AchatSearch() {
        return Achat::where('name', 'like', '%' . $this->search . '%')->paginate(10);
    }

    public function render(){
        return view('livewire.stock.achat-page',[
            'achat' => $this->achat,
            'articles' => []
        ]);
    }

}


