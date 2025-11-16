<?php

namespace App\Livewire;

use App\Http\Controllers\DashController;
use App\Livewire\Forms\UserForm;
use App\Mail\ReportMail;
use App\Models\Article;
use App\Models\Client;
use App\Models\Invoice;
use App\Models\Projet;
use App\Models\Task;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class IndexPage extends Component
{
    public $tags = [
            ['value' => 'active', 'label' => 'Active'],
            ['value' => 'inactive', 'label' => 'Inactive'],
        ];

    public $test = ['active1', 'Active2'];

    function mount(){
        // $this->test = ['value' => 'active', 'label' => 'Active'];
    }
    public function render()
    {

        return view('livewire.index-page',[
            'init' => User::count(),
            'resumes' => $this->getResume(),
            'clients' => Client::favorite(),
            'projets' => Projet::favorite(),
            'invoices' => Invoice::favorite(),
            'carbon' => Carbon::now()->settings([
                'locale' => 'fr_FR',
                'timezone' => 'Africa/Dakar'
            ]),
            'user' => auth()->user(),
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
            (Object) array( 'name'=> 'Articles',   'all'=> Article::count(), 'icon'=> 'packages', 'route'=> route('articles')),
            (Object) array( 'name'=> 'Taches',   'all'=> Task::activeCount(), 'icon'=> 'checklist', 'route'=> route('tasks')),
            (Object) array( 'name'=> 'Devis',   'all'=> Invoice::count(), 'icon'=> 'checklist', 'route'=> route('invoices')),
            (Object) array( 'name'=> 'Rechercher',   'all'=> 0, 'icon'=> 'circle', 'route'=> route('dashboard2')),
            (Object) array( 'name'=> 'Index',   'all'=> 0, 'icon'=> 'circle', 'route'=> route('dashboard1')),
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

    // Login

    // Register
    public UserForm $user_form;
    public $formtype = true;

    public $email;
    public $password;
    public $errorMessage;

    function login()
    {
        $this->validate([
            'email' => 'required|email|exists:App\Models\User,email',
            'password' => 'required'
        ]);

        $login = $this->user_form->login($this->email, $this->password);
        if ($login) {
            $this->reset('email', 'password', 'errorMessage');
            $this->dispatch('close-login');
            return redirect()->intended('/');
        } else {
            $this->errorMessage = 'Les identifiants sont incorrects';
        }
    }

    function register()
    {
        $this->user_form->store();
        $this->dispatch('close-register');
    }

    function logout()
    {
        $this->user_form->logout();
    }
}
