<template>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-3">
        <router-link class="navbar-brand" :to="app.link">{{ app.name }}</router-link>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item dropdown" v-for="menu in menus" :key="menu.id">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        {{ menu.name }}
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <router-link class="dropdown-item" :to="submenu.link" v-for="submenu in menu.submenu" :key="submenu.id">{{ submenu.name }}</router-link>
                    </div>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="/home" target="_blank">Home <span class="sr-only">(current)</span></a>
                </li>
            </ul>
        </div>
    </nav>
</template>

<script>
export default {
    data() {
        return{
            app: {
                name: 'Dash',
                link: '/',
                logo: ''
            },
            menus: [
                {
                    id: 1,
                    name: 'Projets',
                    link: null,
                    submenu: [
                        { id: 1, name: 'Clients', link: '/clients' },
                        { id: 2, name: 'Projets', link: '/projets' },
                        { id: 3, name: 'Devis', link: '/devis' },
                        { id: 4, name: 'Contacts', link: '/contacts' },
                        { id: 5, name: 'Documents', link: '/documents' },
                    ]
                },
                {
                    id: 2,
                    name: 'Stock',
                    link: null,
                    submenu: [
                        { id: 1, name: 'Articles', link: '/articles' },
                        { id: 2, name: 'Fournisseurs', link: '/fournisseurs' },
                    ]
                },
            ]

        }
    }
}
</script>

<style>

</style>
