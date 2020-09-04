<template>
    <div class="row">
        <div class="col-md-8">
            <h2>{{ page.titre }}</h2>
        </div>
        <div class="col-md-4">
            <div class="float-right">
                <nav aria-label="breadcrumb mt-3  ">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><router-link to="/">Accueil</router-link></li>
                        <li class="breadcrumb-item" v-for="breadcrumb in page.breadcrumbs" :key="breadcrumb.id"><router-link :to="breadcrumb.link">{{ breadcrumb.name }}</router-link></li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ['page']
}
</script>

<style>

</style>
