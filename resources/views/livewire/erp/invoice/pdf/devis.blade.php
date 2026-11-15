<?php

use Livewire\Volt\Component;

new class extends Component {
    public $quotation;
}; ?>

<div>
    <div class="mb-2 row g-2">
        @foreach ($quotation->sections->sortBy('ordre') as $key => $section)
        <div class="col-6">
            @if ($section->rows->count())
                <table class="table table-sm bg-white mb-2">
                    <tr class="table-success">
                        <th scope="col" class="" colspan="2">
                            <div class="text-center">{{ $section->section }}</div>
                        </th>
                    </tr>

                    <tr class="bg-teal text-white">
                        <th scope="col" class="text-start ">Désignation</th>
                        <th style="width:80px;" scope="col" class="text-center">Quantité</th>
                    </tr>


                    <tbody style="font-size: 13px;">

                        @foreach ($section->rows->sortBy('priorite_id') as $row)
                            <tr>
                                <td scope="row">
                                    <div class="fw-bold">{!! nl2br($row->designation) !!}</div>
                                    <div class="text-muted" style="font-size: 10px;">{!! nl2br($row->reference) !!}</div>
                                </td>
                                <td class="text-center">{{ $row->quantite }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif

        </div>
        @endforeach
    </div>
</div>
