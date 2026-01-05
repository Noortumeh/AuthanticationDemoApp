<script setup>
import Form from "@/components/Form.vue";
import { ref } from "vue";
import { useToast } from "vue-toastification";

const data = ref(null);

const toast = useToast();

const fields = [
  {
    name: "email",
    id: "email",
    type: "email",
    placeholder: "Enter your email",
  },
];
const loading = ref(false);

const sendForgetPass = async (email) => {
  loading.value = true;
  try {
    const res = await fetch("http://127.0.0.1:8000/api/forgotpassword", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
        Accept: "application/json",
      },
      body: JSON.stringify({ email }),
    });
    data.value = await res.json();
    if (res.ok) {
      console.log(data.value);
      toast.success(data.value.message, {
        timeout: 2000,
      });
      setTimeout(() => {
        window.location.href = "/reset-password";
      }, 2000);
    } else {
      toast.error(data.value.message);
    }
    loading.value = false;
  } catch (err) {
    console.error("Forgot Password request failed", err);
    toast.error("Request failed. Please try again.");
    loading.value = false;
    return;
  }
};
</script>

<template>
  <Form
    :fields="fields"
    formTitle="Forgot Password"
    @submitForm="sendForgetPass($event.email)"
    :loading="loading"
  />
</template>
