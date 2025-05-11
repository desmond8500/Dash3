<div>
    @component('components.layouts.page-header', ['title'=> 'Test page'])
        <div class="btn-list">
            <button class="btn btn-icon" wire:click='$refresh'><i class="ti ti-reload"></i> </button>
        </div>
    @endcomponent

    <div class="row mt-3">


        <section class="col-md-8">

          <div class="accordion" id="accordionExample">
                <div class="accordion-item">
                    <h5 class="accordion-header" id="headingOne">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne"
                            aria-expanded="true" aria-controls="collapseOne">
                            Accordion Item #1
                        </button>
                    </h5>
                    <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne"
                        data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <strong>This is the first item's accordion body.</strong> It is shown by default, until the collapse
                            plugin adds the appropriate classes that we use to style each element. These classes control the overall
                            appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with
                            custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go
                            within the <code>.accordion-body</code>, though the transition does limit overflow.
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingTwo">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                            Accordion Item #2
                        </button>
                    </h2>
                    <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo"
                        data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <strong>This is the second item's accordion body.</strong> It is hidden by default, until the collapse
                            plugin adds the appropriate classes that we use to style each element. These classes control the overall
                            appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with
                            custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go
                            within the <code>.accordion-body</code>, though the transition does limit overflow.
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingThree">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                            Accordion Item #3
                        </button>
                    </h2>
                    <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree"
                        data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <strong>This is the third item's accordion body.</strong> It is hidden by default, until the collapse
                            plugin adds the appropriate classes that we use to style each element. These classes control the overall
                            appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with
                            custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go
                            within the <code>.accordion-body</code>, though the transition does limit overflow.
                        </div>
                    </div>
                </div>        </div>


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
