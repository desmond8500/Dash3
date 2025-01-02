<div class="card">
    <div class="card-body">
        <h3 class="card-title">{{ $title ?? 'List des taches' }}</h3>

        <div class="divide-y-2 ">
            @foreach ($tasks as $task)
                @include('_card.task1_card',['task' => $task])
            @endforeach

            <div class="d-flex align-items-center">
                <i class="ti ti-plus"></i>
                <input type="text" class="form-control form-control-flush" wire:model="form.name" placeholder="Ajouter une tâche" wire:keydown.enter="store">
            </div>
        </div>
    </div>
</div>
