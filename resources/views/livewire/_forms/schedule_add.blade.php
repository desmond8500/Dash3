<?php

use Livewire\Volt\Component;

new class extends Component {
    public $name, $description;
    public $start_date, $end_date;
    public $start_time, $end_time;

    function store(){
        $user = auth()->user();

        try {
            $schedule = Zap::for($user)
                ->named($this->name)
                ->description($this->description)
                ->from($this->start_date)
                ->addPeriod('09:00', '10:00')
                ->noOverlap()
                ->withmetadata([ ])
                ->save();

            $this->dispatch('close-addSchedule');
            $this->dispatch('get-schedules');

        } catch (ScheduleConflictException $e) {
            $conflicts = $e->getConflictingSchedules();
            $this->js("alert('Conflit')");
        }
    }
}; ?>

<div>
    <button class='btn btn-primary' wire:click="$dispatch('open-addSchedule')" ><i class='ti ti-plus'></i> Rendez-vous</button>

    @component('components.modal', ["id"=>'addSchedule', 'title' => 'Ajouter un rendez-vous', 'method'=>'store'])
        <form class="row" wire:submit="store">
            @include('_form.schedule_add_form')
        </form>
        <script> window.addEventListener('open-addSchedule', event => { window.$('#addSchedule').modal('show'); }) </script>
        <script> window.addEventListener('close-addSchedule', event => { window.$('#addSchedule').modal('hide'); }) </script>
    @endcomponent
</div>
