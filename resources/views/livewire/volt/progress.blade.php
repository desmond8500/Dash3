<?php

use Livewire\Volt\Component;

new class extends Component {
    public $status = 0;

    function mount($status)
    {
        $this->status = $status;
    }
} ?>


<div>
    @if ($status == "Nouveau")
        <span class="status status-blue">{{ $status }}</span>
    @elseif($status == "En Cours")
    <span class="status status-red">{{ $status }}</span>
    @elseif($status == "En Pause")
    <span class="status status-orange">{{ $status }}</span>
    @elseif($status == "Annulé")
    <span class="status status-indigo">{{ $status }}</span>
    @elseif($status == "Bl a faire")
    <span class="status status-pink">{{ $status }}</span>
    @elseif($status == "A Facturer")
    <span class="status status-teal">{{ $status }}</span>
    @elseif($status == "Proforma")
    <span class="status status-azure">{{ $status }}</span>
    @elseif($status == "Terminé")
    <span class="status status-green">{{ $status }}</span>
    @endif
    {{--
    <span class="status status-purple">Purple</span>
    <span class="status status-yellow">Yellow</span>
    <span class="status status-lime">Lime</span>
    <span class="status status-cyan">Cyan</span> --}}

</div>


