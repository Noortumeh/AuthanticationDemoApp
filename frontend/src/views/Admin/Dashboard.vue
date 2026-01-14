<script setup>
import Sidebar from "@/components/sidebar.vue";
import { RouterView } from "vue-router";

const token = localStorage.getItem("token");
const role = localStorage.getItem("roel");

if (!token || !role === "admin") {
  window.location.href = "/login";
}
</script>

<template>
  <div class="flex">
    <Sidebar />
    <main class="flex-1">
      <RouterView />
    </main>
  </div>
</template>
