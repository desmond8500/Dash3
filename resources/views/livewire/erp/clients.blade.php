<div>
    @component('components.layout.page-header', ['title'=> 'Clients', 'breadcrumbs' => $breadcrumbs])
    <div class="btn-list">
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addSection">
            <i class="ti ti-plus"></i> sdfsd
        </button>
    </div>
    @endcomponent

   <div class="row row-deck">
    <div class="col">
        Test = {{ $test }}
    </div>
   </div>

    @component('components.modal.modal_add',[
        'id' => "addSection",
        'title' => "Ajouter une section",
        // 'include' => "_tabler.erp.avancement_section_form",
        'method' => "add_section"
        ])

        <input type="text">


       <script> window.addEventListener('close-modal', event => { $("#addSection").modal('hide'); }) </script>
    @endcomponent


</div>
