<template>
    <div class="row">
        <div class="col-md-3 mb-2" v-for="client in clients" :key="client.id">
            <div class="card" style="width: 18rem;" >

                <router-link class="link" :to="{ name: 'Projets', params: {client} }">
                    <img src=" " class="card-img-top" alt=" ">
                    <div class="card-body">
                        <h5 class="card-title">{{ client.name }}</h5>
                        <p class="card-text">{{ client.description }}</p>
                    </div>
                </router-link>

                <!-- <ul class="list-group list-group-flush">
                    <li class="list-group-item">Cras justo odio</li>
                    <li class="list-group-item">Dapibus ac facilisis in</li>
                    <li class="list-group-item">Vestibulum at eros</li>
                </ul>
                <div class="card-body">
                    <a href="#" class="card-link">Card link</a>
                    <a href="#" class="card-link">Another link</a>
                </div> -->
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ['clients']
}
</script>

<style scoped>
    .link{
        text-decoration: none;
        color: black;
    }
</style>
