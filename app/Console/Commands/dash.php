<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class dash extends Command
{

    protected $signature = 'dash:fonction {model_name : Nom de la fonction} {--f|form : Formulaire livewire} {--p|page : page livewire} {--a|add : Composant livewire}';

    protected $description = 'Permet de créer un modèle, une migration, un livewireform, une factory';

    public function handle()
    {
        $model_name = ucfirst($this->argument('model_name'));
        $livewire_form = $this->option('form');
        $livewire_page = $this->option('page');
        $livewire_add = $this->option('add');

        $this->info("Creation du modèle");
        $this->call("make:model",[
            'name' => $model_name,
            '--migration' => true,
            '--factory' => true,
        ]);

        $this->info("Creation du formulaire");
        $this->call("livewire:form",[ 'name' => $model_name."Form", ]);

        $this->info("Terminé !!!");
    }
}
