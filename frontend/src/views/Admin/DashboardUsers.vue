<template>
  <div class="p-6">
    <div class="flex content-center justify-between">
      <h1 class="text-2xl font-bold mb-4">Users Management</h1>
      <RouterLink
        to="/dashboard/add-new-user"
        class="bg-blue-500 hover:bg-blue-400 text-white rounded-md px-3 py-3 h-1/2 text-sm font-medium"
      >
        Add New User
      </RouterLink>
    </div>
    <Table v-if="users.length" :data="users" :columns="columns" :actions="actions" />
    <p v-else>Loading users...</p>
  </div>
</template>

<script setup>
import Table from "@/components/Table.vue";
import { ref, onMounted } from "vue";
import { useToast } from "vue-toastification";

// Sample data - replace with actual API call
const users = ref([]);
const toast = useToast();

const columns = [
  { key: "id", label: "ID" },
  { key: "name", label: "Name" },
  { key: "email", label: "Email" },
  { key: "role", label: "Role" },
];
const actions = true;
const token = localStorage.getItem("token");

onMounted(async () => {
  try {
    const res = await fetch("http://127.0.0.1:8000/api/admin/users", {
      method: "GET",
      headers: {
        "Content-Type": "application/json",
        Accept: "application/json",
        Authorization: `Bearer ${token}`,
      },
    });
    users.value = await res.json();
    console.log("Users data fetched:", users.value);
  } catch (err) {
    console.error("Failed to fetch Users", err);
    toast.error("Failed to fetch Usres data. Please try again.");
    return;
  }
});
</script>
