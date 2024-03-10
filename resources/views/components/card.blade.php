<div class="card">
    <div class="card-header">
        <div class="card-title">{{ $title ?? '' }}</div>
        <div class="card-actions">

        </div>
    </div>
    <div class="card-body">

    </div>
    <div class="card-footer">
        @slot('footer')
            Footer
        @endslot
    </div>
</div>
