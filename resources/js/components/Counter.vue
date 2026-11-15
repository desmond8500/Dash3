<template>
  <div class="p-4">
    <p>Compteur : {{ count }}</p>

    <button @click="count++" class="btn btn-primary">
      Incrémenter
    </button>
  </div>
</template>

<script setup>
import { ref } from 'vue';

const count = ref(0);
</script>
