import EasyMDE from 'easymde';
import 'easymde/dist/easymde.min.css';

/**
 * Éditeur markdown (EasyMDE) pour les textarea `data-markdown-editor`.
 *
 * Le textarea doit être placé dans un conteneur `wire:ignore` : EasyMDE
 * remplace le champ par CodeMirror, que Livewire ne doit pas re-rendre.
 * La valeur est renvoyée à la propriété Livewire nommée par
 * `data-markdown-model`, sans déclencher de rendu (set(..., false)).
 *
 * Pour remplir l'éditeur depuis PHP (édition), le composant envoie :
 *   $this->dispatch('markdown-editor-set', id: 'ma-zone', value: $texte);
 */
const editors = new Map();

function initOne(textarea) {
    if (textarea.dataset.markdownReady) return;
    textarea.dataset.markdownReady = '1';

    const model = textarea.dataset.markdownModel;
    const wireId = textarea.closest('[wire\\:id]')?.getAttribute('wire:id');

    const editor = new EasyMDE({
        element: textarea,
        spellChecker: false,
        autoDownloadFontAwesome: false,
        status: false,
        minHeight: textarea.dataset.markdownHeight || '180px',
        placeholder: textarea.getAttribute('placeholder') || '',
        toolbar: [
            'bold', 'italic', 'heading', '|',
            'unordered-list', 'ordered-list', 'quote', 'code', '|',
            'link', 'table', '|',
            'preview', 'side-by-side', 'fullscreen', '|', 'guide',
        ],
    });

    if (textarea.id) editors.set(textarea.id, editor);

    if (model && wireId) {
        let timer;
        editor.codemirror.on('change', () => {
            clearTimeout(timer);
            timer = setTimeout(() => {
                // false : la propriété est mise à jour sans re-rendre le composant
                window.Livewire.find(wireId)?.set(model, editor.value(), false);
            }, 300);
        });
    }
}

export function initMarkdownEditors() {
    document.querySelectorAll('textarea[data-markdown-editor]').forEach(initOne);
}

/** Remplit un éditeur depuis Livewire (ouverture d'un formulaire d'édition) */
function setValue(id, value) {
    const editor = editors.get(id);
    if (editor) editor.value(value ?? '');
}

document.addEventListener('livewire:init', () => {
    initMarkdownEditors();
    window.Livewire.on('markdown-editor-set', (payload) => {
        const { id, value } = Array.isArray(payload) ? payload[0] : payload;
        setValue(id, value);
    });
    window.Livewire.hook('commit', ({ succeed }) => {
        succeed(() => queueMicrotask(initMarkdownEditors));
    });
});

document.addEventListener('livewire:navigated', () => {
    editors.clear();
    initMarkdownEditors();
});
