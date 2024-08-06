@isset($task)
<div class="status status-blue " style="font-size: 12px;">

    @if ($task->client_id)
    <a data-bs-toggle="tooltip" data-bs-placement="top" href="{{ route('projets',['client_id'=>$task->client->id]) }}"
        title="Client">
        <div style="font-size: 9px" class="text-dark">Client</div>
        {{ $task->client->name }}
    </a>
    @endif

    @if ($task->projet_id)
    <a data-bs-toggle="tooltip" data-bs-placement="top"
        href="{{ route('projets',['client_id'=>$task->projet->client->id]) }}" title="Client">
        <div style="font-size: 9px" class="text-dark">Client</div>
        {{$task->projet->client->name }}
    </a> /
    <a data-bs-toggle="tooltip" data-bs-placement="top" href="{{ route('projet',['projet_id'=>$task->projet->id]) }}"
        title="Projet">
        <div style="font-size: 9px" class="text-dark">Projet</div>
        {{ $task->projet->name }}
    </a>
    @endif

    @if ($task->building_id)
    <a data-bs-toggle="tooltip" data-bs-placement="top"
        href="{{ route('projets',['client_id'=>$task->building->projet->client->id]) }}" title="Client">
        <div style="font-size: 9px" class="text-dark">Client</div>
        {{ $task->building->projet->client->name }}
    </a> /
    <a data-bs-toggle="tooltip" data-bs-placement="top"
        href="{{ route('projet',['projet_id'=>$task->building->projet->id]) }}" title="Projet">
        <div style="font-size: 9px" class="text-dark">Projet</div>
        {{ $task->building->projet->name }}
    </a> /
    <a data-bs-toggle="tooltip" data-bs-placement="top"
        href="{{ route('building', ['building_id'=>$task->building->id]) }}" title="Batiment">
        <div style="font-size: 9px" class="text-dark">Batiment</div>
        {{ $task->building->name}}
    </a>
    @endif

    @if ($task->devis_id)
    <a data-bs-toggle="tooltip" data-bs-placement="top"
        href="{{ route('projets',['client_id'=>$task->devis->projet->client->id]) }}" title="Client">
        <div style="font-size: 9px" class="text-dark">Client</div>
        {{ $task->devis->projet->client->name }}
    </a> /
    <a data-bs-toggle="tooltip" data-bs-placement="top"
        href="{{ route('projet',['projet_id'=>$task->devis->projet->id]) }}" title="Projet">
        <div style="font-size: 9px" class="text-dark">Projet</div>
        {{ $task->devis->projet->name }}
    </a> /
    <a data-bs-toggle="tooltip" data-bs-placement="top" href="{{ route('invoice', ['invoice_id'=>$task->devis->id]) }}"
        title="Devis">
        <div style="font-size: 9px" class="text-dark">Devis</div>
        {{ $task->devis->reference }}
    </a>
    @endif

    @if ($task->stage_id)
    <a data-bs-toggle="tooltip" data-bs-placement="top"
        href="{{ route('projets',['client_id'=>$task->stage->building->projet->client->id]) }}" title="Client">
        <div style="font-size: 9px" class="text-dark">Client</div>
        {{ $task->stage->building->projet->client->name }}
    </a> /
    <a data-bs-toggle="tooltip" data-bs-placement="top"
        href="{{ route('projet',['projet_id'=>$task->stage->building->projet->id]) }}" title="Projet">
        <div style="font-size: 9px" class="text-dark">Projet</div>
        {{ $task->stage->building->projet->name }}
    </a> /
    <a data-bs-toggle="tooltip" data-bs-placement="top"
        href="{{ route('building', ['building_id'=>$task->stage->building->id]) }}" title="Batiment">
        <div style="font-size: 9px" class="text-dark">Devis</div>
        {{ $task->stage->building->name }}
    </a> /
    <a data-bs-toggle="tooltip" data-bs-placement="top" href="{{ route('stage', ['stage_id'=>$task->stage->id]) }}"
        title="Niveau">
        <div style="font-size: 9px" class="text-dark">Niveau</div>
        {{ $task->stage->name }}
    </a>
    @endif

    @if ($task->room_id)
    <a data-bs-toggle="tooltip" data-bs-placement="top"
        href="{{ route('projets',['client_id'=>$task->room->stage->building->projet->client->id]) }}" title="Client">
        <div style="font-size: 9px" class="text-dark">Client</div>
        {{ $task->room->stage->building->projet->client->name }}
    </a> /
    <a data-bs-toggle="tooltip" data-bs-placement="top"
        href="{{ route('projet',['projet_id'=>$task->room->stage->building->projet->id]) }}" title="Projet">
        <div style="font-size: 9px" class="text-dark">Projet</div>
        {{ $task->room->stage->building->projet->name }}
    </a> /
    <a data-bs-toggle="tooltip" data-bs-placement="top"
        href="{{ route('building', ['building_id'=>$task->room->stage->building->id]) }}" title="Batiment">
        <div style="font-size: 9px" class="text-dark">Batiment</div>
        {{ $task->room->stage->building->name }}
    </a> /
    <a data-bs-toggle="tooltip" data-bs-placement="top"
        href="{{ route('stage', ['stage_id'=>$task->room->stage->id]) }}" title="Niveau">
        <div style="font-size: 9px" class="text-dark">Niveau</div>
        {{ $task->room->stage->name }}
    </a> /
    <a data-bs-toggle="tooltip" data-bs-placement="top" href="{{ route('room', ['room_id'=>$task->room->id]) }}"
        title="Local">
        <div style="font-size: 9px" class="text-dark">Local</div>
        {{ $task->room->name }}/
    </a>
    @endif
</div>
@endisset
