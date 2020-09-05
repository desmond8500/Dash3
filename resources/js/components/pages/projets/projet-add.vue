<template>
    <div>
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addProject">
            Ajouter un projet
        </button>

        <!-- Modal -->
        <div class="modal fade" id="addProject" tabindex="-1" aria-labelledby="addProjectLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="addProjectLabel">Ajouter un projet</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="form-group col-sm-12">
                        <h3>Client</h3>
                        {{client.name}}
                    </div>
                    <div class="form-group col-sm-6">
                        <label>Nom</label>
                        <input type="text" v-model="projet.nom" class="form-control" placeholder="Nom du projet" required>
                    </div>
                    <div class="form-group col-sm-6">
                        <label>Statut</label>
                        <select v-model="projet.statut" class="form-control">
                            <option>Nouveau</option>
                            <option>En cours</option>
                            <option>En pause</option>
                            <option>Annulé</option>
                            <option>Terminé</option>
                        </select>
                    </div>
                    <div class="form-group col-sm-6">
                        <label>Catégorie</label>
                        <v-select multiple taggable push-tags  :options="['Canada','United States']" />
                        {{ projet.categorie }}

                        <v-select :options="options" multiple taggable push-tags v-model="projet.categorie" :reduce="country => country.code" label="country" />

                    </div>
                    <div class="form-group col-sm-12">
                        <label>Description</label>
                        <textarea v-model="projet.description" placeholder="Description du projet" rows="5" class="form-control"></textarea>
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
    props: ['client'],
        data() {
        return {
            projet: {
                client_id: '',
                statut: '',
                name: '',
                description: '',
                categorie: '',
                start: '',
                end: '',
                contact_id: ''
            },
            options : [{code: 'CA', country: 'Canada'}]

        }
    },
    methods: {
        store(){
            axios.post('/projet__clients',{
                client_id: this.client.id,
                name: this.projet.name,
                description: this.projet.description,
                categorie: this.projet.categorie,
                statut: this.projet.statut,
                start: this.projet.start,
                end: this.projet.end,
                contact_id: this.projet.contact_id,
                responsable_id: this.projet.responsable_id,
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
