<div>
    @component('components.layouts.page-header', ['title'=> $stage->building->name.": ".$stage->name , 'breadcrumbs'=>$breadcrumbs])
        <div class="btn-list">
            @livewire('form.room-add', ['stage_id' => $stage->id], key($stage->id))
            @livewire('form.task-add', ['stage_id' => $stage->id], key($stage->id))
        </div>
    @endcomponent
    <div class="row g-2">
        <div class="col-md-5 ">

            <div class="card mb-2">
                <div class="card-header">
                    <div class="card-title">
                        <div class="fw-bold">Niveau : {{ $stage->name }}</div>
                    </div>
                    <div class="card-actions">
                        <button class="btn btn-primary" >
                            <i class="ti t-edit"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    {{ nl2br($stage->description) }}
                </div>

                <div class="card-footer">

                </div>
            </div>

            <div class="">
                @livewire('erp.tasklist', ['stage_id' => $stage->id], key($stage->id))
            </div>
        </div>

        <div class="col-md-7">
            <div class="row g-2">
                @foreach ($stage->rooms as $room)
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
                                  <button class="btn btn-outline-primary btn-icon" >
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-pencil" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"> <path stroke="none" d="M0 0h24v24H0z" fill="none"></path> <path d="M4 20h4l10.5 -10.5a1.5 1.5 0 0 0 -4 -4l-10.5 10.5v4"></path> <path d="M13.5 6.5l4 4"></path> </svg>
                                  </button>
                              </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

    </div>
</div>
