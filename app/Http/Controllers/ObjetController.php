<?php

namespace App\Http\Controllers;

use FontLib\Table\Type\name;
use Illuminate\Http\Request;

class ObjetController extends Controller
{
    static function video(){
        return (object) array(
            (object) array( 'name' => 'enregistreur'),
            (object) array( 'name' => 'camera'),
            (object) array( 'name' => 'disque dur'),
            (object) array( 'name' => 'camera'),
            (object) array( 'name' => 'camera'),
        );
    }
    static function incendie(){
        return (object) array(
            (object) array( 'name' => 'centrale incendie'),
            (object) array( 'name' => 'detecteur de fumée'),
            (object) array( 'name' => 'detecteur de chaleur'),
            (object) array( 'name' => 'déclendeur manuel'),
            (object) array( 'name' => 'Sirène'),
            (object) array( 'name' => 'Module'),

        );
    }
    static function access(){
        return (object) array(
            (object) array( 'name' => "centrale de controle d\'accès"),
            (object) array( 'name' => 'lecteur'),
            (object) array( 'name' => 'Ventouse'),
            (object) array( 'name' => 'gache electrique'),
            (object) array( 'name' => 'gache electrique'),
        );
    }
    static function alarme(){
        return (object) array(
            (object) array( 'name' => "centrale d\'alarme"),
            (object) array( 'name' => 'détecteur de mouvement'),
            (object) array( 'name' => 'contact de porte'),
            (object) array( 'name' => 'sirene'),
        );
    }
    static function reseaux(){
        return (object) array(
            (object) array( 'name' => 'identifiant'),
            (object) array( 'name' => 'Mot de passe'),
            (object) array( 'name' => 'reference'),
            (object) array( 'name' => 'adresse IP'),
            (object) array( 'name' => 'passerelle'),
            (object) array( 'name' => 'masque de sous réseau'),
            (object) array( 'name' => 'Port'),
        );
    }
    static function disks(){
        return (object) array(
            (object) array( 'name' => 'Capacité'),
        );
    }

    static function sublist($name){
        if ($name == 'enregistreur' || $name == 'camera' || $name == 'nvr' || $name == 'dvr') {
            $list = (object) array(
                (object) array( 'name' => 'camera', 'description' => 'Camera de surveillance' ),
            );
        }
        return $list ?? [];
    }


    static function Equipements_list(){
        $list = (object) array(
            (object) array( 'name' => 'camera', 'description' => 'Camera de surveillance' ),
            (object) array( 'name' => 'enregistreur', 'description' => 'Enregistreur IP' ),
        );
        return $list;
    }

}
