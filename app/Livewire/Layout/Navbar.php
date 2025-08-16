<?php

namespace App\Livewire\Layout;

use App\Livewire\Forms\UserForm;
use Livewire\Component;
use Livewire\WithFileUploads;

class Navbar extends Component
{
    use WithFileUploads;

    public $menu1 = array(
        array('name' => "ERP", "icon" => "users", "can"=>"erp",
            'submenu' => [
                array('name' => "Clients", "route" => "clients", "icon" => "users", "can" => "clients"),
                array('name' => "Modèle de devis", "route" => "invoice_model", "icon" => "file"),
                array('name' => "Documents", "route" => "documents", "icon" => "file"),
                array('name' => "Devis", "route" => "invoicelist", "icon" => "file"),
                array('name' => "Système", "route" => "systemes", "icon" => "settings"),
                array('name' => "Journaux", "route" => "journaux", "icon" =>"article", "can" => "journaux"),
                array('name' => "Finances", "route" => "finances", "icon" => "coins", "can" => "finances"),
                array('name' => "Equipe", "route" => "team", "icon" => "users", "can" => ""),
                array('name' => "Forfaits", "route" => "forfaits", "icon" => "receipt", "can" => ""),
                array('name' => "Plannings", "route" => "plannings", "icon" => "receipt", "can" => ""),
                // array('name' => "Timeline", "route" => "timeline", "icon" => "list", "can" => ""),
            ]
        ),
        array('name' => "Stock", "icon" => "packages", "can"=> "stock",
            'submenu' => [
                array('name' => "Stock", "route" => "stock", "icon" => "packages", "can" => "stock"),
                array('name' => "Articles", "route" => "articles", "icon" => "packages", "can" => "stock"),
                array('name' => "Achats", "route" => "achats", "icon" => "brand-cake", "can" => "stock"),
                array('name' => "Marques", "route" => "brands", "icon" => "brand-cake", "can" => "stock"),
                array('name' => "Fournisseurs", "route" => "providers", "icon" => "building", "can" => "stock"),
                array('name' => "Types", "route" => "article_types", "icon" => "building", "can" => "stock"),
            ]
        ),
        array('name' => "Test", "route" => "test", "icon" => "hammer", "can"=> "test"),
        array('name' => "Medias", "icon" => "photo", "can"=> "medias",
            'submenu' => [
                array('name' => "Images", "route" => "images", "icon" => "photo"),
                array('name' => "Vidéos", "route" => "videos", "icon" => "video"),
            ]
        ),
        array('name' => "Tableaux", "icon" => "dashboard", "can"=> "erp",
            'submenu' => [
            array('name' => "Tableau de bord 1", "route" => "dashboard1", "icon" => "dashboard"),
            array('name' => "Tableau de bord 2", "route" => "dashboard2", "icon" => "dashboard"),
            ]
        ),
        array('name' => "Perso", "icon" => "dashboard", "can"=> "erp",
            'submenu' => [
            array('name' => "Mes Projets", "route" => "myprojects", "icon" => "circle"),
            ]
        ),
    );

    public function render()
    {
        return view('livewire.layout.navbar', [
            "menus" => $this->menu1,
            'user' => auth()->user(),
        ]);
    }

    // Register
    public UserForm $user_form;
    public $formtype = true;

    function register(){

        $this->user_form->store();
        $this->user_form->reset();
        $this->dispatch('close-register');
    }

    public $email;
    public $password;
    public $errorMessage;

    function login(){
        $this->validate([
            'email' => 'required|email|exists:App\Models\User,email',
            'password' => 'required'
        ]);

        $login = $this->user_form->login($this->email, $this->password);
        if ($login) {
            $this->reset('email','password', 'errorMessage');
            $this->dispatch('close-login');
            return redirect()->intended('/');
        } else {
           $this->errorMessage ='Les identifiants sont incorrects';
        }

    }

    function logout(){
        $this->user_form->logout();
    }
}
