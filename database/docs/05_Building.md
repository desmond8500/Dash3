# Gestion de batiment

## Description

Ce module permet de documenter un projet.  

Chaque projet peut être composé de plusieurs **batiments**, chaque batiment est composé de **niveaux**, chaque niveau de **locaux**.  

Pour chacun des locaux des équipements seront affactés à partir des équipemetns cité dans le devis. IL faudra prendre en compte des équipemens annexes à ajouter à l'installation.  

Cette structure permettra de faire le suivi des travaux.  

| Tache | Etat | Commmentaire |
| :-- | :-- | :-- |
| Saignée | 000% |
| Pose de fourreau | 000% | |
| Enduit | 000% | |
| Tirage | 000% | |
| Pose | 000% | |
| Connexion | 000% | |
| Test | 000% | |
| Mise en service | 000% | |

```mermaid
classDiagram

Projet <-- Building
 Building <--  Building_System
 Building <--  Stage
 Stage <--  Room
 Room <--  Building_item
 Article <--  Building_item
 Building_System <--  Building_item

class Building {
    int projet_id
    string name
    string order
    text description

    generer_quantitatif()
}

class Building_System {
    int building_id
    string name
    string order
    text description
}

class Building_item {
    int room_id
    int article_id
    int system_id
    string name
    text description

    string tirage
    string pose
    string connexion
    string test
    string ok
}

class Stage {
    int building_id
    string name
    string order
    text description
}

class Room {
    int stage_id
    string name
    string order
    text description
}

class Quantitatif {
    int building_id
    string name
    text description
}

class QuantitatifRow {
    int quanitatif_id
    int article_id
    string name
    text description
}


```
