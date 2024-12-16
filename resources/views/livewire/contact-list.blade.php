<div>

    <div class="row g-2">
        <div class="col">
            <div class="col-md-12">
                <div class="input-icon">
                    <input type="text" class="form-control form-control-rounded" wire:model.live="search" placeholder="Chercher un contact">
                    <span class="input-icon-addon">
                        <i class="ti ti-search"></i>
                    </span>
                </div>
            </div>
        </div>
        <div class="col-auto">
            @if ($client_id)
                @livewire('form.contact-add', ['client_id' => $client_id])
            @else
                @livewire('form.contact-add', ['projet_id' => $projet_id])
            @endif
        </div>
        <div class="w-100"></div>
        @foreach ($contacts as $contact)
            <div class="{{ $card_class ?? 'col-md-6' }}">
                <div class="card p-2">
                    <div class="row g-2">
                        <div class="col-auto">
                            <img src="" alt="A" class="avatar avatar-md">
                        </div>
                        <div class="col">
                            <div class="">{{ $contact->firstname }}</div>
                            <div class="fw-bold">{{ strtoupper($contact->lastname) }}</div>
                            <div class="text-primary">{{ $contact->fonction }}</div>
                        </div>
                        <div class="col-auto">
                            <div class="dropdown open">
                                <button class="btn btn-action" type="button" id="triggerId" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
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
        @endforeach
    </div>

    @component('components.modal', ["id"=>'editContact', 'title' => 'Titre'])
        <form class="row" wire:submit="update">
            @include('_form.contact_form')
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                <button type="submit" class="btn btn-primary">Valider</button>
            </div>
        </form>
        <script> window.addEventListener('open-editContact', event => { window.$('#editContact').modal('show'); }) </script>
        <script> window.addEventListener('close-editContact', event => { window.$('#editContact').modal('hide'); }) </script>
    @endcomponent
</div>
