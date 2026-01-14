<script setup>
import ProfileDialog from "@/components/ProfileDialog.vue";
import { onMounted, ref, render } from "vue";
import { useToast } from "vue-toastification";

const toast = useToast();
const token = localStorage.getItem("token");
const data = ref(null);
const error = ref(null);
if(!token){
  window.location.href = "/login";
}

onMounted(async () => {
  try {
    const res = await fetch("http://127.0.0.1:8000/api/profile", {
      method: "GET",
      headers: {
        "Content-Type": "application/json",
        Accept: "application/json",
        Authorization: `Bearer ${token}`,
      },
    });
    const result = await res.json();
    data.value = result.original;
    console.log(data.value);
    if (!res.success) {
      error.value = data.value.message;
      // return;
    }
    
  } catch (err) {
    console.error("Failed to fetch profile data", err);
    error.value = "Failed to fetch profile data";
    toast.error("Failed to fetch profile data. Please try again.");
    return;
  }
});
</script>
<template>
  <div class="max-w-md mx-auto mt-20 p-6 bg-white rounded-lg shadow-md">
    <h2 class="text-2xl font-bold mb-6 text-center">Profile</h2>
    <div v-if="data?.profile">
      <div class="mb-4 flex justify-center">
        <div v-if="data.profile?.image">
          <img
            :src="data.profile?.image"
            alt="Profile Image"
            class="mt-2 w-32 h-32 object-cover rounded-full"
          />
        </div>
      </div>
      <p class="mb-4"><strong>Name:</strong> {{ data?.name }}</p>
      <p class="mb-4"><strong>Email:</strong> {{ data?.email }}</p>
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
    <div v-else>
      <p>Loading profile data...</p>
    </div>
  </div>
  <div class="text-center">
    <ProfileDialog :data="data?.profile" />
  </div>
</template>
