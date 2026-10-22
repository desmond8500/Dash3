
import './bootstrap';
import * as bootstrap from 'bootstrap';

import $ from 'jquery';
window.$ = window.jQuery = $;

// Activer le plugin jQuery de Bootstrap
bootstrap.Modal.jQueryInterface &&
    ($.fn.modal = bootstrap.Modal.jQueryInterface);

// Bootstrap et Tabler
window.bootstrap = bootstrap;
import '@tabler/core/dist/js/tabler.min.js';

// Lightbox2
import lightbox from 'lightbox2';
import 'lightbox2/dist/css/lightbox.css';

// Select2
import 'select2';
import 'select2/dist/css/select2.css';

// SweetAlert2
import Swal from 'sweetalert2';
window.Swal = Swal;
