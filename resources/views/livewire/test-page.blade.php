<div class="row mt-3">
    <div class="col-md-9">
        {{-- <div>
            @livewire('modal')
        </div> --}}

        <div >
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/easymde/dist/easymde.min.css">
            <script src="https://cdn.jsdelivr.net/npm/easymde/dist/easymde.min.js"></script>

            <textarea id="markdown-editor" wire:model.debounce.500ms="content"></textarea>

            <button class="btn btn-primary" wire:click="get()">Button</button>
            <script>
                // const easyMDE = new EasyMDE();
                const easyMDE = new EasyMDE({element: document.getElementById('markdown-editor')});

                easyMDE.codemirror.on("change", () => {
                    console.log(easyMDE.value());
                    // @this.set('content', editor.value());
                    // Livewire.on('contentUpdated', () => {
                    //     editor.value(@this.get('content'));
                    // });
                });
            </script>

            <div class="card p-2">
                {{ $content }}
            </div>

            {{-- <textarea id="markdown-editor" wire:model.debounce.500ms="content"></textarea> --}}

            {{-- <script>
                document.addEventListener('livewire:load', () => {
                    const editor = new EasyMDE({
                        element: document.getElementById('markdown-editor'),
                        autoDownloadFontAwesome: false,
                    });

                    // Synchronisation entre EasyMDE et Livewire
                    editor.codemirror.on('change', () => {
                        @this.set('content', editor.value());
                    });

                    // Si Livewire met à jour le contenu, synchroniser avec l'éditeur
                    Livewire.on('contentUpdated', () => {
                        editor.value(@this.get('content'));
                    });
                });
            </script> --}}
        </div>



        <div class="row">
            @foreach ($widgets as $widget)
                @if ($widget->type == "include")
                    <a href="{{ $widget->link }}" target="_blank" class="{{ $widget->class }}">
                        @includeWhen($widget->id == $selected_widget, $widget->view )
                    </a>
                @elseif($widget->type == "livewire")
                    @if ($widget->id == $selected_widget)
                        @livewire($widget->view)
                    @endif
                @endif
            @endforeach
        </div>
    </div>

    <div class="col-md-3">
        <div class="card">
            <div class="card-header">
                <div class="card-title">Liste des Widgets</div>
                <div class="card-actions">

                </div>
            </div>
            <div class="card-body">
                <div class="btn-list">
                    @foreach ($widgets as $widget)
                        <a class="btn" wire:click="$set('selected_widget', '{{ $widget->id }}')">{{ $widget->name }}</a>
                    @endforeach
                </div>
            </div>
            <div class="card-footer">

            </div>
        </div>
    </div>

</div>


