<?php

namespace App\Livewire\Erp;

use App\Models\Client;
use Livewire\Component;
use Livewire\WithPagination;

class Clients extends Component
{
    use WithPagination;

    public $search;
    public $name, $description, $address, $avatar, $status, $type;

    public $breadcrumbs = [
        ["name"=> "Clients", "route"=> "clients"],
    ];
    public function render()
    {
        return view('livewire.erp.clients',[
            "breadcrumbs" => $this->breadcrumbs,
            'clients' => Client::where('name', 'like', '%' . $this->search . '%')->paginate(10)
        ]);
    }

    function clientSearch() : void {
        $this->resetPage();
    }

    function store() : void {
        $this->dispatch('close-modal');

    }
    function edit() : void {

    }
    function update() : void {

    }
    function delete() : void {

    }
}
