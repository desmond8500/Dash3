<div>
    @livewire('form.badge-add', ['projet_id' => $projet_id])

    <div class="row">
        @foreach ($badges as $badge)
            <div class="col-md-4">
                <div class="card card-body">
                    <div>{{ $badge->prenom }} {{ $badge->nom }}</div>
                    <div>{{ $badge->fonction }}</div>

                </div>
            </div>

        @endforeach
    </div>
</div>
