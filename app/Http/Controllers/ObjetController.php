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
            (object) array( 'name' => "Centrale de controle d\'accès"),
            (object) array( 'name' => 'Lecteur'),
            (object) array( 'name' => 'Ventouse'),
            (object) array( 'name' => 'Gache électrique'),
            (object) array( 'name' => 'Bouton de sortie'),
        );
    }
    static function alarme(){
        return (object) array(
            (object) array( 'name' => "Centrale d\'alarme"),
            (object) array( 'name' => 'Détecteur de mouvement'),
            (object) array( 'name' => 'Contact de porte'),
            (object) array( 'name' => 'Sirène'),
        );
    }
    static function reseaux(){
        return (object) array(
            (object) array( 'name' => 'Identifiant'),
            (object) array( 'name' => 'Mot de passe'),
            (object) array( 'name' => 'Reference'),
            (object) array( 'name' => 'Adresse IP'),
            (object) array( 'name' => 'Passerelle'),
            (object) array( 'name' => 'Masque de sous réseau'),
            (object) array( 'name' => 'Port'),
            (object) array( 'name' => 'Disque dur'),
        );
    }
    static function disks(){
        return (object) array(
            (object) array( 'name' => 'Capacité'),
        );
    }

    static function sublist($name){
        if ($name == 'Enregistreur' || $name == 'Caméra' || $name == 'NVR' || $name == 'DVR') {
            $list = (object) array(
                (object) array( 'name' => 'Caméra', 'description' => 'Caméra de surveillance' ),
            );
        }
        return $list ?? [];
    }


    static function Equipements_list(){
        $list = (object) array(
            (object) array( 'name' => 'Caméra', 'description' => 'Caméra de surveillance' ),
            (object) array( 'name' => 'Enregistreur', 'description' => 'Enregistreur IP' ),
        );
        return $list;
    }

}
