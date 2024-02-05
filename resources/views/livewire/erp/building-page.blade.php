<div>
    @component('components.layouts.page-header', ['title'=>'Gestion de batiment', 'breadcrumbs'=>$breadcrumbs])
        @livewire('form.stage-add', ['building_id' => $building->id], key($building->id))
    @endcomponent

    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">{{ $building->name }}</div>
                    <div class="card-actions">

                    </div>
                </div>
                <div class="card-body">
                    {{ nl2br($building->description) }}
                </div>
                <div class="card-body">
                    <div class="row g-2">
                        @foreach ($stages as $stage)
                            <div class="card p-2">
                                <div class="row">
                                    <div class="col-auto">
                                        <img src="" alt="{{ $stage->order }}" class="avatar avatar-md">
                                    </div>
                                    <a href="" wire:click="set_stage('{{ $stage->id }}')" class="col">
                                        <div class="fw-bol">{{ $stage->name }}</div>
                                        <div class="text-muted">{{ nl2br($stage->description) }}</div>
                                    </a>
                                    <div class="col-auto">
                                      {{ $stage->rooms->count() }}
                                      @if ($stage->rooms->count() < 2)
                                          Local
                                      @else
                                        Locaux
                                      @endif

                                      <div>
                                        <a href="{{ route('stage',['stage_id'=>$stage->id]) }}">Détails</a>
                                      </div>
                                      <div>
                                        <a class="text-success" href="">Editer</a>
                                      </div>


                                  </div>
                                </div>
                            </div>

                        @endforeach
                    </div>

                </div>
            </div>
        </div>
        <div class="col-md-8">
            @if ($selected_stage)
                <div class="row g-2">
                    @foreach ($selected_stage->rooms as $room)

                        <div class="card">
                            <div class="card-header">
                                <div class="card-title">{{ $room->name }}</div>
                                <div class="card-actions">
                                    {{-- @livewire('form.room_add', ['user' => $user], key($user->id)) --}}
                                </div>
                            </div>
                            <div class="card-body">

                            </div>
                            <div class="card-footer">

                            </div>
                        </div>

                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>

<script>
    window.addEventListener('close-modal', event => {
        $("#exampleModal").modal('hide');
    })
</script>
