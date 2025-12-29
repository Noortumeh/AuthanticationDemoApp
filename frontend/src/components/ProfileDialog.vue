<script setup>
import { ref } from "vue";
import {
  TransitionRoot,
  TransitionChild,
  Dialog,
  DialogPanel,
} from "@headlessui/vue";
import { useToast } from "vue-toastification";
import AuthForm from "./AuthForm.vue";
import { defineProps } from "vue";

const props = defineProps({
  data: {
    type: Object,
    required: false,
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
    type: "text",
    placeholder: "Upload your profile image",
  },
];

const loading = ref(false);

const addProfileData = async (bio, phone, address, birthdate, image) => {
  console.log('Adding profile with:', bio, phone, address, birthdate, image);
  try {
    const res = await fetch("http://127.0.0.1:8000/api/profile", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
        Accept: "application/json",
        Authorization: `Bearer ${token}`,
        "access-control-allow-credentials": "true",
      },
      body: JSON.stringify({ bio, phone, address, birthdate, image }),
    });
    const result = await res.json();
    toast.success("Profile updated successfully!", {
      timeout: 2000,
    });
    console.log("Profile updated:", result);
    closeModal();
    setTimeout(()=>{
      window.location.reload();
    },2000);
  } catch (err) {
    console.error("Failed to update profile", err);
    toast.error("Failed to update profile. Please try again.");
    return;
  }
};

const updateProfileData = async (bio, phone, address, birthdate, image) => {
  console.log('Updating profile with:', bio, phone, address, birthdate, image);
  try {
    const res = await fetch("http://127.0.0.1:8000/api/update-profile", {
      method: "PUT",
      headers: {
        "Content-Type": "application/json",
        Accept: "application/json",
        Authorization: `Bearer ${token}`,
        "access-control-allow-credentials": "true",
      },
      body: JSON.stringify({ bio, phone, address, birthdate, image }),
    });
    const result = await res.json();
    if (res.ok) {
      toast.success("Profile updated successfully!", {
        timeout: 2000,
      });
      console.log("Profile updated:", result);
      closeModal();
      setTimeout(()=>{
        window.location.reload();
      },2000);
    } else {
      throw new Error(result.error || "Failed to update profile");
    }
  } catch (err) {
    console.error("Failed to update profile", err);
    toast.error("Failed to update profile. Please try again.");
    return;
  }
};
</script>

<template>
  <div class="inset-0 flex items-center justify-center">
    <button
      type="button"
      @click="openModal"
      class="rounded-md bg-black/20 px-4 py-2 text-sm font-medium text-white hover:bg-black/30 focus:outline-none focus-visible:ring-2 focus-visible:ring-white/75"
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
              <AuthForm
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
