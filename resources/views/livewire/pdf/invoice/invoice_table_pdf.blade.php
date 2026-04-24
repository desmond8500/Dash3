<?php

use Livewire\Volt\Component;
use App\Models\Invoice;
use App\Models\InvoiceSection;
use App\Http\Controllers\InvoiceController;

new class extends Component {
    public $invoice;
    public $sections;
    public $statuses;
    public $title;

    public function mount($invoice_id)
    {
        $this->invoice = Invoice::findOrFail($invoice_id);
        $this->sections = InvoiceSection::where('invoice_id', $this->invoice->id)->get();
        $this->statuses = InvoiceController::statut();
    }
}; ?>

<div class="border rounded mt-2">

    <div class="">
        <table class="table table-sm ">
            <thead style="border-radius: 10px;" class="bg-green3 text-white">
                <tr class="bg-green text-white">
                    <th scope="col" class="text-start text-white">Désignation</th>
                    <th style="width:80px;" scope="col" class="text-center text-white">Quantité</th>
                    @if ($title != 'quantitatif')
                        <th style="width: 80px;" scope="col" class="text-center text-white">Prix</th>
                        <th style="width: 100px;" scope="col" class="text-center text-white">Total</th>
                    @endif
                </tr>
            </thead>
            @php
                $total = 0;
                $total_marge = 0;
            @endphp
            @foreach ($sections->sortBy('ordre') as $key => $section)
                @php
                    $subtotal = 0;
                @endphp
                @if ($section->rows->count())
                    <tr class="table-success">
                        <th scope="col" class="" colspan="{{ $title != ' quantitatif' ? 4 : 2 }}">
                            <div class="text-center">{{ $section->section }}</div>
                        </th>
                    </tr>

                    <tbody style="font-size: 13px;">

                        @foreach ($section->rows->sortBy('priorite_id') as $row)
                            @php
                                $total += $row->quantite * $row->prix;
                                $total_marge += $row->quantite * $row->coef * $row->prix;
                                $subtotal += $row->quantite * $row->coef * $row->prix;
                            @endphp
                            <tr @class(['text-danger' => $row->quantite == 0 || $row->prix == 0])>
                                <td scope="row">
                                    <div class="fw-bold">{!! nl2br($row->designation) !!}</div>
                                    <div class="text-muted" style="font-size: 10px;">{!! nl2br($row->reference) !!}</div>
                                </td>
                                <td class="text-center">{{ $row->quantite }}</td>
                                @if ($title != 'quantitatif')
                                    <td class="text-center">
                                        <div>{{ number_format($row->prix * $row->coef, 0, '.', ' ') }}</div>
                                    </td>
                                    <td class="text-center">
                                        <div>{{ number_format($row->prix * $row->quantite * $row->coef, 0, '.', ' ') }}</div>

                                    </td>
                                @endif
                            </tr>
                        @endforeach

                        @if ($title != 'quantitatif')
                            <tr class="table-secondary">
                                <td colspan="3">Sous Total</td>
                                <td colspan="1" class="text-end"> {{ number_format($subtotal, 0, '.', ' ') }} F</td>
                            </tr>
                        @endif
                    </tbody>
                @endif
            @endforeach

        </table>

        @if ($title != 'quantitatif')
            @include('_pdf2.invoice_total_pdf')
        @endif

        <div class="mt-1 p-2">
            <div class="row">
                <div class="col-6">
                    <div class="border rounded h-100 p-2">
                        <div class="fw-bold text-underline" style="margin-bottom: 5px;">Modalités :</div>
                        <div>{!! nl2br($invoice->modalite) !!}</div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="border rounded h-100 p-2">
                        <div class="fw-bold mt-1 text-underline" style="margin-bottom: 5px;">Notes :</div>
                        <div>{!! nl2br($invoice->note) !!}</div>
                    </div>
                </div>
            </div>
        </div>


        @isset($acomptes)
            @include('_pdf.facture.facture_acompte_pdf')
        @endisset
    </div>

    @if ($sections)
        @foreach ($sections as $key => $section)
            @if ($section->status)
                <div class="page-break"></div>

                @if ($loop->first)
                    <table>
                        <tr>
                            <td width="40px" class="text-center border-white">
                                <img src="{{ 'img/icons/writing.png' }}" height="40px" alt=""
                                    style="color: green;">
                            </td>

                            <td class="border-white">
                                <div class="doc_title" style="text-transform: uppercase; color: #{{ $color1 }} ">
                                    Détails Techniques
                                </div>
                            </td>
                        </tr>
                    </table>

                    <div style="border: 1px solid #219c90;">

                    </div>
                @endif

                <table class="table mt-1">
                    <tr>
                        <td colspan="3">
                            <div class="my-0">
                                <div class="fw-bold">{{ $section->section }}</div>
                                <div class="text-muted  " style="font-size: 12px;">{!! $section->proposition !!}</div>
                            </div>

                        </td>

                    </tr>
                    <thead>
                        <tr style="background: #{{ $color1 }}; color: white;">
                            <th scope="col" style="width: 150px;">Photo</th>
                            <th scope="col" class="text-center">Description</th>
                            <th scope="col" style="width: 10px" class="text-center">Quantité</th>
                        </tr>
                    </thead>

                    <tbody>

                        @foreach ($section->rows->sortBy('priorite_id') as $row)
                            @if ($row->priorite_id < 5)
                                <tr>
                                    <td>
                                        @isset($row->article->image)
                                            <img src="{{ $row->article->image }}" style="height: 150px" alt="I"
                                                class="avatar avatar-sm me-2">
                                        @else
                                            <img src="{{ ' img/icons/packaging.png' }}" style="height: 150px"
                                                alt="I" class="avatar avatar-sm me-2 bg-white border border-white">
                                        @endisset
                                    </td>
                                    <td style="vertical-align: top;">
                                        <div class="mb-1">
                                            @if ($row->article_id)
                                                <a href="{{ route('article', ['article_id' => $row->article_id]) }}"
                                                    target="_blank">{{ $row->designation }}</a>
                                            @else
                                                {{ $row->designation }}
                                            @endif

                                        </div>
                                        <div class="text-muted" style="font-size: 12px;">{!! nl2br($row->reference) !!}</div>
                                        <hr>

                                        <div style="font-size: 14px;">{!! nl2br($row->article->description ?? ' ') !!}</div>

                                        <div class="mt-1">
                                            @if ($row->article && $row->article->links)
                                                @foreach ($row->article->links as $link)
                                                    @if ($link->name == 'Fiche Technique')
                                                        <a href="{{ $link->link }}" class="text-purple"
                                                            target="_blank">{{ $link->name }}</a>
                                                    @endif
                                                @endforeach
                                            @endif
                                        </div>
                                    </td>
                                    <td class="text-center">{{ $row->quantite }}</td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            @endif
        @endforeach
    @endif

</div>
