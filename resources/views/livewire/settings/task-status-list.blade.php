<div class="card-body">
    <div class="row row-deck">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Status</div>
                    <div class="card-actions">
                        <div class="badge bg-primary">{{ $taskStatuses->count() }}</div>
                        <button class="btn btn-action" wire:click="status_add">
                            <i class="ti ti-plus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    @foreach ($taskStatuses as $taskStatus)
                    <div class="card p-2 my-1">
                        <div class="row">
                            <div class="col">{{ $taskStatus->name }}</div>
                            <div class="col-auto">
                                <div class="badge bg-{{ $taskStatus->color }}"> {{ $taskStatus->level }} </div>
                            </div>
                            <div class="col-auto">
                                <button class="btn btn-sm" wire:click="status_edit('{{ $taskStatus->id }}')"> <i
                                        class="ti ti-edit"></i> </button>
                            </div>
                        </div>

                        {{-- <div class="d-flex justify-content-between">
                            <div>{{ $taskStatus->name }}</div>
                            <button class="btn btn-action"> <i class="ti ti-edit"></i> </button>
                            <button class="btn btn-action"> <i class="ti ti-edit"></i> </button>
                            <div class="badge bg-{{ $taskStatus->color }}"
                                wire:click="status_edit('{{ $taskStatus->id }}')">{{ $taskStatus->level }}</div>
                        </div> --}}
                    </div>
                    @endforeach
                </div>
                {{-- <div class="card-footer">

                </div> --}}
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Priorite</div>
                    <div class="card-actions">
                        <div class="badge badge-primary">{{ $taskPriorities->count() }}</div>
                    </div>
                </div>
                <div class="card-body">
                    @foreach ($taskPriorities as $taskPriority)
                    <div class="card p-2 my-1">
                        <div class="d-flex justify-content-between">
                            <div>{{ $taskPriority->name }}</div>
                            <div class="badge ">{{ $taskPriority->level }}</div>
                        </div>
                    </div>
                    @endforeach
                </div>
                {{-- <div class="card-footer">

                </div> --}}
            </div>
        </div>
    </div>
</div>
