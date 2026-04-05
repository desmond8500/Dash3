<div>
    @component('components.layouts.page-header', ['title'=>'Proposition Technique',  'breadcrumbs'=>$breadcrumbs])
        <a class="btn btn-primary" target="_blank" href="{{ route('proposal_pdf',['proposal_id'=>$proposal_id, 'type'=>'proposition technique']) }}"> <i class="ti ti-file-type-pdf"></i> Proposition </a>

    @endcomponent

    <div class="row g-2">

        <div class="col-md-4">
            <div class="card">
                <table class="table table-hover">
                    <thead class="sticky-top">
                        <tr>
                            <td>Section</td>
                            <td width="50px">Action</td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <div class="text-uppercase fw-bold">Client</div>
                                <div>{{ $devis->client_name ?? $devis->projet->client->name }} {{ $devis->client_name }}</div>
                            </td>
                            <td>
                                <div class="btn btn-icon" wire:click="toggleSet('client_name')">
                                    @if ($proposal->client_name)
                                        <i class="ti ti-eye"></i>
                                    @else
                                        <i class="ti ti-eye-closed"></i>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="text-uppercase fw-bold">Projet</div>
                                <div>{{ $devis->projet->name }}</div>
                            </td>
                            <td>
                                <div class="btn btn-icon" wire:click="toggleSet('projet_name')">
                                    @if ($proposal->projet_name)
                                        <i class="ti ti-eye"></i>
                                    @else
                                        <i class="ti ti-eye-closed"></i>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="text-uppercase fw-bold">Description</div>
                                <div>{!! nl2br($devis->description) !!}</div>
                            </td>
                            <td>
                                <div class="btn btn-icon" wire:click="toggleSet('description')">
                                    @if ($proposal->description)
                                        <i class="ti ti-eye"></i>
                                    @else
                                        <i class="ti ti-eye-closed"></i>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="text-uppercase fw-bold">Logo</div>
                                <div></div>
                            </td>
                            <td>
                                <div class="btn btn-icon" wire:click="toggleSet('logo')">
                                    @if ($proposal->logo)
                                        <i class="ti ti-eye"></i>
                                    @else
                                        <i class="ti ti-eye-closed"></i>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="text-uppercase fw-bold">Footer</div>
                                <div>

                                </div>
                            </td>
                            <td>
                                <div class="btn btn-icon" wire:click="toggleSet('footer')">
                                    @if ($proposal->footer)
                                        <i class="ti ti-eye"></i>
                                    @else
                                        <i class="ti ti-eye-closed"></i>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="text-uppercase fw-bold">Détails</div>
                                <div>

                                </div>
                            </td>
                            <td>
                                <div class="btn btn-icon" wire:click="toggleSet('details')">
                                    @if ($proposal->details)
                                        <i class="ti ti-eye"></i>
                                    @else
                                        <i class="ti ti-eye-closed"></i>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
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
