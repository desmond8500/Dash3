<div>
    @component('components.layouts.page-header', ['title'=>'Proposition Technique',  'breadcrumbs'=>$breadcrumbs])
        <a class="btn btn-primary" target="_blank" href="{{ route('proposal_pdf',['proposal_id'=>$proposal_id, 'type'=>'proposition technique']) }}"> <i class="ti ti-file-type-pdf"></i> Proposition </a>

    @endcomponent

    <div class="row g-2">
        <div class="col-md-6">
            <div class="card card-body">
                <div>
                    <span class="fw-bold">
                        Client : </span> <span>{{ $devis->client_name ?? $devis->projet->client->name}}
                    </span>
                </div>
                <div>
                    <span class="fw-bold">Projet : </span> <span>{{ $devis->projet->name }}</span>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card card-body">
                <div class="fw-bold">Description</div>
                <div>{!! nl2br($devis->description) !!}</div>
            </div>
        </div>

        <div class="col-md-8">
            @foreach ($devis->sections as $key => $section)

                @if ($section->status)
                    <div class="card mb-2">
                        <table class="table table-hover">
                            <tr>
                                <td colspan="3">
                                    <div class="mb-3">
                                        <div class="fw-bold">{{ $section->section }}</div>
                                        <div class="text-muted  " style="font-size: 12px;">{!! $section->proposition !!}</div>
                                    </div>
                                </td>
                            </tr>
                            <thead class="sticky-top">
                                <tr>
                                    <td width="100px">Photo</td>
                                    <td>Description</td>
                                    <td width="80px" class="text-center">Quantité</td>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($section->rows->sortBy('priorite_id') as $key => $row)
                                    @if ($row->priorite_id<5 )
                                        <tr>
                                            <td>
                                                @isset ($row->article->image)
                                                <img src="{{ asset($row->article->image) }}" alt="I" class="avatar avatar-xl me-2">
                                                @else
                                                <img src="{{ asset(" img/icons/packaging.png") }}" alt="I" class="avatar avatar-sm me-2 bg-white border border-white">
                                                @endisset
                                            </td>
                                            <td>
                                                <div class="mb-1">
                                                    @if ($row->article_id)
                                                    <a href="{{ route('article',['article_id'=>$row->article_id]) }}" target="_blank">{{
                                                        $row->designation }}</a>
                                                    @else
                                                    {{ $row->designation }}
                                                    @endif

                                                </div>
                                                <div class="text-muted" style="font-size: 12px;">{!! nl2br($row->reference) !!}</div>

                                                <div style="font-size: 14px;">{!! nl2br($row->article->description ?? ' ') !!}</div>

                                                <div class="mt-1">
                                                    @if ($row->article && $row->article->links)
                                                    @foreach ($row->article->links as $link)
                                                    @if ($link->name == "Fiche Technique")
                                                    <a href="{{ $link->link }}" class="text-purple" target="_blank">{{ $link->name }}</a>
                                                    @endif
                                                    @endforeach
                                                    @endif      </div>
                                            </td>
                                            <td class="text-center">
                                                {{ $row->quantite }}
                                            </td>
                                        </tr>
                                        @endif
                                @endforeach
                            </tbody>
                        </table>

                    </div>




                    {{-- <table class="table table-responsive">
                        <thead class="sticky-top table-dark">
                            <tr class="">
                                <th scope="col" style="width: 150px;">Photo</th>
                                <th scope="col" class="text-center">Description</th>
                                <th scope="col" style="width: 10px" class="text-center">Quantité</th>
                            </tr>
                        </thead>

                        <tbody>

                            @foreach ($section->rows->sortBy('priorite_id') as $row)
                            @if ($row->priorite_id<5 ) <tr>
                                <td>
                                    @isset ($row->article->image)
                                    <img src="{{ asset($row->article->image) }}"  alt="I" class="avatar avatar-xl me-2">
                                    @else
                                    <img src="{{ asset("img/icons/packaging.png") }}" alt="I"
                                        class="avatar avatar-sm me-2 bg-white border border-white">
                                    @endisset
                                </td>
                                <td>
                                    <div class="mb-1">
                                        @if ($row->article_id)
                                        <a href="{{ route('article',['article_id'=>$row->article_id]) }}" target="_blank">{{
                                            $row->designation }}</a>
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
                                        @if ($link->name == "Fiche Technique")
                                        <a href="{{ $link->link }}" class="text-purple" target="_blank">{{ $link->name }}</a>
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
                    </table> --}}
                @endif
            @endforeach

        </div>
    </div>

</div>
