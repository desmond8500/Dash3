<div class="row g-2">
    <div class="col-md-3">
        @foreach ($stages->sortBy('order') as $stage)
        <div class="mb-2">
            @include('_card.stage_card')
        </div>
        @endforeach

    </div>

    <div class="col-md-9">
        @if ($selected_stage)

        <div class="card mb-2">
            <div class="card-header">
                <h3 class="card-title"> {{ $selected_stage->name }} </h3>
                <div class="card-actions">
                    <div class="btn-list">
                        @livewire('form.room-add', ['stage_id' => $stage->id], key($stage->id))
                        @livewire('_forms.room_add', ['stage_id' => $stage->id], key($stage->id))
                        <button class="btn btn-primary btn-icon" wire:click="edit_stage('{{ $selected_stage->id }}')">
                            <i class="ti ti-edit"></i>
                        </button>
                        <button class="btn btn-danger btn-icon" wire:click="delete_stage('{{ $selected_stage->id }}')">
                            <i class="ti ti-trash"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-2">

            @foreach ($selected_stage->rooms as $room)
            <div class="col-md-4">
                <div class="card p-2">
                    <div class="row">
                        <div class="col">
                            <div class="card-title">
                                <a href="{{ route('room', ['room_id' => $room->id]) }}">{{ $room->name }}</a>
                            </div>
                            <div class="text-muted">{{ nl2br($room->description) }}</div>
                        </div>
                        <div class="col-auto">
                            <button class="btn btn-outline-primary btn-icon">
                                <i class="ti ti-edit"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @endif

    </div>
</div>
