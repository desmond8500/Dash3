<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;

class ErpController extends Controller
{
    static function getInvoiceReference($projet){
        $count = Invoice::count();
        if ($count) {
            return substr(strtoupper($projet->client->name), 0, 3) . "-" . sprintf("%03d", Invoice::latest()->first()->id + 1) . '-' . date('y');
        } else {
            return substr(strtoupper($projet->client->name), 0, 3) . "-" . sprintf("%03d", 1) . '-' . date('y');
        }
    }

    static function getRandomStatus(){
        $statuts = array(
            'Proforma',
            'Nouveau',
            'En Cours',
            'En Cours',
            'En Pause',
            'Annulé',
            'Terminé',
        );

        $rand = random_int(0,6);

        return $statuts[$rand];
    }

    static function getPriority(){
        return array(
            "1" => "Centrale",
            "2" => "Organe 1",
            "3" => "Organe 2",
            "4" => "Organe 3",
            "5" => "Organe 4",
            "6" => "Cable",
            "7" => "Accessoires",
            "8" => "Forfait",
        );
    }

    static function get_equipements($systeme){
        $ssi = array(
            'Détecteur de fumée',
            'Détecteur thermique',
            'Détecteur thermovélocimétrique',
            'Détecteur optico-thermique',
            'Déclencheur manuel',
        );

        $alarme = array(
            'Contact de porte',
            'Détecteur de mouvement',
            'Pédales',
            'Bouton panique',
            'Détecteur sismique',
        );


        if ($systeme =='incendie') {
            return $ssi;
        }elseif($systeme == 'alarme'){
            return $alarme;
        }
    }

    static function get_systems(){
        return array('alarme', 'ssi');
    }

    static function get_locaux(){
        return array(
            'Enteée client',
            'Entrée personnel',
            'GAB',
            'Archives',
            'Cuisine',
            'Hall',
            'Hall Client',
            'Hall Etage',
            'Coffre',
            'Caisse',
            'Arrère Caisse',
            'Directeur Agence',
            'Local technique',
        );
    }
}
