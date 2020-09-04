<template>
    <div>
        <breadcrumb-layout :page="page"></breadcrumb-layout>
    </div>
</template>

<script>
export default {
    data() {
        return {
            clients: null,
            page: {
                titre: 'Dashboard',
                breadcrumbs: [
                    { id: 1, name: 'Clients', link: '/clients'}
                ]
            }
        }
    },

}
</script>

<style>

</style>
