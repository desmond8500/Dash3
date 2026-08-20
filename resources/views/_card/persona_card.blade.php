<div class="card h-100 d-flex flex-column">
    <img src="{{ $persona->avatar ? asset($persona->avatar) : asset('img/icons/004-user.png') }}"
        class="card-img-top p-2" alt="{{ $persona->firstname }}">

    <div class="card-body d-flex flex-column text-center">
        <h3 class="mb-0">{{ $persona->firstname }}</h3>
        <div class="text-secondary mb-2">{{ $persona->lastname }}</div>

        @if($persona->description)
        <p class="text-secondary small ">
            {{ Str::limit($persona->description, 80) }}
        </p>
        @endif

        <!-- Les boutons restent en bas -->
        <div class="mt-auto d-flex justify-content-between pt-3">
            <a href="{{ route('persona', ['persona_id' => $persona->id]) }}" class="btn btn-icon btn-primary">
                <i class="ti ti-eye"></i>
            </a>

            <button wire:click="edit('{{ $persona->id }}')" class="btn btn-icon btn-warning" type="button">
                <i class="ti ti-edit"></i>
            </button>
            <button wire:click="delete('{{ $persona->id }}')" class="btn btn-icon btn-danger" type="button">
                <i class="ti ti-trash"></i>
            </button>
        </div>
    </div>
</div>
