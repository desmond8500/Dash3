<div>
    @component('components.layouts.page-header', ['title'=>'Dépenses', 'breadcrumbs'=>$breadcrumbs])

    @endcomponent

    <div class="row g-2">
        <div class="col-md-8">
            <div class="card mb-3">
                <div class="card-header">
                    <div class="card-title">Dépenses</div>
                    <div class="card-actions">
                        <button class="btn btn-primary btn-icon" wire:click="$dispatch('open-addExpenseDepense')"><i
                                class="ti ti-plus"></i> </button>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-primary">
                        <thead>
                            <tr>
                                <th scope="col" width="10px">#</th>
                                <th scope="col">Description</th>
                                <th scope="col">Montant</th>
                                <th scope="col">Date</th>
                                <th scope="col">Methode</th>
                                <th scope="col" style="width: 100px" class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($expenses as $key => $expense)
                            <tr class="">
                                <td scope="row">{{ $key+1 }}</td>
                                <td>
                                    <div class="fw-bold">{{ $expense->description }}</div>
                                </td>
                                <td class="text-muted">{{ $expense->amount }}</td>
                                <td class="text-muted">{{ $expense->expense_date }}</td>
                                <td class="text-muted">{{ $expense->expense_type }}</td>
                                <td>
                                    <button class="btn btn-sm btn-icon btn-success" wire:click="edit_expense('{{ $expense->id }}')">
                                        <i class="ti ti-edit"></i>
                                    </button>
                                    <button class="btn btn-sm btn-icon btn-danger"
                                        wire:click="delete_expense('{{ $expense->id }}')">
                                        <i class="ti ti-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
        <div class="col-md-4">
            <div class="card mb-3">
                <div class="card-header">
                    <div class="card-title">Espaces</div>
                    <div class="card-actions">
                        <button class="btn btn-primary btn-icon" wire:click="$dispatch('open-addExpenseSpace')"><i
                                class="ti ti-plus"></i> </button>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-primary">
                        <thead>
                            <tr>
                                <th scope="col" >#</th>
                                <th scope="col">Nom / Description</th>
                                <th scope="col" style="width: 100px" class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($spaces as $key => $space)
                            <tr class="">
                                <td scope="row">{{ $key+1 }}</td>
                                <td>
                                    <div class="fw-bold">{{ $space->name }}</div>
                                    <div class="text-muted">{{ $space->type }}</div>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-icon btn-success"
                                        wire:click="edit_space('{{ $space->id }}')">
                                        <i class="ti ti-edit"></i>
                                    </button>
                                    <button class="btn btn-sm btn-icon btn-danger"
                                        wire:click="delete_space('{{ $space->id }}')">
                                        <i class="ti ti-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card mb-3">
                <div class="card-header">
                    <div class="card-title">Utilisateurs</div>
                    <div class="card-actions">
                        <button class="btn btn-primary btn-icon" wire:click="$dispatch('open-addExpenseSpace')"><i
                                class="ti ti-plus"></i> </button>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-primary">
                        <thead>
                            <tr>
                                <th scope="col" >#</th>
                                <th scope="col">Nom / Description</th>
                                <th scope="col" style="width: 100px" class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($spaces as $key => $space)
                            <tr class="">
                                <td scope="row">{{ $key+1 }}</td>
                                <td>
                                    <div class="fw-bold">{{ $space->name }}</div>
                                    <div class="text-muted">{{ $space->type }}</div>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-icon btn-success"
                                        wire:click="edit_space('{{ $space->id }}')">
                                        <i class="ti ti-edit"></i>
                                    </button>
                                    <button class="btn btn-sm btn-icon btn-danger"
                                        wire:click="delete_space('{{ $space->id }}')">
                                        <i class="ti ti-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card mb-3">
                <div class="card-header">
                    <div class="card-title">Catégories</div>
                    <div class="card-actions">
                        <button class="btn btn-primary btn-icon" wire:click="$dispatch('open-addExpenseCategory')"><i class="ti ti-plus"></i> </button>
                    </div>
                </div>
                <div class="table-responsive" >
                    <table class="table table-primary" >
                        <thead>
                            <tr>
                                <th scope="col" width="10px">#</th>
                                <th scope="col">Nom / Description</th>
                                <th scope="col" style="width: 100px" class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($categories as $key => $category)
                                <tr class="">
                                    <td scope="row">{{ $key+1 }}</td>
                                    <td>
                                        <div class="fw-bold" >{{ $category->name }}</div>
                                        <div class="text-muted">{{ $category->description }}</div>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-icon btn-success" wire:click="edit_category('{{ $category->id }}')">
                                            <i class="ti ti-edit"></i>
                                        </button>
                                        <button class="btn btn-sm btn-icon btn-danger" wire:click="delete_category('{{ $category->id }}')">
                                            <i class="ti ti-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    <button class='btn btn-primary' wire:click="$dispatch('open-addExpenseDepense')" ><i class='ti ti-plus'></i> dépense</button>

    @component('components.modal', ["id"=>'addExpenseDepense', 'title' => 'Ajouter une dépense', 'method'=>'store_expense'])
        <form class="row" wire:submit="store_expense">
            @include('_form.expense_form')
        </form>
        <script> window.addEventListener('open-addExpenseDepense', event => { window.$('#addExpenseDepense').modal('show'); }) </script>
        <script> window.addEventListener('close-addExpenseDepense', event => { window.$('#addExpenseDepense').modal('hide'); }) </script>
    @endcomponent

    @component('components.modal', ["id"=>'editExpenseDepense', 'title' => 'Editer une dépense', 'method'=>'update_expense'])
        <form class="row" wire:submit="update_expense">
            @include('_form.expense_form')
        </form>
        <script> window.addEventListener('open-editExpenseDepense', event => { window.$('#editExpenseDepense').modal('show'); }) </script>
        <script> window.addEventListener('close-editExpenseDepense', event => { window.$('#editExpenseDepense').modal('hide'); }) </script>
    @endcomponent

    {{-- Catégory --}}
    {{-- Add Catégory --}}
    @component('components.modal', ["id"=>'addExpenseCategory', 'title' => 'Ajouter une Catégorie', 'method'=>'store_category'])
        <form class="row" wire:submit="store_category">
            @include('_form.expense_category_form')
        </form>
        <script> window.addEventListener('open-addExpenseCategory', event => { window.$('#addExpenseCategory').modal('show'); }) </script>
        <script> window.addEventListener('close-addExpenseCategory', event => { window.$('#addExpenseCategory').modal('hide'); }) </script>
    @endcomponent

    {{-- Edit catégory --}}
    @component('components.modal', ["id"=>'editExpenseCategory', 'title' => 'Modifier une Catégorie', 'method'=>'update_category'])
        <form class="row" wire:submit="update_category">
            @include('_form.expense_category_form')
        </form>
        <script> window.addEventListener('open-editExpenseCategory', event => { window.$('#editExpenseCategory').modal('show'); }) </script>
        <script> window.addEventListener('close-editExpenseCategory', event => { window.$('#editExpenseCategory').modal('hide'); }) </script>
    @endcomponent

    {{-- Space ========================================================== --}}
    {{-- Add Space --}}
    @component('components.modal', ["id"=>'addExpenseSpace', 'title' => 'Ajouter un espace', 'method'=>'store_space'])
        <form class="row" wire:submit="store_space">
            @include('_form.expense_space_form')
        </form>
        <script> window.addEventListener('open-addExpenseSpace', event => { window.$('#addExpenseSpace').modal('show'); }) </script>
        <script> window.addEventListener('close-addExpenseSpace', event => { window.$('#addExpenseSpace').modal('hide'); }) </script>
    @endcomponent

    {{-- Edit Space --}}
    @component('components.modal', ["id"=>'editExpenseSpace', 'title' => 'Editer un espace', 'method'=>'space_update'])
        <form class="row" wire:submit="space_update">
            @include('_form.expense_space_form')
        </form>
        <script> window.addEventListener('open-editExpenseSpace', event => { window.$('#editExpenseSpace').modal('show'); }) </script>
        <script> window.addEventListener('close-editExpenseSpace', event => { window.$('#editExpenseSpace').modal('hide'); }) </script>
    @endcomponent
</div>
