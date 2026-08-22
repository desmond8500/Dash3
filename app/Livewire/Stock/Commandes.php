<?php

namespace App\Livewire\Stock;

use App\Models\Article;
use App\Models\Commande;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class Commandes extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        return view('livewire.stock.commandes',[
            'articles' => Article::whereRaw('`quantity` < `quantity_min`')->paginate(8),
            'commandes' => Commande::all(),
            'commands' => $this->getCommandesFusionneesProperty(),
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

    public function getCommandesFusionneesProperty()
    {
        return Commande::query()
            ->select(
                'article_id',
                DB::raw('SUM(quantity) as total_quantity'),
                DB::raw('COUNT(*) as demandes')
            )
            ->with('article')
            ->groupBy('article_id')
            ->orderBy('article_id')
            ->get();
    }
}
