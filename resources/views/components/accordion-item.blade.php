<div class="accordion-item ">
    <h2 class="accordion-header" id="flush-headingOne">
        <button class="accordion-button collapsed p-2"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#flush-{{ $id ?? 'collapseOne' }}"
            aria-expanded="true"
            aria-controls="flush-{{ $id ?? 'collapseOne' }}">
            {{ $title ?? 'title' }}
        </button>
    </h2>
    <div id="flush-{{ $id ?? 'collapseOne' }}"
        class="accordion-collapse collapse"
        aria-labelledby="flush-headingOne"
        data-bs-parent="#accordionFlushExample">

        <div class="accordion-body">
            {{ $slot }}
        </div>
    </div>
</div>
