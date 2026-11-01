<div class="row g-2">

    <div class="col-md-12 mb-2">
        <label class="form-label">Description</label>
        <input type="text" class="form-control" wire:model="expense_description" placeholder="Description">
        @error('expense_description') <span class='text-danger'>{{ $message }}</span> @enderror
    </div>
    <div class="col-md-4 mb-2">
        <label class="form-label">Montant</label>
        <input type="number" class="form-control" wire:model="expense_amount" placeholder="Montant">
        @error('expense_amount') <span class='text-danger'>{{ $message }}</span> @enderror
    </div>
    <div class="col-md-4 mb-2">
        <label class="form-label">Date</label>
        <input type="date" class="form-control" wire:model="expense_date" >
        @error('expense_date') <span class='text-danger'>{{ $message }}</span> @enderror
    </div>

    <div class="col-md-4 mb-2">
        <label class="form-label">Methode de paiement</label>
        <select class="form-select" wire:model="expense_payment_method">
            <option value="espece">Espèce</option>
            <option value="wave">Wave</option>
            <option value="om">Orange Money</option>
            <option value="autre">Autre</option>
        </select>
        @error('expense_payment_method') <span class='text-danger'>{{ $message }}</span> @enderror
    </div>

    <div class="col-md-4 mb-2">
        <label class="form-label">Type</label>
        <select class="form-select" wire:model="expense_type">
            <option value="">Personnel</option>
            <option value="">Commune</option>
            <option value="">Professionel</option>
        </select>
        @error('expense_type') <span class='text-danger'>{{ $message }}</span> @enderror
    </div>

    <div class="col-md-4 mb-2">
        <label class="form-label">Article ID</label>
        <input type="text" class="form-control" wire:model="expense_article" placeholder="Article">
        @error('expense_article_id') <span class='text-danger'>{{ $message }}</span> @enderror
    </div>

    <div class="col-md-12 mb-2">
        <label class="form-label">Notes</label>
        <textarea class="form-control" wire:model="expense_notes" placeholder="Notes" cols="30"
            rows="3"></textarea>
        @error('expense_notes') <span class='text-danger'>{{ $message }}</span> @enderror
    </div>

    <div class="col-md-12">
        <div class="row g-2">
            <div class="col-12">
                <div class="col-md-12 mb-3">
                    <input type="text" class="form-control" wire:model="article_search" placeholder="Rechercher" wire:keydown.enter="get_articles()">
                    @error('article_search') <span class='text-danger'>{{ $message }}</span> @enderror
                </div>
            </div>


            @foreach ($articles as $article)
                <div class="col-md-2 mx-auto" wire:click="select_article({{ $article->id }})" style="cursor: pointer;">
                    <img src="{{ asset($article->image) }}" alt="img" class="img-fluid rounded mb-2" style="max-height: 100px;">
                    <div class="text-center fs-6">{{ $article->designation }}</div>

                </div>
            @endforeach
        </div>
    </div>


</div>
