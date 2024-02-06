<div class="card p-2 border border-primary" wire:click="set_stage('{{ $stage->id }}')">
    <div class="row">
        <div class="col-auto">
            <img src="" alt="{{ $stage->order }}" class="avatar ">
        </div>

        <div class="col cursor-pointer">
            <div class="fw-bol">{{ $stage->name }}</div>
            <div class="text-muted">{{ nl2br($stage->description) }}</div>
        </div>
        <div class="col-auto text-end">
            <div>
                <span>{{ $stage->rooms->count() }}</span>
                <span>@if ($stage->rooms->count() < 2) Local @else Locaux @endif</span>
            </div>

            <div>
                <a href="{{ route('stage',['stage_id'=>$stage->id]) }}">Détails</a>
            </div>
        </div>
    </div>
</div>
