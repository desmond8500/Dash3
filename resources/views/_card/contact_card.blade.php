<div class="{{ $card_class ?? 'col-md-6' }}">
    <div class="card p-2">
        <div class="row g-2">
            <div class="col-auto">
                @if ($contact->photo)
                    <img src="{{ asset($contact->photo) }}" alt="A" class="avatar avatar-md">

                @else
                    <img src="{{ asset("img/icons/user1.png") }}" style="height: 64px; width: 64px" alt="A" class="">

                @endif
            </div>
            <div class="col">
                <div class="">{{ $contact->firstname }}</div>
                <div class="fw-bold">{{ strtoupper($contact->lastname) }}</div>
                <div class="text-primary">{{ $contact->fonction }}</div>
            </div>
            <div class="col-auto">
                <div class="dropdown open">
                    <button class="btn btn-action" type="button" id="triggerId" data-bs-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        <i class="ti ti-chevron-down"></i>
                    </button>
                    <div class="dropdown-menu" aria-labelledby="triggerId">
                        <a class="dropdown-item" wire:click="edit('{{ $contact->id }}')"> <i class="ti ti-edit"></i> Editer</a>
                        <a class="dropdown-item text-danger" wire:click="delete('{{ $contact->id }}')"> <i class="ti ti-trash"></i> Supprimer</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
