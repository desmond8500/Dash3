<div>
    @component('components.layouts.page-header', ['title'=> 'Test page'])
        <div class="btn-list">
            <button class="btn btn-icon" wire:click='$refresh'><i class="ti ti-reload"></i> </button>
        </div>



    @endcomponent

    <div class="row mt-3">

        <div class="col-md-12" >

            @script

            <script src="https://cdn.jsdelivr.net/npm/konva@9/konva.min.js"></script>


           <div id="container"></div>

            <script>
                // Créer une scène (canvas)
                var stage = new Konva.Stage({
                  container: 'container', // id du conteneur
                  width: 500,
                  height: 500,
                });

                // Créer un calque
                var layer = new Konva.Layer();

                // Ajouter un cercle
                var circle = new Konva.Circle({
                  x: 250,
                  y: 250,
                  radius: 80,
                  fill: 'red',
                  stroke: 'black',
                  strokeWidth: 4,
                  draggable: true, // on peut le déplacer
                });

                // Ajouter le cercle au calque
                layer.add(circle);

                // Ajouter le calque à la scène
                stage.add(layer);
            </script>

            @endscript




        </div>


        <section class="col-md-8">
            @if ($selected_card)
                @include($selected_card)
            @endif

            <div class="row">
                @foreach ($widgets as $widget)
                    @if ($widget->type == "include")
                        <a href="{{ $widget->link }}" target="_blank" class="{{ $widget->class }}">
                            @if ($widget->data)
                                @includeWhen($widget->id == $selected_widget, $widget->view, [$widget->data_name => $widget->data] )
                            @else
                                @includeWhen($widget->id == $selected_widget, $widget->view )
                            @endif
                        </a>
                    @elseif($widget->type == "livewire")
                        @if ($widget->id == $selected_widget)

                        @endif
                    @endif
                @endforeach
            </div>
        </section>


        <nav class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Liste des Widgets</div>
                    <div class="card-actions">

                    </div>
                </div>
                <div class="card-body card-body-scrollable card-body-scrollable-shadow" style="height: 600px;">
                    @foreach ($widgets as $widget)
                        <a class="card p-2 mb-1" type="button" wire:click="$set('selected_widget', '{{ $widget->id }}')">
                            <div>
                                @if ($widget->type == 'livewire')
                                    <div class="badge text-white bg-pink">{{ $widget->type }}</div>
                                @else
                                    <div class="badge text-white bg-purple">{{ $widget->type }}</div>
                                @endif
                            </div>

                            <div class="fw-bold">{{ $widget->name }}</div>
                            <div>{!! $widget->description !!}</div>
                            <div class="muted">{{ $widget->view }}</div>
                        </a>
                    @endforeach
                </div>
                <div class="card-footer">

                </div>
            </div>
        </nav>

    </div>



</div>
