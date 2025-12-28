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
        "Accept": "application/json",
      },
      body: JSON.stringify({ name, email, password, password_confirmation }),
    });
    data.value = await res.json();
    toast.success("Registration successful!", {
      timeout: 2000,
    });
    setTimeout(() => {
      loading.value = false;
      window.location.href = "/login";
    }, 2000);
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
</template>
