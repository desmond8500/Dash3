require('./bootstrap');

window.Vue = require('vue');
import VueRouter from "vue-router";
Vue.use(VueRouter);

import Index from "./components/pages/index/index.vue";
import Clients from "./components/pages/clients/clients.vue";
import Projets from "./components/pages/projets/projets.vue";
import Devis from "./components/pages/devis/devis.vue";
import Contacts from "./components/pages/clients/contacts.vue";
import Documents from "./components/pages/projets/documents.vue";
import Articles from "./components/pages/stock/articles.vue";
import Fournisseurs from "./components/pages/stock/fournisseurs.vue";

const routes = [
    { path: "/", component: Index },
    { path: "/clients", component: Clients },
    { path: "/projets", component: Projets, name: "Projets", props: true },
    { path: "/devis", component: Devis },
    { path: "/contacts", component: Contacts },
    { path: "/documents", component: Documents },
    { path: "/articles", component: Articles },
    { path: "/fournisseurs", component: Fournisseurs },
];

// Layouts
Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('navbar-layout', require('./components/layout/navbar.vue').default);
Vue.component('breadcrumb-layout', require('./components/layout/component/breadcrumb.vue').default);

// Composannts
Vue.component('client', require('./components/pages/clients/client.vue').default);
Vue.component('client-add', require('./components/pages/clients/client-add.vue').default);

const router = new VueRouter({ routes });

const app = new Vue({
    el: "#app",
    router: router,
});

