<div>
    <div class="card p-2">
        <div class="row">
            <div class="col-auto">
                <img src="" alt="A" class="avatar avatar-md">
            </div>
            <a href="{{ route('task', ['task_id'=> $task->id]) }}" class="col">
                <div class="text-primary">
                    @if ($task->client_id) <span>{{ $task->client->name }}</span> @endif
                    @if ($task->projet_id) <span>{{ $task->projet->name }}</span> @endif
                    @if ($task->building_id) <span>{{ $task->building->name }}</span> @endif
                    @if ($task->stage_id) <span>{{ $task->stage->name }}</span> @endif
                    @if ($task->room_id) <span>{{ $task->room->name }}</span> @endif
                </div>
                <div class="fw-bold">{{ $task->name }}</div>
                <div class="text-muted">{{ nl2br($task->description) }}</div>
            </a>
            <div class="col-auto">
                <button class="btn btn-outline-primary btn-icon" wire:click="edit('{{ $task->id }}')">
                    <i class="ti ti-edit"></i>
                </button>
            </div>
        </div>
    </div>

</div>
