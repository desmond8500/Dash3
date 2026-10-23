import './bootstrap';

import $ from 'jquery';
window.$ = window.jQuery = $;

// Bootstrap : une seule instance, exposée en global
import * as bootstrap from 'bootstrap';
window.bootstrap = bootstrap;

['Modal', 'Dropdown', 'Tooltip', 'Popover', 'Collapse', 'Tab', 'Toast', 'Offcanvas']
    .forEach((name) => {
        $.fn[name.toLowerCase()] = function (config) {
            return this.each(function () {
                const instance = bootstrap[name].getOrCreateInstance(
                    this,
                    typeof config === 'object' ? config : {}
                );
                if (typeof config === 'string') {
                    if (typeof instance[config] !== 'function') {
                        throw new TypeError(`Méthode "${config}" inconnue pour ${name}`);
                    }
                    instance[config]();
                }
            });
        };
    });

// Tabler embarque Bootstrap : ne PAS importer 'bootstrap' en plus
// import '@tabler/core/dist/js/tabler.min.js';
// Vérifiez dans la console : window.bootstrap doit exister

import 'select2';
import 'select2/dist/css/select2.css';
import lightbox from 'lightbox2';
import 'lightbox2/dist/css/lightbox.css';
import Swal from 'sweetalert2';
window.Swal = Swal;

// --- Init des composants à initialiser à la main ---
function initBootstrapComponents() {
    document.querySelectorAll('[data-bs-toggle="tooltip"]')
        .forEach(el => bootstrap.Tooltip.getOrCreateInstance(el));
    document.querySelectorAll('[data-bs-toggle="popover"]')
        .forEach(el => bootstrap.Popover.getOrCreateInstance(el));
    // Select2 si besoin :
    // $('.select2').select2({ dropdownParent: $('.modal.show').length ? $('.modal.show') : $(document.body) });
}

// --- Nettoyage avant de quitter la page ---
document.addEventListener('livewire:navigating', () => {
    document.querySelectorAll('.tooltip, .popover').forEach(el => el.remove());
    document.querySelectorAll('.modal.show').forEach(m =>
        bootstrap.Modal.getInstance(m)?.hide());
    document.querySelectorAll('.modal-backdrop').forEach(b => b.remove());
    document.body.classList.remove('modal-open');
    document.body.style.removeProperty('overflow');
    document.body.style.removeProperty('padding-right');
});

document.addEventListener('livewire:navigated', initBootstrapComponents);

// --- Ouvrir/fermer les modals depuis Livewire ---
document.addEventListener('livewire:init', () => {
    Livewire.on('open-modal', ({ id }) =>
        bootstrap.Modal.getOrCreateInstance(document.getElementById(id)).show());
    Livewire.on('close-modal', ({ id }) =>
        bootstrap.Modal.getInstance(document.getElementById(id))?.hide());

    // Réinitialiser après chaque requête Livewire
    Livewire.hook('commit', ({ succeed }) => {
        succeed(() => queueMicrotask(initBootstrapComponents));
    });
});