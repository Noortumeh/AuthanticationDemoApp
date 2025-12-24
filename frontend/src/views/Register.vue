<script setup>
import AuthForm from "@/components/AuthForm.vue";
import { ref } from "vue";
import { useToast } from "vue-toastification";

const toast = useToast();

const fields = [
  {
    name: "name",
    id: "name",
    type: "text",
    placeholder: "Enter your name",
  },
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
  {
    name: "password confirmation",
    id: "password_confirmation",
    type: "password",
    placeholder: "Confirm your password",
  },
];

const loading = ref(false);

const handleRegister = async (name, email, password, password_confirmation) => {
  const data = ref(null);
  const error = ref(null);
  loading.value = true;
  try {
    const res = await fetch("http://127.0.0.1:8000/api/register", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({ name, email, password, password_confirmation }),
    });
    data.value = await res.json();
    toast.success("Registration successful!", {
      timeout: 2000,
    });
    console.log("Registration successful:", data.value);
  } catch (err) {
    console.error("Registration failed", err);
    error.value = "Failed to register";
    toast.error("Registration failed. Please try again.");
    return;
  }
};
</script>

<template>
  <AuthForm
    :fields="fields"
    formTitle="Register"
    @submitForm="handleRegister($event.name, $event.email, $event.password, $event.password_confirmation)"
    :loading="loading" 
    />
  <!-- <form
    @submit.prevent="
      handleRegister(
        $event.target.name.value,
        $event.target.email.value,
        $event.target.password.value,
        $event.target.password_confirmation.value
      )
    "
    class="max-w-md mx-auto mt-20 p-6 bg-white rounded-lg shadow-md"
  >
    <h2 class="text-2xl font-bold mb-6 text-center">Register</h2>
    <div class="mb-4">
      <label class="block text-gray-700 text-sm font-bold mb-2" for="name"
        >Name</label
      >
      <input
        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
        id="name"
        type="text"
        placeholder="Enter your name"
      />
    </div>
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
    <div class="mb-6">
      <label
        class="block text-gray-700 text-sm font-bold mb-2"
        for="password_confirmation"
        >Confirmation Password</label
      >
      <input
        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
        id="password_confirmation"
        type="password"
        placeholder="Confirm your password"
      />
    </div>
    <div class="flex items-center justify-between">
      <button
        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
        type="submit"
      >
        Register
      </button>
    </div>
  </form> -->
</template>
