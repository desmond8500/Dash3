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

/** Barre d'outils avec les icônes Tabler (chargées par la mise en page) */
function buildToolbar() {
    const button = (name, action, icon, title, extra = {}) => ({
        name,
        action,
        className: `ti ti-${icon}`,
        title,
        ...extra,
    });
    const alwaysOn = { noDisable: true };

    return [
        button('bold', EasyMDE.toggleBold, 'bold', 'Gras'),
        button('italic', EasyMDE.toggleItalic, 'italic', 'Italique'),
        button('heading', EasyMDE.toggleHeadingSmaller, 'heading', 'Titre'),
        '|',
        button('unordered-list', EasyMDE.toggleUnorderedList, 'list', 'Liste à puces'),
        button('ordered-list', EasyMDE.toggleOrderedList, 'list-numbers', 'Liste numérotée'),
        button('quote', EasyMDE.toggleBlockquote, 'quote', 'Citation'),
        button('code', EasyMDE.toggleCodeBlock, 'code', 'Code'),
        '|',
        button('link', EasyMDE.drawLink, 'link', 'Lien'),
        button('image', EasyMDE.drawImage, 'photo', 'Image'),
        button('table', EasyMDE.drawTable, 'table', 'Tableau'),
        '|',
        button('preview', EasyMDE.togglePreview, 'eye', 'Aperçu', alwaysOn),
        button('side-by-side', EasyMDE.toggleSideBySide, 'columns', 'Côte à côte', alwaysOn),
        button('fullscreen', EasyMDE.toggleFullScreen, 'arrows-maximize', 'Plein écran', alwaysOn),
        '|',
        button('guide', 'https://www.markdownguide.org/basic-syntax/', 'help', 'Aide markdown', alwaysOn),
    ];
}

function initOne(textarea) {
    if (textarea.dataset.markdownReady) return;
    textarea.dataset.markdownReady = '1';

    const model = textarea.dataset.markdownModel;
    const wireId = textarea.closest('[wire\\:id]')?.getAttribute('wire:id');

    const editor = new EasyMDE({
        element: textarea,
        spellChecker: false,
        // Font Awesome n'est pas chargé dans l'application : la barre d'outils
        // utilise les icônes Tabler (voir toolbar ci-dessous)
        autoDownloadFontAwesome: false,
        status: false,
        minHeight: textarea.dataset.markdownHeight || '180px',
        placeholder: textarea.getAttribute('placeholder') || '',
        toolbar: buildToolbar(),
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
