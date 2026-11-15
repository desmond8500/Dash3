<?php

use Livewire\Volt\Component;

new class extends Component {
    public $resumes = array(
        array(
            'name' => 'Taches',
            'new' => array(
                'count' => 0,
                'color' => 'blue'
            ),
            'pending' => array(
                'count' => 0,
                'color' => 'gray'
            ),
            'completed' => array(
                'count' => 0,
                'color' => 'green'
            ),
            'progress' => array(
                'count' => 0,
                'color' => 'orane'
            ),
            'overdue' => array(
                'count' => 0,
                'color' => 'red'
            ),
        ),
        array(
            'name' => 'Taches',
        ),
        array(
            'name' => 'Taches',
        ),
        array(
            'name' => 'Taches',
        ),
    );
}; ?>

<div class="row g-2 mb-2">
    @foreach ($resumes as $resume)
        <div class="col-3 ">
            <div class="border rounded p-2 bg-white">
                <div class="fw-bold">{{ $resume['name'] }}</div>
            </div>
        </div>
    @endforeach
</div>
