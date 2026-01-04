<script setup>
import ProfileDialog from "@/components/ProfileDialog.vue";
import { onMounted, ref } from "vue";
import { useRoute } from "vue-router";
import { useToast } from "vue-toastification";

const path = useRoute();
const toast = useToast();
const token = localStorage.getItem("token");
const data = ref(null);
const error = ref(null);
const loading = ref(false);

onMounted(async () => {
  try {
    loading.value = true;
    const res = await fetch(
      `http://127.0.0.1:8000/api/admin/user/${path.params.id}`,
      {
        method: "GET",
        headers: {
          "Content-Type": "application/json",
          Accept: "application/json",
          Authorization: `Bearer ${token}`,
        },
      }
    );
    data.value = await res.json();
    console.log("User data fetched:", data.value);
    loading.value = false;
  } catch (err) {
    console.error("Failed to fetch User data", err);
    error.value = "Failed to fetch User data";
    toast.error("Failed to fetch User data. Please try again.");
    loading.value = false;
    return;
  }
});
</script>
<template>
  <div class="max-w-md mx-auto mt-20 p-6 bg-white rounded-lg shadow-md">
    <h2 class="text-2xl font-bold mb-6 text-center">Profile</h2>
    <div v-if="data">
      <div class="mb-4 flex justify-center">
        <div v-if="data.image">
          <img
            :src="data.image"
            alt="Profile Image"
            class="mt-2 w-32 h-32 object-cover rounded-full"
          />
        </div>
      </div>
      <p class="mb-4"><strong>Name:</strong> {{ data.name }}</p>
      <p class="mb-4"><strong>Email:</strong> {{ data.email }}</p>
      <p class="mb-4"><strong>Bio:</strong> {{ data.profile?.bio }}</p>
      <p class="mb-4"><strong>Phone:</strong> {{ data.profile?.phone }}</p>
      <p class="mb-4"><strong>Address:</strong> {{ data.profile?.address }}</p>
      <p class="mb-4">
        <strong>Date of Birth:</strong> {{ data.profile?.birthdate }}
      </p>
    </div>
    <div v-else-if="error" class="text-red-500">
      {{ error }}
    </div>
    <div v-else-if="loading === true">
      <p>Loading profile data...</p>
    </div>
    <div v-else>
      <p>No User Data</p>
    </div>

  </div>
  <div class="text-center mt-4">
    <ProfileDialog
      :data="data?.profile"
      :api="
        'http://127.0.0.1:8000/api/admin/users/' + path.params.id + '/profile'
      "
    />
  </div>
</template>
