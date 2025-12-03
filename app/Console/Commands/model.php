<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use function Laravel\Prompts\confirm;
use function Laravel\Prompts\multiselect;
use function Laravel\Prompts\text;

class model extends Command
{

    protected $signature = 'app:model {model_name : Nom de la fonction}';

    protected $description = 'Permet de créer un modèle, une migration, un livewireform, une factory';

    public function handle()
    {
        $model_name = ucfirst($this->argument('model_name'));

        $select = confirm(
            label: "Vous souhaitez créer le modèle $model_name. Voulez vous ajouter les arguments ?",
            default: false,
            yes: true,
            no: false,
        );

        $i = 1;
        $args = '    protected $fillable = ['."\n";
        do {
            $name = text("Veuillez entrer le nom de l'argument $i (laisser vide pour terminer) : ");
            if ($name) {
                $args .= "        '$name',\n";
                $i++;
            }
        } while ($name);

        $args .= '    ];'."\n";

        $fonctions = multiselect(
            label: "Quels sont les options que vous voulez ajouter ?",
            options: ['formulaire', 'page', 'pages', 'ajout', 'tout'],
        );

        $this->info('Création du modèle '.$model_name);

        $this->call("make:model",[
            'name' => $model_name,
            '--migration' => true,
            '--factory' => true,
        ]);

        $this->info('Ajout des arguments du modèle ' . $model_name);
        $file = app_path("/Models/$model_name.php");
        $content = file_get_contents($file);

        $content = preg_replace('/}\s*$/', $args . "\n}", $content);

        file_put_contents($file, $content);

        // Create doc file
        $myfile = fopen("./database/docs/$model_name.md", "w");
        $txt = "# " . $model_name . "\n\n";
        $txt .= "## Description\n\n\n";
        $txt .= "## Diagramme\n\n";
        $txt .= "```mermaid\n";
        $txt .= "classDiagram\n\n";
        $txt .= "class " . ucfirst($model_name) . "{\n";
        $txt .= "    +string att1\n";
        $txt .= "}\n";
        $txt .= "```\n";
        fwrite($myfile, $txt);
        fclose($myfile);

        foreach ($fonctions as $option) {
            if ($option === 'formulaire' || $option == 1) {
                $this->call("livewire:form", ['name' => $model_name . "Form",]);
                $this->call("make:view", ['name' => "_form/" . strtolower($model_name) . "_form",]);
            }
            if ($option === 'page' || $option == 2) {
                $this->call("make:livewire", ['name' => $model_name . "Page",]);
            }
            if ($option === 'pages' || $option == 3) {
                $this->call("make:livewire", ['name' => $model_name . "sPage",]);
            }
            if ($option === 'ajout' || $option == 4) {
                $this->call("make:livewire", ['name' => $model_name . "Add",]);
            }
            if ($option === 'tout' || $option == 5) {
                $this->option('all', true);
            }
        }

        // text('Le modèle a été créé avec succès');
        $this->info("Terminé !!!");

    }

}
