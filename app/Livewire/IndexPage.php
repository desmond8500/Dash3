<?php

namespace App\Livewire;

use App\Http\Controllers\DashController;
use App\Mail\ReportMail;
use App\Models\Article;
use App\Models\Client;
use App\Models\Invoice;
use App\Models\Journal;
use App\Models\Projet;
use App\Models\Task;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class IndexPage extends Component
{
    public function render()
    {
        return view('livewire.index-page',[
            'init' => User::count(),
            'resumes' => $this->getResume(),
            'clients' => Client::favorite(),
            'projets' => Projet::favorite(),
            'invoices' => Invoice::favorite(),
        ]);
    }
    // Init
    function initServer(){
        if (!User::count()) {
            DashController::initUser();
            DashController::initRoles();
        }
    }

    // Resume

    function getResume(){
        return (Object) array(
            (Object) array( 'name'=> 'Clients', 'all'=> Client::count(), 'icon'=> 'users', 'route'=> route('clients')),
            (Object) array( 'name'=> 'Stock',   'all'=> Article::count(), 'icon'=> 'packages', 'route'=> route('stock')),
            (Object) array( 'name'=> 'Taches',   'all'=> Task::activeCount(), 'icon'=> 'checklist', 'route'=> route('tasks')),
        );
    }

    public $provider_id;
    public $name;
    public $description;
    public $date;

    function store(){

    }
    function delete(){

    }

    public $select;

    function send(){
        Mail::to('test@test.com')->send(new ReportMail());
    }

    function init(){
        DashController::init_app();
    }
}
