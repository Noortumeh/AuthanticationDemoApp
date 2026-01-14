<script setup>
import { ref } from "vue";
import {
  TransitionRoot,
  TransitionChild,
  Dialog,
  DialogPanel,
} from "@headlessui/vue";
import { useToast } from "vue-toastification";
import Form from "./Form.vue";
import { defineProps } from "vue";

const props = defineProps({
  data: {
    type: Object,
    required: false,
  },
  api: {
    type: String,
  },
});

const toast = useToast();
const token = localStorage.getItem("token");

const isOpen = ref(false);

function closeModal() {
  isOpen.value = false;
}
function openModal() {
  isOpen.value = true;
}

const fields = [
  {
    name: "bio",
    id: "bio",
    type: "text",
    placeholder: "Enter your bio",
  },
  {
    name: "phone",
    id: "phone",
    type: "text",
    placeholder: "Enter your phone number",
  },
  {
    name: "address",
    id: "address",
    type: "text",
    placeholder: "Enter your address",
  },
  {
    name: "Date Of Birth",
    id: "birthdate",
    type: "date",
    placeholder: "Enter your date of birth",
  },
  {
    name: "image",
    id: "image",
    type: "file",
    placeholder: "Upload your profile image",
  },
];

const loading = ref(false);

const addProfileData = async (bio, phone, address, birthdate, image) => {
  const formData = new FormData();

  if (bio) formData.append("bio", bio);
  if (phone) formData.append("phone", phone);
  if (address) formData.append("address", address);
  if (birthdate) formData.append("birthdate", birthdate);
  if (image) formData.append("image", image);

  formData.set("_method", "POST");
  formData.set("encrypt", "multipart/form-data");

  formData.forEach((value, key) => {
    console.log(key, value);
  });

  try {
    const res = await fetch(
      props.api ? props.api : "http://127.0.0.1:8000/api/profile",
      {
        method: "POST",
        headers: {
          "Content-Type": "multipart/form-data",
          Accept: "application/json",
          Authorization: `Bearer ${token}`,
        },
        body: formData,
      }
    );
    const result = await res.json();
    if (res.ok) {
      toast.success("Profile updated successfully!", {
        timeout: 2000,
      });

      setTimeout(() => {
        window.location.reload();
      }, 2000);
    } else {
      toast.error("Failed to update profile");
    }
    closeModal();
  } catch (err) {
    console.error("Failed to add profile", err);
    toast.error("Failed to add profile. Please try again.");
    return;
  }
};

const updateProfileData = async (bio, phone, address, birthdate, image) => {
  const formData = new FormData();

  if (bio) formData.set("bio", bio);
  if (phone) formData.set("phone", phone);
  if (address) formData.set("address", address);
  if (birthdate) formData.set("birthdate", birthdate);
  if (image) formData.set("image", image);

  formData.set("_method", "POST");
  formData.set("encrypt", "multipart/form-data");

  console.log(bio, phone, address, birthdate, image);
  try {
    const res = await fetch(
      props.api ? props.api : "http://127.0.0.1:8000/api/update-profile",
      {
        method: "POST",
        headers: {
          // "Content-Type": "multipart/form-data",
          // Accept: "application/json",
          Authorization: `Bearer ${token}`,
          "access-control-allow-credentials": "true",
        },
        body: formData,
      }
    );
    const result = await res.json();
    if (res.ok) {
      toast.success("Profile updated successfully!", {
        timeout: 2000,
      });
      console.log("Profile updated:", result);
      closeModal();
      setTimeout(() => {
        window.location.reload();
      }, 2000);
    } else {
      throw new Error(result.error || "Failed to update profile");
    }
  } catch (err) {
    console.error("Failed to update profile", err);
    toast.error(err.message || "Failed to update profile. Please try again.");
    return;
  }
};
</script>

<template>
  <div class="inset-0 flex items-center justify-center">
    <button
      type="button"
      @click="openModal"
      class="rounded-md bg-blue-400 px-4 mt-2 py-2 text-sm font-medium text-white hover:bg-blue-500 hover:cursor-pointer focus:outline-none focus-visible:ring-2 focus-visible:ring-white/75"
    >
      {{ props.data ? "Edit Profile Info" : "Add Profile Info" }}
    </button>
  </div>
  <TransitionRoot appear :show="isOpen" as="template">
    <Dialog as="div" @close="closeModal" class="relative z-10">
      <TransitionChild
        as="template"
        enter="duration-300 ease-out"
        enter-from="opacity-0"
        enter-to="opacity-100"
        leave="duration-200 ease-in"
        leave-from="opacity-100"
        leave-to="opacity-0"
      >
        <div class="fixed inset-0 bg-black/25" />
      </TransitionChild>

      <div class="fixed inset-0 overflow-y-auto">
        <div
          class="flex min-h-full items-center justify-center p-4 text-center"
        >
          <TransitionChild
            as="template"
            enter="duration-300 ease-out"
            enter-from="opacity-0 scale-95"
            enter-to="opacity-100 scale-100"
            leave="duration-200 ease-in"
            leave-from="opacity-100 scale-100"
            leave-to="opacity-0 scale-95"
          >
            <DialogPanel
              class="w-full max-w-md transform overflow-hidden rounded-2xl bg-white p-6 text-left align-middle shadow-xl transition-all"
            >
              <Form
                :fields="fields"
                formTitle="Add Profile Info"
                :loading="loading"
                :defaultValues="data || {}"
                @submitForm="
                  !data
                    ? addProfileData(
                        $event.bio,
                        $event.phone,
                        $event.address,
                        $event.birthdate,
                        $event.image
                      )
                    : updateProfileData(
                        $event.bio,
                        $event.phone,
                        $event.address,
                        $event.birthdate,
                        $event.image
                      )
                "
              />
            </DialogPanel>
          </TransitionChild>
        </div>
      </div>
    </Dialog>
  </TransitionRoot>
</template>
