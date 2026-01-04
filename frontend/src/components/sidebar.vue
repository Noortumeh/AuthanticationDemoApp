<script setup>
import { computed } from "vue";
import { RouterLink, useRoute } from "vue-router";

const route = useRoute();

const navigation = computed(() => [
  { name: "Home", href: "/dashboard", current: route.path === "/dashboard" },
  {
    name: "Users",
    href: "/dashboard/users",
    current: route.path === "/dashboard/users" || route.path.includes("user"),
  },
]);
</script>

<template>
  <div
    class="flex h-screen w-2xs flex-col justify-between border-e border-gray-100 bg-white"
  >
    <div class="px-4 py-6">
      <ul class="mt-6 space-y-1">
        <li>
          <RouterLink
            v-for="item in navigation"
            :key="item.name"
            :to="item.href"
            :class="[
              item.current ? 'bg-gray-100' : '',
              'block rounded-lg px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-500/20 ',
            ]"
            :aria-current="item.current ? 'page' : undefined"
            >{{ item.name }}
          </RouterLink>
        </li>
      </ul>
    </div>
  </div>
</template>
