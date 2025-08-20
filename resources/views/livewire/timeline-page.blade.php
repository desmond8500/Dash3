<div>
    @component('components.layouts.page-header', ['title'=> "Timeline", 'breadcrumbs'=> $breadcrumbs])
    <div class="btn-list">
    </div>
    @endcomponent

    <ul class="timeline">
        <li class="timeline-event">
            <div class="timeline-event-icon bg-blue text-white cursor-pointer" wire:click="$dispatch('open-addData')">
                <i class="ti ti-plus"></i>
            </div>
            <div class="card timeline-event-card">
                <div class="row g-2 p-2">
                    <div class="col-auto">
                        <img src="{{ asset($projet->client->avatar) }}" alt="avatar" class="avatar avatar-xl">
                    </div>
                    <div class="col">
                        <h1>{{ $projet->name }}</h1>
                        <p>{{ $projet->description }}</p>
                    </div>
                    <div class="col-auto">
                        <button class="btn btn-primary disabled btn-icon" >
                            <i class="ti ti-edit"></i>
                        </button>
                    </div>
                </div>
            </div>
        </li>
        @foreach ($timelines as $timeline)
            @include('_card.timeline_card')
        @endforeach
    </ul>



    @component('components.modal', ["id"=>'addData', 'title' => 'Ajouter'])
        <div>
            @livewire('form.invoice-add', ['projet_id' => $projet->id])
        </div>
        <script> window.addEventListener('open-addData', event => { window.$('#addData').modal('show'); }) </script>
        <script> window.addEventListener('close-addData', event => { window.$('#addData').modal('hide'); }) </script>
    @endcomponent

</div>
