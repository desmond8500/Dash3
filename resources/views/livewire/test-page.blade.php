<div class="row mt-3">
    <div class="col-md-9">
        <div>
            @livewire('modal')
        </div>

        <div class="row">
            @foreach ($widgets as $widget)
                @if ($widget->type == "include")
                    <a href="{{ $widget->link }}" target="_blank" class="{{ $widget->class }}">
                        @includeWhen($widget->id == $selected_widget, $widget->view )
                    </a>
                @elseif($widget->type == "livewire")
                    @if ($widget->id == $selected_widget)
                        @livewire($widget->view)
                    @endif
                @endif
            @endforeach
        </div>
    </div>

    <div class="col-md-3">
        <div class="card">
            <div class="card-header">
                <div class="card-title">Liste des Widgets</div>
                <div class="card-actions">

                </div>
            </div>
            <div class="card-body">
                <div class="btn-list">
                    @foreach ($widgets as $widget)
                        <a class="btn" wire:click="$set('selected_widget', '{{ $widget->id }}')">{{ $widget->name }}</a>
                    @endforeach
                </div>
            </div>
            <div class="card-footer">

            </div>
        </div>
    </div>

    {{-- <div class="col-md-4">
        @include('_card.task1_card')
    </div> --}}

    <div class="col-md-4">
        @foreach ($demos as $demo)
            <div class="card card-body mb-1">
                <div class="row">
                    <div class="col">
                        <div class="card-title">{{ $demo->name }}</div>
                    </div>
                    <div class="col-auto">
                        <button class="btn btn-danger" wire:click="delete_demo('{{ $demo->id }}')">Delete</button>
                    </div>
                </div>
                <div class="card-text">{{ $demo->description }}</div>
            </div>
        @endforeach
    </div>

    <div class="col-md-4">
        <div class="mb-3">
            <label for="">Nom</label>
            <input type="text" wire:model="name" class="form-control">
        </div>
        <div class="mb-3">
            <label for="">Description</label>
            <textarea wire:model="description" class="form-control"></textarea>
        </div>
        <button class="btn btn-primary" wire:click='add_demo'>valider</button>
    </div>



</div>
