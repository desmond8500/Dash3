<div class="card" wire:ignore>
    <div class="card-body">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/trix/1.3.1/trix.min.css" />

        <div >
            <input id="ref" type="hidden" name="content" value="{{ $content }}">
            <trix-editor input="ref" x-on:trix-change="$wire.content = $event.target.value" ></trix-editor>
            <button class="btn btn-primary mt-2" wire:click="$parent.trix_save('{{ $content }}')">Valider</button>
        </div>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/trix/1.3.1/trix.min.js"></script>

    </div>
</div>
