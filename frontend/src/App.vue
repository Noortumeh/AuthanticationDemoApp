<script setup>
import { RouterView } from 'vue-router';
import Navbar from './components/navbar.vue';
</script>

<template>
  <!-- to get the view from router we use this: -->
   <!-- and we use RouterLink for links -->
  <!-- <RouterView /> -->
  <Navbar />
  <main>
    <RouterView />
  </main>
</template>
