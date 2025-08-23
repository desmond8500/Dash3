<div class="">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            @if ($task->statut_id < 4)
                <a wire:click="check_task('{{ $task->id }}')">
                    <i class="ti ti-square"></i>
                </a>
                <span>
            @elseif($task->statut_id > 3)
                <a wire:click="uncheck_task('{{ $task->id }}')">
                    <i class="ti ti-checkbox"></i>
                </a>
                <span class="text-decoration-line-through">
            @endif

            {{ $task->name }}
                </span>
        </div>
        <div>
            <i class="btn btn-action ti ti-x" wire:click="delete('{{ $task->id }}')"></i>
            <i class="btn btn-action ti ti-edit" wire:click="edit('{{ $task->id }}')"></i>
        </div>
    </div>
</div>
