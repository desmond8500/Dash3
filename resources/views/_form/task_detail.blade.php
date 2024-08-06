<div class="d-flex justify-content-between">
    <div class="fs-1 fw-bold">
        {{ $form->name }}</div>
    <button class="btn btn-icon" wire:click="edit('{{ $form->id }}')">
        <i class="ti ti-edit"></i>
    </button>
</div>

<div class="mb-3">
    <table>
        <tr>
            <td><i class="ti ti-calendar"></i> Date expiration :</td>
            <td><div>17 janvier 2024</div> </td>
        </tr>
        <tr>
            <td><i class="ti ti-accessible"></i> Statut :</td>
            <td><div class="status status-primary"><span class="status-dot"></span> {{ $task->statut->name }}</div> </td>
        </tr>
        <tr>
            <td><i class="ti ti-accessible"></i> Priorité :</td>
            <td><div class="status status-primary"><span class="status-dot"></span> {{ $task->priority->name }}</div> </td>
        </tr>
    </table>
</div>


<div class="mb-3">
    <div class="fs-2 fw-bold">Description</div>
    <div class="text-justify">
        {!! nl2br($form->description) !!}
    </div>
</div>

<div class="mb-3">
    <div class="fs-2 mb-1 fw-bold">
        <div class="d-flex justify-content-between">
            <div>Liste des sous taches</div>
            <button class="btn btn-primary btn-sm rounded" wire:click="show_subtask_form(true)">
                <i class="ti ti-plus"></i> Sous Tache
            </button>
        </div>
    </div>

    @if ($show_subtask_bool)
        <form class="row border rounded m-1 p-2" wire:submit="subtask_store">
            <div class="col-md-12 mb-3">
                <label class="form-label">Titre</label>
                <input type="text" class="form-control" wire:model="subtask_form.name" placeholder="Titre">
                @error('subtask_form.name') <span class='text-danger'>{{ $message }}</span> @enderror
            </div>

            <div class="col-md-4 mb-3">
                <label class="form-label">Status</label>
                <select class="form-control" wire:model="subtask_form.statut_id">
                    @foreach ($statuses as $status)
                        <option value="{{ $status->level }}">{{ $status->name }}</option>
                    @endforeach
                </select>
                @error('subtask_form.status_id') <span class='text-danger'>{{ $message }}</span> @enderror
            </div>

            <div class="col-md-8 modal-footer">
                <button type="button" class="btn btn-secondary mt-3" data-bs-dismiss="modal">Fermer</button>
                <button type="submit" class="btn btn-primary mt-3">Valider</button>
            </div>
        </form>
    @endif

    @foreach ($subtasks as $subtask)
        <label class="form-check d-flex justify-content-between align-items-center">
            <div>
                <input class="form-check-input" type="checkbox">
                <span class="form-check-label">{{ $subtask->name }}</span>
            </div>
            <a class="btn btn-outline-danger btn-sm rounded" wire:click="subtask_delete('{{ $subtask->id }}')">
                <i class="ti ti-trash"></i>
            </a>
        </label>
    @endforeach



    <div class="d-flex justify-items-center text-primary" wire:click="show_subtask_form(true)">
            <i class="ti ti-plus"></i> Ajouter une sous tache
    </div>

</div>

