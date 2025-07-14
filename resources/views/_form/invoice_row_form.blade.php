<div class="row">
    <div class="col-md-8 mb-3">
        <div class="mb-3">
            <label class="form-label">Désignation</label>
            <input type="text" class="form-control" wire:model="row_form.designation" placeholder="Désignation de l'article">
            @error('row_form.designation') <span class='text-danger'>{{ $message }}</span> @enderror
        </div>

        <div class=" mb-3">
            <label class="form-label">Référence</label>
            <textarea class="form-control" wire:model="row_form.reference" placeholder="Référence de l'article" data-bs-toggle="autosize"></textarea>
            @error('row_form.reference') <span class='text-danger'>{{ $message }}</span> @enderror
        </div>
        <div class="mb-3">
            <label class="form-label">Quantité achetés</label>
            <input type="number" class="form-control" wire:model="row_form.bought" placeholder="Quantité achetée">
            @error('row_form.bought') <span class='text-danger'>{{ $message }}</span> @enderror
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label">Quantité</label>
                <input type="number" class="form-control" wire:model="row_form.quantite" placeholder="Quantité">
                @error('row_form.quantite') <span class='text-danger'>{{ $message }}</span> @enderror
            </div>
            <div class="col-md-6">
                <label class="form-label">Coef</label>
                <div class="input-group">
                    <input type="number" class="form-control" wire:model="row_form.coef" placeholder="Coféficient de marge">
                    <a class="btn btn-primary btn-icon" wire:click="$set('row_form.coef', 1)">
                        <i class="ti ti-x"></i>
                    </a>
                </div>
                @error('row_form.coef') <span class='text-danger'>{{ $message }}</span> @enderror
            </div>
        </div>

        <label class="form-label">Prix</label>
        <div class="input-group">
            <input type="number" class="form-control" wire:model="row_form.prix" placeholder="Prix de l'article">
            <a class="btn btn-secondary btn-icon" wire:click="$set('row_form.prix', 0)">
                <i class="ti ti-x"></i>
            </a>
        </div>
        @error('row_form.prix') <span class='text-danger'>{{ $message }}</span> @enderror

        <label class="form-label">Priorite</label>
        <select class="form-control" wire:model="row_form.priorite_id">
            <option value="0">Centrale 1</option>
            <option value="1">Centrale 2</option>
            <option value="2">Organe 1</option>
            <option value="3">Organe 2</option>
            <option value="4">Organe 3</option>
            <option value="5">Cable</option>
            <option value="6">Accessoires</option>
            <option value="7">Forfait</option>
        </select>
        @error('row_form.priorite_id') <span class='text-danger'>{{ $message }}</span> @enderror

        <label class="form-label">ID Article</label>
        <div class="input-group">
            <input type="number" class="form-control" wire:model="row_form.article_id" placeholder="Identifiant de l'article">
            <a class="btn btn-secondary btn-icon" wire:click="$set('row_form.article_id', 0)">
                <i class="ti ti-x"></i>
            </a>
        </div>
        @error('row_form.article_id') <span class='text-danger'>{{ $message }}</span> @enderror

        @if(!$nosection)
            <label class="form-label">Section</label>
            <select class="form-control" wire:model="row_form.invoice_section_id">
                @foreach ($sections as $section)
                    <option value="{{ $section->id }}">{{ $section->section }}</option>
                @endforeach
            </select>
            @error('row_form.invoice_section_id') <span class='text-danger'>{{ $message }}</span> @enderror

        @endif
    </div>

</div>

