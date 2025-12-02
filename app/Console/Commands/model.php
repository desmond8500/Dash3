<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use function Laravel\Prompts\multiselect;
use function Laravel\Prompts\text;

class model extends Command
{

    protected $signature = 'app:model {model_name : Nom de la fonction}';

    protected $description = 'Permet de créer un modèle, une migration, un livewireform, une factory';

    public function handle()
    {
        $model_name = ucfirst($this->argument('model_name'));
        $select = multiselect(
            label: "Vous souhaitez créer un modèle $model_name. Quels sont les options que vous voulez ajouter ?",
            options: ['formulaire', 'page', 'pages', 'ajout', 'tout'],
        );

        text('Création du modèle '.$model_name);

        $this->call("make:model",[
            'name' => $model_name,
            '--migration' => true,
            '--factory' => true,
        ]);

        $myfile = fopen("./database/docs/$model_name.md", "w");
        $txt = "# " . $model_name . "\n\n";
        $txt .= "## Description\n\n";
        $txt .= "## Schema\n";
        fwrite($myfile, $txt);
        fclose($myfile);

        foreach ($select as $option) {
            if ($option === 'formulaire' || $option == 0) {
                $this->call("livewire:form", ['name' => $model_name . "Form",]);
                $this->call("make:view", ['name' => "_form/" . strtolower($model_name) . "_form",]);
            }
            if ($option === 'page' || $option == 1) {
                $this->call("make:livewire", ['name' => $model_name . "Page",]);
            }
            if ($option === 'pages' || $option == 2) {
                $this->call("make:livewire", ['name' => $model_name . "sPage",]);
            }
            if ($option === 'ajout' || $option == 3) {
                $this->call("make:livewire", ['name' => $model_name . "Add",]);
            }
            if ($option === 'tout' || $option == 4) {
                $this->option('all', true);
            }
        }

        text('Le modèle a été créé avec succès');

    }

}
