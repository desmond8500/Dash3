<?php

use Livewire\Volt\Component;

new class extends Component {
    public $size;

    function mount()
    {
        $this->size = (object) array('height' => 500, 'width' => 600);
        $this->js("alert('test');");

        $this->js("
            var stage = new Konva.Stage({
            container: 'container',
            width: 500 ,
            height: 500,
            });

            var layer = new Konva.Layer();

            var circle = new Konva.Circle({
            x: stage.width() / 2,
            y: stage.height() / 2,
            radius: 70,
            fill: 'red',
            stroke: 'black',
            strokeWidth: 4,
            });

            circle.draggable(true);

            layer.add(circle);

            stage.add(layer);

        ");
    }
}; ?>

<div >
    <script src="https://cdn.jsdelivr.net/npm/konva@9/konva.min.js"></script>
    <div id="container" class="border rounded"></div>

    {{-- @php
        $test = 1;
        $name = 'test';
        echo "<script>
            var height = '$size->height';
            var width = '$size->width';
        </script>";
    @endphp --}}

    {{-- <script>
        var stage = new Konva.Stage({
        container: 'container',
            width: width ,
            height: height,
        });

        var layer = new Konva.Layer();

        var circle = new Konva.Circle({
            x: stage.width() / 2,
            y: stage.height() / 2,
            radius: 70,
            fill: 'red',
            stroke: 'black',
            strokeWidth: 4,
        });

        circle.draggable(true);

        layer.add(circle);

        stage.add(layer);
    </script> --}}
</div>
