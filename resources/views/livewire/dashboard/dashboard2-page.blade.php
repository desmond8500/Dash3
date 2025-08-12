<div>
    @component('components.layouts.page-header', ['title'=> 'Dashboard 2'])

        <div class="input-icon">
            <input type="text" class="form-control form-control-rounded" wire:model.live="search" placeholder="Chercher ">
            <span class="input-icon-addon">
                <i class="ti ti-search"></i>
            </span>
        </div>

    @endcomponent

    <style>
        .title_bar {
            border: 1px solid #066fd1;
            padding: 5px;
            margin-top: 5px;
            border-radius: 5px;
            background: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }
    </style>

    <div class="row g-2">
        <div class="col">
            {{-- <h2> {{ $selected_tab->name }}  </h2> --}}
        </div>
        <div class="col-auto">
            @foreach ($tabs as $tab)
                <button class="btn btn-primary" wire:click="select_tab(' {{ $tab->id }} ')">{{$tab->name}} </button>
            @endforeach
        </div>
    </div>

    <div class="">
        @if (!empty($clients))
            <div class="title_bar">
                <h2 class="title">Clients</h2>
                <div class="btn btn-pill btn-primary">{{ $clients->count() }}</div>
            </div>
            <div class="row g-2 row-deck">
                @foreach ($clients as $client)
                    <div class="col-md-4">
                        @include('_card.client_card')
                    </div>
                @endforeach
            </div>
        @endif

        @if (!empty($projets))
            <div class="title_bar">
                <h2 class="title">Projets</h2>
                <div class="btn btn-pill btn-primary">{{ $projets->count() }}</div>
            </div>
            <div class="row g-2 row-deck">
                @foreach ($projets as $projet)
                    <div class="col-md-4">
                        @include('_card.projet_card')
                    </div>
                @endforeach
            </div>
        @endif

        @if (!empty($invoices))
        <div class="title_bar">
            <h2 class="title">Devis</h2>
            <div class="btn btn-pill btn-primary">{{ $invoices->count() }}</div>
        </div>
            <div class="row g-2 row-deck">
                @foreach ($invoices as $invoice)
                    <div class="col-md-4">
                        @include('_card.invoice_card')
                    </div>
                @endforeach
            </div>
        @endif
    </div>

</div>
