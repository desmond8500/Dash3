<div>
    @component('components.layouts.page-header', ['title'=> "Timeline", 'breadcrumbs'=> $breadcrumbs])
    <div class="btn-list">
    </div>
    @endcomponent

    <ul class="timeline">
        <li class="timeline-event">
            <div class="timeline-event-icon bg-blue text-white cursor-pointer" wire:click="$dispatch('open-addData')">
                <i class="ti ti-plus"></i>
            </div>
            <div class="card timeline-event-card">
                <div class="card-body">
                    <div class="text-secondary float-end">10 hrs ago</div>
                    <h4>+1150 Followers</h4>
                    <p class="text-secondary">You’re getting more and more followers, keep it up!</p>
                </div>
            </div>
        </li>
        <li class="timeline-event">
            <div class="timeline-event-icon bg-x-lt">
                <i class="ti ti-plus"></i>
            </div>
            <div class="card timeline-event-card">
                <div class="card-body">
                    <div class="text-secondary float-end">10 hrs ago</div>
                    <h4>+1150 Followers</h4>
                    <p class="text-secondary">You’re getting more and more followers, keep it up!</p>
                </div>
            </div>
        </li>
    </ul>



    @component('components.modal', ["id"=>'addData', 'title' => 'Ajouter'])
        <div>
            @livewire('form.invoice-add', ['projet_id' => $projet->id])
        </div>
        <script> window.addEventListener('open-addData', event => { window.$('#addData').modal('show'); }) </script>
        <script> window.addEventListener('close-addData', event => { window.$('#addData').modal('hide'); }) </script>
    @endcomponent

</div>
