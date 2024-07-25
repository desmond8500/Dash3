<div>

    <div class="row g-2">
        <div class="col">
            <div class="col-md-12 mb-3">
                <input type="text" class="form-control" wire:model="search" placeholder="Rechercher">
            </div>
        </div>
        <div class="col-auto">
            @livewire('form.contact-add', ['projet_id' => $projet_id])
        </div>
        @foreach ($contacts as $contact)
            <div class="col-md-4">
                <div class="card p-2">
                    <div class="row">
                        <div class="col-auto">
                            <img src="" alt="A" class="avatar avatar-md">
                        </div>
                        <div class="col">
                            <div class="card-title">{{ $contact->firstname }}</div>
                            <div class="card-title">{{ $contact->lastname }}</div>
                            <div class="card-title">{{ $contact->focntion }}</div>
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
