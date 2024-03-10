<div class="fs-1 fw-bold">{{ $form->name }}</div>

<div class="mb-3">
    <table>
        <tr>
            <td><i class="ti ti-calendar"></i> Date expiration :</td>
            <td><div>17 janvier 2024</div> </td>
        </tr>
        <tr>
            <td><i class="ti ti-accessible"></i> Statut :</td>
            <td><div class="status status-primary"><span class="status-dot"></span> {{ $form->statut_id }}</div> </td>
        </tr>
        <tr>
            <td><i class="ti ti-accessible"></i> Priorité :</td>
            <td><div class="status status-primary"><span class="status-dot"></span> {{ $form->priority_id }}</div> </td>
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
    <div class="fs-2 mb-1 fw-bold">Liste des taches</div>

    <label class="form-check">
        <input class="form-check-input" type="checkbox">
        <span class="form-check-label">Checkbox input</span>
    </label>
    <label class="form-check">
        <input class="form-check-input" type="checkbox">
        <span class="form-check-label">Checkbox input</span>
    </label>
    <label class="form-check">
        <input class="form-check-input" type="checkbox">
        <span class="form-check-label">Checkbox input</span>
    </label>

    <div class="d-flex justify-items-center text-primary">
            <i class="ti ti-plus"></i> Ajouter une sous tache
    </div>

</div>

