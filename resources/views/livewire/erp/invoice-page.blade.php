<div>
    @component('components.layouts.page-header', ['title'=>'Devis', 'breadcrumbs'=>$breadcrumbs])
    @endcomponent

    <div class="row">
        <div class="col-md-8">

            <div class="card">
                <div class="card-header">
                    <div class="card-title">
                        <div>{{ $devis->client_name }}</div>
                        <div class="text-primary">#{{ $devis->reference }}</div>
                    </div>
                    <div class="card-actions btn-list">
                        <div class="dropdown">
                            <a href="#" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown">Actions</a>
                            <div class="dropdown-menu">
                                <span class="dropdown-header">Devis</span>
                                <a class="dropdown-item text-success" href="#"> <i class="ti ti-edit"></i> Modifier </a>
                                <a class="dropdown-item text-danger" href="#"> <i class="ti ti-trash"></i> Supprimer </a>

                                <div class="dropdown-divider"></div>

                                <span class="dropdown-header">Devis</span>
                                <a class="dropdown-item" href="#"> <i class="ti ti-file-type-pdf"></i> Devis PDF </a>
                                <a class="dropdown-item" href="#"> <i class="ti ti-file-type-pdf"></i> Devis Simple PDF </a>
                                <a class="dropdown-item" href="#"> <i class="ti ti-file-type-pdf"></i> Proforma PDF </a>

                                <span class="dropdown-header">Facture</span>
                                <a class="dropdown-item" href="#"> <i class="ti ti-file-type-pdf"></i> Facture PDF </a>
                                <a class="dropdown-item" href="#"> <i class="ti ti-file-type-pdf"></i> Facture d'acompte </a>
                                <a class="dropdown-item" href="#"> <i class="ti ti-file-type-pdf"></i> Facture Simple PDF </a>

                                <span class="dropdown-header">Exporter</span>
                                <a class="dropdown-item" href="#"> <i class="ti ti-file-type-pdf"></i> Quantitatif PDF </a>
                                <a class="dropdown-item" href="#"> <i class="ti ti-file-type-pdf"></i> Quantitatif XLS </a>
                                <a class="dropdown-item" href="#"> <i class="ti ti-file-type-pdf"></i> Facture Simple PDF </a>
                            </div>
                        </div>
                        <button class="btn btn-primary" >
                            <i class="ti ti-plus"></i> Article
                        </button>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table ">
                        <thead>
                            <tr>
                                <th scope="col">Désignation</th>
                                <th scope="col" class="text-center">Quantité</th>
                                <th scope="col" class="text-center">Coef</th>
                                <th scope="col" class="text-center">Prix</th>
                                <th scope="col" class="text-center">Total</th>
                                <th scope="col" class="text-center">Marge</th>
                                <th scope="col" class="text-center">_</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="">
                                <td scope="row">
                                    <div>Désignation de l'article</div>
                                    <div class="text-muted">#DCA-458-23</div>
                                </td>
                                <td class="text-center">12</td>
                                <td class="text-center">1.2</td>
                                <td class="text-center">{{ number_format('25000', 0,'.', ' ') }}</td>
                                <td class="text-center">25000</td>
                                <td class="text-center">5000</td>
                                <td class="text-center">
                                    <div>
                                        <button class="btn btn-action text-success" ><i class="ti ti-edit"></i></button>

                                        <button class="btn btn-action text-danger" ><i class="ti ti-trash"></i></button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-auto">
                            <button class="btn btn-primary" >
                                <i class="ti ti-plus"></i> Article
                            </button>
                        </div>
                        <div class="col"></div>
                    </div>
                </div>
            </div>

        </div>
        <div class="col-md-4">

            <div class="card mb-1">
                <div class="card-header">
                    <div class="card-title">Acompte</div>
                    <div class="card-actions">
                        <button class="btn btn-primary btn-icon" >
                            <i class="ti ti-plus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">

                </div>
                <div class="card-footer"></div>
            </div>

            <div class="card mb-1">
                <div class="card-header">
                    <div class="card-title">Dépenses</div>
                    <div class="card-actions">
                        <button class="btn btn-primary btn-icon" >
                            <i class="ti ti-plus"></i>
                        </button>
                    </div>
                </div>
               <div class="card-body">

                </div>
                <div class="card-footer"></div>
            </div>
            <div class="card mb-1">
                <div class="card-header">
                    <div class="card-title">Documents</div>
                    <div class="card-actions">
                        <button class="btn btn-primary btn-icon" >
                            <i class="ti ti-plus"></i>
                        </button>
                    </div>
                </div>
               <div class="card-body">

                </div>
            </div>


        </div>
    </div>
</div>
