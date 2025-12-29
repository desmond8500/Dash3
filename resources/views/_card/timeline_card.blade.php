<li class="timeline-event">
    <div class="timeline-event-icon bg-x-lt">
        <i class="ti ti-plus"></i>
    </div>
    <div class="card timeline-event-card">
        <div class="row p-2">
            <div class="col-auto">
                <div class="text-secondary ">{{ $timeline->formatDate($timeline->created_at) }}</div>
                <h4 class="text-uppercase">{{ $timeline->title }}</h4>
                <p class="text-secondary">{{ $timeline->description }}</p>
            </div>
            <div class="col-md-6">
                @if ($timeline->invoice)
                    <div class="border-bottom pb-1 mb-1">
                        <span class="text-primary">{{ $timeline->invoice->projet->client->name }}</span> /
                        <span class="text-purple">{{ $timeline->invoice->projet->name }}</span>
                    </div>
                    <div>
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('invoice',['invoice_id'=>$timeline->invoice->id]) }}" class="text-dark" target="_blank">
                                <h4 style="text-transform: uppercase">{{ $timeline->invoice->reference }}</h4>
                            </a>

                            @component('components.status',['status'=>$timeline->invoice->statut, 'invoice_id'=> $timeline->invoice->id, 'statuses'=>$statuses])

                            @endcomponent
                        </div>
                        <div class="mb-1">
                            {{ nl2br($timeline->invoice->description) }}
                        </div>
                    </div>

                    <div>
                        @if ($timeline->invoice->paydate != null)
                        <div class=" text-purple"> <i class="ti ti-check"></i> {{ $timeline->invoice->dateFormat($timeline->invoice->paydate) }} </div>
                        {{-- @else
                        <div class=""> <i class="ti ti-calendar"></i> {{ date_format($timeline->invoice->created_at, "d-m-Y") }} </div> --}}
                        @endif
                        <div class=" text-end text-indigo fw-bold fs-3">{{ number_format($timeline->invoice->total(), 0,'.', ' ') }} F</div>
                    </div>
                @endif

            </div>
            <div class="col-md-4">

            </div>
        </div>
    </div>
</li>
