<div>
    @component('components.layouts.page-header', ['title'=> 'Plannings'])
        <div class="btn-list">
            {{-- <button class="btn btn-icon" wire:click='$refresh'><i class="ti ti-reload"></i> </button> --}}
            <button class="btn btn-primary" wire:click="add_rv">Ajouter</button>
            @livewire('_forms.schedule_add')
        </div>
    @endcomponent

    <div class="row g-2">
        @foreach ($schedules as $schedule)
        {{-- @dump($schedule) --}}
            <div class="col-md-4">
                <div class="card p-2">
                    <div class="row">
                        <div class="col-auto">
                            <img src="" alt="A" class="avatar avatar-md">
                        </div>
                        <div class="col">
                            <div class="card-title">{{ $schedule->name }}</div>
                            <div class="text-muted">{!! nl2br($schedule->description) !!}</div>
                            <div>
                                {{ $schedule->start_date->format('d/m/Y H:i') }} -
                                @if ($schedule->end_date)
                                    {{ $schedule->end_date->format('d/m/Y H:i') }}

                                @endif
                            </div>
                        </div>
                        <div class="col-auto">
                          <button class="btn btn-outline-primary btn-icon" wire:click="edit('{{ $schedule->id }}')">
                            <i class="ti ti-edit"></i>
                          </button>
                          <button class="btn btn-outline-danger btn-icon" wire:click="edit('{{ $schedule->id }}')">
                            <i class="ti ti-trash"></i>
                          </button>
                      </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
