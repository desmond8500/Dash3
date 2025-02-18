<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class form extends Command
{

    protected $signature = 'app:forms
        {form_name : Nom du formulaire}
    ';

    protected $description = 'Permet de créer un formulaire';

    public function handle()
    {
        $form_name = $this->argument('form_name');

        $this->info("Creation du formulaire ".$form_name." dans le dossier _form");

        fopen("./resources/views/_form/".$form_name."_form.blade.php", "w");

        $this->info("Le formulaire ".$form_name." a été créée avec succès");
    }
}
