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
            @include('_card.contact_card', ['contact' => $contact])
        @endforeach
    </div>

    @component('components.modal', ["id"=>'editContact', 'title' => 'Titre', 'method'=>"update"])
        <form class="row" wire:submit="update">
            @include('_form.contact_form')
        </form>
        <script> window.addEventListener('open-editContact', event => { window.$('#editContact').modal('show'); }) </script>
        <script> window.addEventListener('close-editContact', event => { window.$('#editContact').modal('hide'); }) </script>
    @endcomponent
</div>
