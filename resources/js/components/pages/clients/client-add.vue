<template>
    <div>
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addclient">
            Ajouter un client
        </button>

        <!-- Modal -->
        <div class="modal fade" id="addclient" tabindex="-1" aria-labelledby="addclientLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="addclientLabel">Ajouter un client</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="form-group col-sm-6">
                        <label>Nom</label>
                        <input type="text" v-model="client.name" class="form-control" required placeholder="nom de l'Entreprise ou du particulier">
                    </div>
                    <div class="form-group col-sm-6">
                        <label>logo</label>
                        <input type="file"  class="form-control">
                    </div>
                    <div class="form-group col-sm-6">
                        <label>Adresse</label>
                        <input type="text" v-model="client.address" class="form-control" placeholder="Adresse de l'Entreprise ou du particulier">
                    </div>
                    <div class="form-group col-sm-12">
                        <label>Description</label>
                        <textarea v-model="client.description"  rows="5" class="form-control" placeholder="Description de l'entreprise ou du particulier"></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                <button type="button" v-on:click='store'  class="btn btn-primary">Ajouter</button>
            </div>
            </div>
        </div>
        </div>
    </div>
</template>

<script>
export default {
        data() {
        return {
            quotes_server : 'http://quotesapi.yonkou.info/api',
            local_server : 'http://localhost:8000/api',
            client: {
                name: '',
                logo: '',
                address: '',
                description: '',
            }

        }
    },
    methods: {
        store(){
            axios.post('/projet__clients',{
                name: this.client.name,
                description: this.client.description,
                adress: this.client.address,
            })
            .then(response => {
                console.log(response.data.data);
                this.$emit('client', response);
            })
            .catch(error => console.log(error));
            this.client.name = '';
            this.client.logo = '';
            this.client.address = '';
            this.client.description = '';
        },
    }
}
</script>

<style>

</style>
