<template>
    <div class="row">
        <div class="col-md-12">
            <breadcrumb-layout :page="page"></breadcrumb-layout>
        </div>
        <div class="col-md-4 mb-2">
            <client-add @client="getClient"></client-add>
        </div>
        <div class="col-md-8 mb-2">
            <!-- <div class="form-group">
                <input type="text" class="form-control">
            </div> -->
            <form class="form-inline my-2 my-lg-0 float-right">
                <input class="form-control mr-sm-2" type="search" placeholder="Rechercher un client" aria-label="Search">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Rechercher</button>
            </form>
        </div>
        <div class="col-md-12">
            <client :clients="clients"></client>
        </div>
    </div>
</template>

<script>

export default {
    data() {
        return {
            clients: [],
            page: {
                titre: 'Clients',
                breadcrumbs: [
                    { id: 1, name: 'Clients', link: '/clients'},
                ]
            }
        }
    },
    created(){
        axios.get('/projet__clients')
            .then(response => {
                this.clients = response.data.data;
                // console.log(this.clients);
                }
            )
            .catch(error => console.log(error)
            );
    },
    methods: {
        store(){
            axios.post('http://localhost:8000/api/tests',{
                prenom: this.prenom,
                nom: this.nom
            })
            .then(response => console.log(response))
            .catch(error => console.log(error));
        },

        getClient(client){
            this.clients = [...this.clients, client.data.data]

            // console.log(client.data);
            // console.log(this.clients);
        }
    }

}
</script>

<style>

</style>
