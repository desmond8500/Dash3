<?php

use Livewire\Volt\Component;
use App\Livewire\Forms\myprojectForm;

new class extends Component {
    public myprojectForm $project_form;

    function store(){
        $this->project_form->store();
        $this->dispatch('close-addProject');
    }

}; ?>

<div>
    <button class='btn btn-primary' wire:click="$dispatch('open-addProject')" ><i class='ti ti-plus'></i> Projet</button>

    @component('components.modal', ["id"=>'addProject', 'title' => 'Ajouter un projet', 'method'=>'store'])
        <form class="row align-items-center" wire:submit="store">
            @include('_form.myproject_form')
        </form>
        <script> window.addEventListener('open-addProject', event => { window.$('#addProject').modal('show'); }) </script>
        <script> window.addEventListener('close-addProject', event => { window.$('#addProject').modal('hide'); }) </script>
    @endcomponent
</div>
