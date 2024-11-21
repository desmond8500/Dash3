<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class dash extends Command
{

    protected $signature = 'dash:fonction {name : Nom de la fonction}';

    protected $description = 'Permet de créer un modèle, une migration, un livewireform, une factory';

    public function handle()
    {
        $name = ucfirst($this->argument('name'));

        $this->info("Creation du modèle");
        $this->call("make:model $name -mf");

        $this->info("Terminé !!!");
    }
}
