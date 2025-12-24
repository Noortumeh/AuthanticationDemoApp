<script setup>
import AuthForm from "@/components/AuthForm.vue";
import { ref } from "vue";
import { useToast } from "vue-toastification";

const toast = useToast();

const fields = [
  {
    name: "email",
    id: "email",
    type: "email",
    placeholder: "Enter your email",
  },
  {
    name: "password",
    id: "password",
    type: "password",
    placeholder: "Enter your password",
  },
];

const loading = ref(false);

const sendLoginData = async (email, password) => {
  const data = ref(null);
  const error = ref(null);
  loading.value = true;

  try {
    const res = await fetch("http://127.0.0.1:8000/api/login", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
        // "access-control-allow-credentials": "true",
      },
      body: JSON.stringify({ email, password }),
    });
    if (res.ok) {
      data.value = await res.json();
      // Store the token in localStorage
      localStorage.setItem("token", data.value.access_token);
      console.log("Login successful:", data.value);
      toast.success("Login successful!", {
        timeout: 2000,
      });
      // Redirect to home page
      setTimeout(() => {
        window.location.href = "/";
      }, 2000);
    }else {
      toast.error("Login failed. Please try again.");
    }
    loading.value = false;
  } catch (err) {
    console.error("Login failed", err);
    error.value = "Failed to login";
    toast.error("Login failed. Please try again.");
    loading.value = false;
    return;
  }
};
</script>
<template>
  <AuthForm
    :fields="fields"
    formTitle="Login"
    @submitForm="sendLoginData($event.email, $event.password)"
    :loading="loading"
  />

  <!-- <form
    @submit.prevent="
      sendLoginData($event.target.email.value, $event.target.password.value)
    "
    class="max-w-md mx-auto mt-20 p-6 bg-white rounded-lg shadow-md"
  >
    <h2 class="text-2xl font-bold mb-6 text-center">Login</h2>
    <div class="mb-4">
      <label class="block text-gray-700 text-sm font-bold mb-2" for="email"
        >Email</label
      >
      <input
        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
        id="email"
        type="email"
        placeholder="Enter your email"
      />
    </div>
    <div class="mb-6">
      <label class="block text-gray-700 text-sm font-bold mb-2" for="password"
        >Password</label
      >
      <input
        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
        id="password"
        type="password"
        placeholder="Enter your password"
      />
    </div>
    <div class="flex items-center justify-between">
      <button
        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
        type="submit"
      >
        Login
      </button>
      <RouterLink
        class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800"
        to="/forgot-password"
      >
        Forgot Password?
      </RouterLink>
    </div>
  </form> -->
</template>
