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

        $i = 1;
        $fillable = '    protected $fillable = ['."\n";
        $args = [];
        $args_type = [];
        $relations = [];
        do {
            $name = text("Veuillez entrer le nom de l'argument $i (laisser vide pour terminer) : ");
            if ($name) {
                $fillable .= "        '$name',\n";
                $args[] = $name;

                $type = text("Veuillez entrer le type de l'argument $i (int, string, date, boolean, text, select, img) : ");
                if ($type) {
                    $args_type[] = $type;
                }
            }
            $i++;
        } while ($name);

        $fillable .= '    ];'."\n";

        if ($this->confirm('Voulez vous ajouter des relations ?', true)) {
            $this->info('Ajout des relations au modèle ' . $model_name);

            do {
                $relation_type = text("Veuillez entrer le type de relation (hasOne, hasMany, belongsTo, belongsToMany) : ");
                $relation_model = text("Veuillez entrer le nom du modèle lié : ");
                if ($relation_type && $relation_model) {
                    $relations[] = [
                        'type' => $relation_type,
                        'model' => ucfirst($relation_model),
                    ];
                }
            } while ($this->confirm('Voulez vous ajouter une autre relation ?', true));
        }

        $fonctions = multiselect(
            label: "Quels sont les options que vous voulez ajouter ?",
            options: ['formulaire', 'page', 'pages', 'ajout','documentation', 'tout'],
        );

        // Création du modèle avec migration, factory et resource
        $this->info('Création du modèle '.$model_name);

        $this->call("make:model",[
            'name' => $model_name,
            '--migration' => true,
            '--factory' => true,
            '--resource' => true,
        ]);

        $this->info('Ajout des arguments au modèle ' . $model_name);
        $file = app_path("/Models/$model_name.php");
        $content = file_get_contents($file);

        $content = preg_replace('/}\s*$/', $fillable . "\n}", $content);

        file_put_contents($file, $content);


        foreach ($fonctions as $option) {
            $all = in_array($option, ['tout', '6', 6], true);
            if ($option === 'formulaire' || $option == 1 || $all) {
                $this->info('Ajout du modal du formulaire ' . $model_name);
                $this->call("livewire:form", ['name' => $model_name . "Form",]);
                $file = app_path("/Livewire/Forms/$model_name" . "Form.php");

                $this->info('Ajout du formulaire ' . $model_name);
                $this->call("make:view", ['name' => "_form/" . strtolower($model_name) . "_form",]);
                $file = app_path("/resources/views/_forms/$model_name" . "_form.blade.php");
            }
            if ($option === 'page' || $option == 2 || $all) {
                $this->info('Ajout de la page de détail du modèle ' . $model_name);
                $this->call("make:livewire", ['name' => $model_name . "Page",]);
                $file = app_path("/Livewire/$model_name" . "Page.php");
            }
            if ($option === 'pages' || $option == 3 || $all) {
                $this->info('Ajout de la page générale du modèle ' . $model_name);
                $this->call("make:livewire", ['name' => $model_name . "sPage",]);
                $file = app_path("/Livewire/$model_name" . "sPage.php");
            }
            if ($option === 'ajout' || $option == 4 || $all) {
                $this->info('Ajout du modal d\'ajout ' . $model_name);
                $this->call("make:livewire", ['name' => $model_name . "Add",]);
                $file = app_path("/Livewire/$model_name" . "Add.php");
            }
            if ($option === 'documentation' || $option == 5 || $all) {
                $this->info('Ajout de la documentation pour le modèle ' . $model_name);
                $myfile = fopen("./database/docs/$model_name.md", "w");
                $txt = "# " . $model_name . "\n\n";
                $txt .= "## Description\n\n\n";
                $txt .= "## Diagramme\n\n";
                $txt .= "```mermaid\n";
                $txt .= "classDiagram\n\n";
                $txt .= "class " . ucfirst($model_name) . "{\n";
                foreach ($args as $key => $arg) {
                    $txt .= "    +$args_type[$key] $arg\n";
                }
                $txt .= "}\n";
                $txt .= "```\n";
                fwrite($myfile, $txt);
                fclose($myfile);
            }
        }

        // text('Le modèle a été créé avec succès');
        $this->info("Terminé !!!");

    }

}
