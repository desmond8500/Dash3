<div class="card-body">
    <div class="row g-2">
        <div class="col mb-3">
            <input type="text" class="form-control" wire:model.live="search" placeholder="Chercher">
        </div>
        <div class="col-auto">
            <button class="btn" wire:click='$refresh'><i class="ti ti-reload"></i></button>
        </div>
        <div class="w-100"></div>
        <div class="col-md-5">
            @foreach ($users as $user)
                <div class="card p-2" wire:click="select_user('{{ $user->id }}')">
                    <div class="row">
                        <div class="col-auto">
                            <img src="" alt="A" class="avatar">
                        </div>
                        <div class="col">
                            <div class="fw-bold">{{ $user->firstname }} {{ $user->lastname }}</div>
                            <div class="">{{ $user->email }} </div>
                            {{-- <div class="text-muted">Description</div> --}}
                        </div>
                        <div class="col-auto">
                            <button class="btn btn-outline-primary btn-icon">
                                <i class="ti ti-edit"></i>
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="col-md-7">
            @if ($selected)
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-auto">
                                <img src="{{ asset($selected->avatar) }}" alt="U" class="avatar ">
                            </div>
                            <div class="col">
                                <div class="fw-bold">{{ $selected->firstname }} {{ $selected->lastname }}</div>
                                <div class="text-muted">{{ $selected->email }} </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">

                    </div>
                </div>
            @endif
        </div>
    </div>

</div>
