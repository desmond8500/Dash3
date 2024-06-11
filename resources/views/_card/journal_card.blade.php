<div class="card p-2">
    <div class="row">
      <div class="col">
        <div>
            @isset($journal->projet)
                <span style="font-size: 10px;" class="text-purple">{{ $journal->projet->client->name }} / </span>
                <span style="font-size: 10px;" class="text-purple">{{ $journal->projet->name }}</span>
            @endisset
        </div>
        <a class="fw-bold text-dark" href="{{ route('journal',['journal_id'=>$journal->id]) }}">
            {{ $journal->title }}
        </a>
        <div class="text-primary" style="font-size: 10px;">{{ $journal->date }}</div>

      </div>
      <div class="col-auto">
        <div class="dropdown">
            <button class="btn btn-action border dropdown-toggle" type="button" id="triggerId" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
                <i class="ti ti-dots-vertical"></i>
            </button>
            <div class="dropdown-menu" aria-labelledby="triggerId">
                <button class="dropdown-item" wire:click="edit_journal('{{ $journal->id }}')"><i class="ti ti-edit me-2"></i> Editer</button>
                <button class="dropdown-item disabled "><i class="ti ti-trash me-2"></i>Supprimer</button>
            </div>
        </div>
      </div>
      <div class="col-md-12">
        <div class="text-muted">{!! nl2br($journal->description) !!}</div>
      </div>
    </div>
</div>
