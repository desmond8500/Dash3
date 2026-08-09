<div class="card">
    <div class="card-header">
        <div class="card-title">Curriculum Vitae</div>
        <div class="card-actions">
            @livewire('c-v-add', ['user_id' => $user_id])
        </div>
    </div>
    <div class="p-2">
        @foreach ($cvs as $cv)
            <div class="border p-2 mb-1 rounded">
                <div class="row align-items-center">
                    <a href="{{ route('cv',['cv_id'=>$cv->id]) }}" class="col">{{ $cv->name }}</a>
                    <div class="col-auto">
                        <button class="btn btn-primary btn-icon" >
                            <i class="ti ti-edit"></i>
                        </button>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <button class='btn btn-primary' wire:click="$dispatch('open-editCv')" ><i class='ti ti-plus'></i> Bouton</button>

    @component('components.modal', ["id"=>'editCv', 'title' => 'Titre', 'method'=>'store'])
        <form class="row" wire:submit="store">
            {{-- @include('_form.document_form') --}}
        </form>
        <script> window.addEventListener('open-editCv', event => { window.$('#editCv').modal('show'); }) </script>
        <script> window.addEventListener('close-editCv', event => { window.$('#editCv').modal('hide'); }) </script>
    @endcomponent
</div>
