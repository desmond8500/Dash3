<div>
    @component('components.layouts.page-header', ['title'=>'Achats', 'breadcrumbs'=>$breadcrumbs])
        <div class="btn-list">
            @livewire('form.achat-add')
            @livewire('form.provider-add')
            @livewire('form.brand-add')
        </div>
    @endcomponent

    <div class="row row-deck g-2">
        @forelse ($achats as $achat)
            <div class="col-md-3">
                <div class="card p-2">
                    <div class="row" >
                        <a class="col" href="{{ route('achat', ['achat_id'=> $achat->id]) }}">
                            <div class="card-title">
                                {{ $achat->name }}
                                <div class="text-muted" style="font-size: 12px;">
                                    {{ $achat->date }}
                                </div>
                            </div>
                            <div class="text-muted">{{ nl2br($achat->description) }}</div>
                        </a>
                        <div class="col-auto" wire:click="edit('{{ $achat->id }}')">
                          <button class="btn btn-outline-primary btn-icon" >
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-pencil" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"> <path stroke="none" d="M0 0h24v24H0z" fill="none"></path> <path d="M4 20h4l10.5 -10.5a1.5 1.5 0 0 0 -4 -4l-10.5 10.5v4"></path> <path d="M13.5 6.5l4 4"></path> </svg>
                          </button>
                      </div>
                    </div>
                </div>
            </div>
        @empty

            <div>Pas d'articles</div>

        @endforelse
    </div>

    @component('components.modal', ["id"=>'editAchat', 'title'=>"Editer l'achat"])
        <form class="row" wire:submit="update">
            @include('_form.achat_form')
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                <button type="submit" class="btn btn-primary">Valider</button>
            </div>
        </form>
        <script> window.addEventListener('open-editAchat', event => { $('#editAchat').modal('show'); }) </script>
        <script> window.addEventListener('close-editAchat', event => { $('#editAchat').modal('hide'); }) </script>
    @endcomponent

</div>
