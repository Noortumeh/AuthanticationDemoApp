<script setup>
import AuthForm from "@/components/AuthForm.vue";
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
  {
    name: "new password",
    id: "new_password",
    type: "password",
    placeholder: "Enter your new password",
  },
  {
    name: "new password confirmation",
    id: "new_password_confirmation",
    type: "password",
    placeholder: "Confirm your new password",
  },
  {
    name: "code",
    id: "code",
    type: "string",
    placeholder: "Enter the reset code",
  },
];
const loading = ref(false);

const handleResetPass = async (
  email,
  new_password,
  new_password_confirmation,
  code
) => {
    loading.value = true;
  try {
    const res = await fetch("http://127.0.0.1:8000/api/resetpassword", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({ email, new_password, new_password_confirmation, code }),
    });
    if (res.ok) {
      data.value = await res.json();
      console.log(data.value);
      toast.success(data.value.message, {
        timeout: 2000,
      });
      setTimeout(() => {
        window.location.href = "/";
      }, 2000);
    }
    loading.value = false;
  } catch (err) {
    console.error("Reset Password request failed", err);
    toast.error("Request failed. Please try again.");
    loading.value = false;
    return;
  }
};
</script>

<template>
  <AuthForm
    :fields="fields"
    formTitle="Reset Password"
    @submitForm="handleResetPass($event.email, $event.new_password, $event.new_password_confirmation, $event.code)"
    :loading="loading"
  />
</template>
