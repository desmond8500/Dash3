<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use function Laravel\Prompts\multiselect;
use function Laravel\Prompts\text;

class model extends Command
{

    protected $signature = 'app:model
        {model_name : Nom de la fonction}
        {--f|form : Formulaire livewire}
        {--p|page : page livewire}
        {--ps|pages : pages livewire}
        {--a|add : Composant livewire}
        {--all : Toutes les options}
        ';

    protected $description = 'Permet de créer un modèle, une migration, un livewireform, une factory';

    public function handle()
    {
        $model_name = ucfirst($this->argument('model_name'));
        $name = multiselect(
            label: "Vous souhaitez créer un modèle $model_name. Quels sont les options que vous voulez ajouter ?",
            options: ['formulaire', 'page', 'pages', 'ajout', 'tout'],


        );





        // $livewire_form = $this->option('form');
        // $livewire_page = $this->option('page');
        // $livewire_pages = $this->option('pages');
        // $livewire_add = $this->option('add');
        // $livewire_all = $this->option('all');

        // $this->info("Creation du modèle");
        // $this->call("make:model",[
        //     'name' => $model_name,
        //     '--migration' => true,
        //     '--factory' => true,
        // ]);

        // $this->info("Creation du formulaire");
        // $this->call("livewire:form", ['name' => $model_name . "Form",]);

        // $myfile = fopen("./database/docs/$model_name.md", "w");
        // $txt = "# " . $model_name . "\n\n";
        // $txt .= "## Description\n\n";
        // $txt .= "## Schema\n";
        // fwrite($myfile, $txt);
        // fclose($myfile);


        // if ($livewire_page || $livewire_all) {
        //     $this->info("Creation de la page");
        //     $this->call("make:livewire",[ 'name' => $model_name."Page", ]);
        // }
        // if ($livewire_pages || $livewire_all) {
        //     $this->info("Creation de la page(s)");
        //     $this->call("make:livewire",[ 'name' => $model_name."sPage", ]);
        // }
        // if ($livewire_add || $livewire_all) {
        //     $this->info("Creation du formulaire d'ajout");
        //     $this->call("make:livewire",[ 'name' => $model_name."Add", ]);
        //     $this->call("make:view",[ 'name' => "_form/".strtolower($model_name)."_form", ]);
        // }


        // $this->info("Terminé !!!");
    }
    // public function handle()
    // {
    //     $model_name = ucfirst($this->argument('model_name'));
    //     $livewire_form = $this->option('form');
    //     $livewire_page = $this->option('page');
    //     $livewire_pages = $this->option('pages');
    //     $livewire_add = $this->option('add');
    //     $livewire_all = $this->option('all');

    //     $this->info("Creation du modèle");
    //     $this->call("make:model",[
    //         'name' => $model_name,
    //         '--migration' => true,
    //         '--factory' => true,
    //     ]);

    //     $this->info("Creation du formulaire");
    //     $this->call("livewire:form", ['name' => $model_name . "Form",]);

    //     $myfile = fopen("./database/docs/$model_name.md", "w");
    //     $txt = "# " . $model_name . "\n\n";
    //     $txt .= "## Description\n\n";
    //     $txt .= "## Schema\n";
    //     fwrite($myfile, $txt);
    //     fclose($myfile);


    //     if ($livewire_page || $livewire_all) {
    //         $this->info("Creation de la page");
    //         $this->call("make:livewire",[ 'name' => $model_name."Page", ]);
    //     }
    //     if ($livewire_pages || $livewire_all) {
    //         $this->info("Creation de la page(s)");
    //         $this->call("make:livewire",[ 'name' => $model_name."sPage", ]);
    //     }
    //     if ($livewire_add || $livewire_all) {
    //         $this->info("Creation du formulaire d'ajout");
    //         $this->call("make:livewire",[ 'name' => $model_name."Add", ]);
    //         $this->call("make:view",[ 'name' => "_form/".strtolower($model_name)."_form", ]);
    //     }


    //     $this->info("Terminé !!!");
    // }
}
