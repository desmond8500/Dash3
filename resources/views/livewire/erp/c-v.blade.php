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
</div>
