<?php

use Livewire\Volt\Component;

new class extends Component {
    public $quotation;
}; ?>

<div class="bg-white">
    @if ($quotation->sections)
        @foreach ($quotation->sections as $key => $section)
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
                                <h3 class="doc_title" style="text-transform: uppercase; color: green ">
                                    Détails Techniques
                                </h3>
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
                        <tr style="background: green; color: white;">
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
                                            <img src="{{ asset($row->article->image) }}" style="height: 150px"
                                                alt="I" class="avatar avatar-sm me-2">
                                        @else
                                            <img src="{{ 'img/icons/packaging.png' }}" style="height: 150px" alt="I"
                                                class="avatar avatar-sm me-2 bg-white border border-white">
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
