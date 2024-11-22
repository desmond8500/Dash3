<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class docs extends Command
{
    protected $signature = 'app:docs
        {name : Nom de la fonction}
    ';

    protected $description = 'Documentation de l\'application';

    public function handle()
    {
        $name = ucfirst($this->argument('name'));
        // $livewire_form = $this->option('form');

        $this->info('Bonjour');

        $myfile = fopen("./database/docs/$name.md", "w");
        $txt = "# ".$name. "\n\n";
        $txt .= "## Description\n\n";
        $txt .= "## Schema\n";
        fwrite($myfile, $txt);
        fclose($myfile);

        // $this->call('');

        $this->info('Terminé');
    }
}
