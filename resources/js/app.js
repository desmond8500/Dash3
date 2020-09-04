require('./bootstrap');

window.Vue = require('vue');
import VueRouter from "vue-router";
Vue.use(VueRouter);

import Clients from "./components/pages/clients/clients.vue";
import Projets from "./components/pages/projets/projets.vue";
import Devis from "./components/pages/devis/devis.vue";
import Contacts from "./components/pages/clients/contacts.vue";
import Documents from "./components/pages/projets/documents.vue";
import Articles from "./components/pages/stock/articles.vue";
import Fournisseurs from "./components/pages/stock/fournisseurs.vue";

const routes = [
    { path: "/clients", component: Clients },
    { path: "/projets", component: Projets },
    { path: "/devis", component: Devis },
    { path: "/contacts", component: Contacts },
    { path: "/documents", component: Documents },
    { path: "/articles", component: Articles },
    { path: "/fournisseurs", component: Fournisseurs },
];


Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('navbar-layout', require('./components/layout/navbar.vue').default);


const router = new VueRouter({ routes });

const app = new Vue({
    el: "#app",
    router: router,
});
