<div class="card p-2">
    <div class="row g-2">
        @php $date = new Carbon\Carbon($journal->date); @endphp

        <div class="col-auto text-primary">
            <div class="text-center border border-info rounded p-1" style="width: 70px">
                <div class="fw-bold text-muted" style="font-size: 10px">{{ ucfirst($date->dayName) }}</div>
                <div class="fw-bold">{{ ucfirst($date->shortMonthName) }}</div>
                <div class="display-6">{{ $date->format('d') }}</div>
                <div class="fw-bold">{{ $date->format('Y')}}</div>
            </div>
        </div>
        <div class="col">
            <div class="row">
                <div class="col-md-12">
                  <div>
                      @isset($journal->projet)
                          <a href="{{ route('projets',['client_id'=> $journal->projet->client->id]) }}" style="font-size: 11px;" class="text-primary">{{ $journal->projet->client->name }} / </a>
                          <a href="{{ route('projet',['projet_id'=> $journal->projet->id]) }}" style="font-size: 11px;" class="text-primary">{{ $journal->projet->name }}</a>
                      @endisset
                  </div>
                  <a class="fw-bold text-dark" href="{{ route('journal',['journal_id'=>$journal->id]) }}">
                      {{ $journal->title }}
                  </a>
                </div>
                <div class="col-md-12">
                    {{-- <div class="text-muted ">{!! nl2br($journal->description) !!}</div> --}}
                    <div class="text-muted">
                        {{ $journal->type ?? "Rapport d'intervention" }}
                    </div>
                </div>

            </div>
        </div>
      <div class="col-auto">
        <div class="dropdown">
            <button class="btn btn-action border dropdown-toggle" type="button" id="triggerId" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
                <i class="ti ti-dots-vertical"></i>
            </button>
            <div class="dropdown-menu" aria-labelledby="triggerId">
                <button class="dropdown-item" wire:click="edit_journal('{{ $journal->id }}')"><i class="ti ti-edit me-2"></i> Editer</button>
                <button class="dropdown-item" wire:click="select('{{ $journal->id }}')"><i class="ti ti-eye me-2"></i> Consulter</button>
                <a class="dropdown-item" target="_blank" href="{{ route('journal_pdf',['journal_id'=>$journal->id]) }}"><i class="ti ti-file-type-pdf me-2"></i> PDF</a>
                <button class="dropdown-item text-danger" wire:click="delete_journal('{{ $journal->id }}')" wire:confirm='Etes-vous sur de vouloir supprimer ce journal'><i class="ti ti-trash me-2"></i>Supprimer</button>
            </div>
        </div>
      </div>

    </div>
</div>
