<div>
    @component('components.layouts.page-header', ['title'=>'Achats', 'breadcrumbs'=>$breadcrumbs])
        @livewire('form.achat-add')
    @endcomponent

    <div class="row">
        @forelse ($achats as $achat)
            <div class="col-md-3">
                <div class="card p-2">
                    <a class="row" href="{{ route('achat', ['achat_id'=> $achat->id]) }}" >
                        <div class="col" wire:click="gotoAchat('{{ $achat->id }}')">
                            <div class="card-title">
                                {{ $achat->name }}
                                <div class="text-muted" style="font-size: 10px;">
                                    {{ $achat->date }}
                                </div>
                            </div>
                            <div class="text-muted">{{ nl2br($achat->description) }}</div>
                        </div>
                        <div class="col-auto">
                          <button class="btn btn-outline-primary btn-icon" >
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-pencil" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"> <path stroke="none" d="M0 0h24v24H0z" fill="none"></path> <path d="M4 20h4l10.5 -10.5a1.5 1.5 0 0 0 -4 -4l-10.5 10.5v4"></path> <path d="M13.5 6.5l4 4"></path> </svg>
                          </button>
                      </div>
                    </a>
                </div>


            </div>
        @empty

        @endforelse
    </div>

</div>
