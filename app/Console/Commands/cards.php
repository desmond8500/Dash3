<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class cards extends Command
{

    protected $signature = 'app:cards
        {card_name : Nom de la carte}
    ';

    protected $description = 'Permet de créer une carte';

    public function handle()
    {
        $card_name = $this->argument('card_name');

        $this->info("Creation de la carte");

        $myfile = fopen("./resources/views/_card/".$card_name."_card.blade.php", "w");

    }
}
