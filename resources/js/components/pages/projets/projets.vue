<template>
    <div class="row">
        <div class="col-md-12">
            <breadcrumb-layout :page="page"></breadcrumb-layout>
        </div>
        <div class="col-md-12">
            <projet-add :client="client"></projet-add>
        </div>
        <div class="col-md-8">

        </div>
        <div class="col-md-4">

        </div>
    </div>
</template>

<script>
export default {
    props: ['client'],
    data(){
        return {
            page: {
                titre: 'Projets',
                breadcrumbs: [
                    { id: 1, name: 'Clients', link: '/clients'},
                    { id: 2, name: 'Projets', link: null},

                ]
            }
        }
    }
}
</script>

<style>

</style>
