<script setup>
import { useToast } from "vue-toastification";
import ConfirmDialog from "./ConfirmDialog.vue";
import { ref } from "vue";

const showConfirm = ref(false);
const deleteId = ref(null);
const props = defineProps({
  columns: {
    type: Array,
    required: true,
  },
  data: {
    type: Array,
  },
  actions: {
    type: Boolean,
  },
  loading: {
    type: Boolean,
    default: false,
  },
});

const toast = useToast();
const token = localStorage.getItem("token");

const handleDeleteUser = async () => {
  showConfirm.value = false
  try {
    const res = await fetch(`http://127.0.0.1:8000/api/admin/user/${deleteId.value}`, {
      method: "DELETE",
      headers: {
        "Content-Type": "application/json",
        Accept: "application/json",
        Authorization: `Bearer ${token}`,
      },
    });
    const result = await res.json();
    toast.success("User Deleted successfully!", {
      timeout: 2000,
    });
    setTimeout(() => {
      window.location.reload();
    }, 2000);
  } catch (err) {
    console.error("Failed to Delete User", err);
    toast.error("Failed to Delete User. Please try again.");
    return;
  }
};
</script>
<template>
  <div class="overflow-x-auto mt-4">
    <table class="min-w-full divide-y-2 divide-gray-200">
      <thead class="ltr:text-left rtl:text-right">
        <tr class="*:font-medium *:text-gray-900">
          <th
            v-for="col in columns"
            :key="col.key"
            class="px-3 py-2 whitespace-nowrap"
          >
            {{ col.label }}
          </th>
          <th v-if="actions" :key="actions" class="px-3 py-2 whitespace-nowrap">
            Actions
          </th>
        </tr>
      </thead>

      <tbody class="divide-y divide-gray-200">
        <tr
          v-for="row in data"
          :key="row.id"
          class="*:text-gray-900 *:first:font-medium"
        >
          <td
            v-for="col in columns"
            :key="col.key"
            class="px-3 py-2 whitespace-nowrap"
          >
            {{ row[col.key] }}
          </td>
          <td v-if="actions">
            <!-- <RouterLink v-for="action in actions" :to="action.key+'-user/'+row.id" :key="action.key" class="px-3 py-2 whitespace-nowrap hover:bg-blue-300 rounded-2xl">
              {{ action.label }}
            </RouterLink> -->
            <button
              @click="() => { deleteId = row.id; showConfirm = true }"
              class="px-3 py-1.5 mr-1 whitespace-nowrap bg-red-200 hover:bg-red-400 rounded-2xl hover:cursor-pointer"
            >
              Delete
            </button>
            <RouterLink
              :to="'view-user/' + row.id"
              class="px-3 py-1.5 whitespace-nowrap bg-blue-200 hover:bg-blue-400 rounded-2xl"
            >
              View
            </RouterLink>
          </td>
        </tr>
      </tbody>
    </table>
    <ConfirmDialog
      :show="showConfirm"
      title="Confirm Delete"
      :message="'Are you sure you want to delete user with ID ' + deleteId + '?'"
      @confirm="handleDeleteUser"
      @cancel="showConfirm = false"
    />
  </div>
</template>
