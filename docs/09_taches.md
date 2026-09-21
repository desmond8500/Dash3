# Taches

## Description

Gestion et suivi des taches en cours

## Correspondances

| Id | Correspondance |
| :-- | :-- |
| 1 | Nouveau |
| 2 | En Cours |
| 3 | En pause |
| 4 | Terminé |
| 5 | Cloturé |

## Modèle

```mermaid
classDiagram

Task <-- Status
Task <-- Priority
Task <-- TaskPhoto
Task <-- TaskDocument

class Task{
    int client_id
    int projet_id
    int devis_id
    int building_id
    int stage_id
    int room_id
    string name
    text description
    text expiration_date
    int status_id
    int priority_id
    devis()
    photo()
    document()
}

class TaskPhoto{
    int task_id
    string name
    string folder
    task()
}

class TaskDocument{
    int task_id
    string name
    string folder
    task()
}

class TaskStatus{
    int level
    string name
}

class TaskPriority{
    int level
    string name
}

```

## Sources
<!-- 
* []()
*  -->
