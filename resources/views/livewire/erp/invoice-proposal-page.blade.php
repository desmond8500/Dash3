<div>
    @component('components.layouts.page-header', ['title'=>'Proposition Technique',  'breadcrumbs'=>$breadcrumbs])
        <a class="btn btn-primary" target="_blank" href="{{ route('proposal_pdf',['proposal_id'=>$proposal_id, 'type'=>'proposition technique']) }}"> <i class="ti ti-file-type-pdf"></i> Proposition </a>

    @endcomponent

    <div class="row g-2">

        <div class="col-md-3">
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

        <div class="col-md-9">
            <div class="card mb-2">
                <div class="card-header">
                    <div class="card-title">Proposition Technique</div>
                    <div class="card-actions">
                        <button class='btn btn-primary btn-icon' wire:click="$dispatch('open-editInvoiceProposal')" ><i class='ti ti-edit'></i> </button>
                    </div>
                </div>
            </div>

            @livewire('erp/invoice/pdf/header', ['data' => $data])
            @livewire('erp/invoice/pdf/resume', ['data' => $data])
            @livewire('erp/invoice/pdf/devis', ['quotation' => $data['quotation']])
            @livewire('erp/invoice/pdf/details_tech', ['quotation' => $data['quotation']])
            @livewire('erp/invoice/pdf/avancement', ['data' => $data])
            @livewire('erp/invoice/pdf/photos', ['data' => $data])
            @livewire('erp/invoice/pdf/taches', ['data' => $data])
            @livewire('erp/invoice/pdf/plans', ['data' => $data])

        </div>
    </div>

</div>
