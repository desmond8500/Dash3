<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class DemoModel extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:demo-model {model : Nom du modele}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $model = $this->argument('model');

        $this->info("Modèle : {$model}");


        // $this->error('Something went wrong.');
        // return self::SUCCESS;
    }
}
