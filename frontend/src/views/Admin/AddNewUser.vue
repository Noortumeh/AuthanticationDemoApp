<script setup>
import Form from "@/components/Form.vue";
import { ref } from "vue";
import { useToast } from "vue-toastification";

const toast = useToast();

const fields = [
  {
    name: "name",
    id: "name",
    type: "text",
    placeholder: "Enter your name",
    required: true
  },
  {
    name: "email",
    id: "email",
    type: "email",
    placeholder: "Enter your email",
    required: true
  },
  {
    name: "password",
    id: "password",
    type: "password",
    placeholder: "Enter your password",
    required: true
  },
  {
    name: "password confirmation",
    id: "password_confirmation",
    type: "password",
    placeholder: "Confirm your password",
    required: true
  },
  {
    name: "Role",
    id: "role",
    type: "text",
    placeholder: "Add The Role (Admin/User)",
    required: false
  },
];

const loading = ref(false);
const token = localStorage.getItem("token");

const handleAddNewUser = async (
  name,
  email,
  password,
  password_confirmation,
  role
) => {
  const data = ref(null);
  const error = ref(null);
  loading.value = true;
  try {
    const res = await fetch("http://127.0.0.1:8000/api/admin/user", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
        Accept: "application/json",
        Authorization: `Bearer ${token}`,
      },
      body: JSON.stringify({ name, email, password, password_confirmation, role }),
    });
    data.value = await res.json();
    if (res.ok) {
      toast.success("Creating New User successful!", {
        timeout: 2000,
      });
      setTimeout(() => {
        loading.value = false;
        window.location.href = "/dashboard/users";
      }, 2000);
      console.log("Creating New User successful:", data.value);
    }else{
      console.log(data.value);
      toast.error(data.value.message);
    }
  } catch (err) {
    console.error("Creating User Failed", err);
    error.value = "Failed to Create User";
    toast.error("Creating User failed. Please try again.");
    return;
  }
};
</script>
<template>
  <Form
    :fields="fields"
    formTitle="Add New User"
    @submitForm="
      handleAddNewUser(
        $event.name,
        $event.email,
        $event.password,
        $event.password_confirmation,
        $event.role
      )
    "
    :loading="loading"
  />
</template>
