<?php

namespace App\Livewire\Stock;

use App\Models\Commande;
use Livewire\Component;

class Commandes extends Component
{
    public function render()
    {
        return view('livewire.stock.commandes',[
            'commandes' => Commande::all()
        ]);
    }

    public $selected;
    function select($selected_id){
        $this->selected = Commande::find($selected_id);

    }

    function increment($id){
        $commande = Commande::find($id);
        $commande->quantity++ ;
        $commande->save() ;

    }

    function decrement($id){
        $commande = Commande::find($id);
        if ($commande->quantity>0) {
            $commande->quantity-- ;
            $commande->save() ;
        }
    }


}
