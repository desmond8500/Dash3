<div class="accordion-item ">
    <div class="p-2" id="flush-headingOne">
        <button class="accordion-button collapsed btn w-100"
            {{-- type="button" --}}
            data-bs-toggle="collapse"
            data-bs-target="#flush-{{ $id ?? 'collapseOne' }}"
            aria-expanded="true"
            aria-controls="flush-{{ $id ?? 'collapseOne' }}">
            {{ $title }}
        </button>


    </div>
    <div id="flush-{{ $id ?? 'collapseOne' }}"
        class="accordion-collapse collapse"
        aria-labelledby="flush-headingOne"
        data-bs-parent="#accordionFlushExample">

        <div class="p-2">
            {{ $slot }}
        </div>
    </div>
</div>

