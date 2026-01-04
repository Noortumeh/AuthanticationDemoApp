<script setup>
import Form from "@/components/Form.vue";
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
        "Accept": "application/json",
        // "access-control-allow-credentials": "true",
      },
      body: JSON.stringify({ email, password }),
    });
    if (res.ok) {
      data.value = await res.json();
      // Store the token in localStorage
      localStorage.setItem("token", data.value.access_token);
      localStorage.setItem("role", data.value.role);
      console.log("Login successful:", data.value);
      toast.success("Login successful!", {
        timeout: 2000,
      });
      // Redirect to home page
      setTimeout(() => {
        loading.value = false;
        window.location.href = "/";
      }, 2000);
    }else {
      toast.error("Login failed. Please try again.");
      loading.value = false;
    }
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
  <Form
    :fields="fields"
    formTitle="Login"
    @submitForm="sendLoginData($event.email, $event.password)"
    :loading="loading"
  />
</template>
