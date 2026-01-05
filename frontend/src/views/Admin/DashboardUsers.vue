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
    <div
      class="flex items-center border pl-4 gap-2 border-gray-500/30 h-[46px] rounded-full overflow-hidden max-w-md w-full"
    >
      <svg
        xmlns="http://www.w3.org/2000/svg"
        width="22"
        height="22"
        viewBox="0 0 30 30"
        fill="#6B7280"
      >
        <path
          d="M13 3C7.489 3 3 7.489 3 13s4.489 10 10 10a9.95 9.95 0 0 0 6.322-2.264l5.971 5.971a1 1 0 1 0 1.414-1.414l-5.97-5.97A9.95 9.95 0 0 0 23 13c0-5.511-4.489-10-10-10m0 2c4.43 0 8 3.57 8 8s-3.57 8-8 8-8-3.57-8-8 3.57-8 8-8"
        />
      </svg>
      <input
        type="text"
        v-on:keyup="search($event.target.value)"
        placeholder="Search"
        class="w-full h-full outline-none text-gray-500 bg-transparent placeholder-gray-500 text-sm"
      />
    </div>
    <Table
      v-if="filter.length"
      :data="filter"
      :columns="columns"
      :actions="actions"
    />
    <div
      v-else-if="users.length === 0"
      class="mt-5 px-3 py-1.5 mr-1 w-1/2 whitespace-nowrap text-center bg-red-300 rounded-2xl"
    >
      <p>No Users Data Items</p>
    </div>
    <div
      v-else-if="filter.length === 0"
      class="mt-5 px-3 py-1.5 mr-1 w-1/2 whitespace-nowrap text-center bg-red-300 rounded-2xl"
    >
      <p>No Users Data Items classified with your search</p>
    </div>
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

const filter = ref([]);
const searchBarInput = ref();

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
    filter.value = users.value;
    console.log("Users data fetched:", users.value);
  } catch (err) {
    console.error("Failed to fetch Users", err);
    toast.error("Failed to fetch Usres data. Please try again.");
    return;
  }
});

function search(input) {
  if (!users) {
    return;
  }
  const usersRows = users.value;
  filter.value = [];
  for (let i = 0; i < usersRows.length; i++) {
    if (usersRows[i].name.toUpperCase().indexOf(input.toUpperCase()) > -1) {
      filter.value.push(usersRows[i]);
    }
  }
  console.log(filter.value);
}
</script>
