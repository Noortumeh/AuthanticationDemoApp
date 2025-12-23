<script setup>
import { ref } from "vue";
import {
  TransitionRoot,
  TransitionChild,
  Dialog,
  DialogPanel,
  DialogTitle,
} from "@headlessui/vue";
import { useToast } from "vue-toastification";

const toast = useToast();
const token = localStorage.getItem("token");

const isOpen = ref(false);

function closeModal() {
  isOpen.value = false;
}
function openModal() {
  isOpen.value = true;
}

const addProfileData = async (bio, phone) => {
  console.log('bio: ' +bio);
  try {
    const res = await fetch("http://127.0.0.1:8000/api/profile", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
        Authorization: `Bearer ${token}`,
        "access-control-allow-credentials": "true",
      },
      body: JSON.stringify({ bio, phone }),
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
</script>

<template>
  <div class="inset-0 flex items-center justify-center">
    <button
      type="button"
      @click="openModal"
      class="rounded-md bg-black/20 px-4 py-2 text-sm font-medium text-white hover:bg-black/30 focus:outline-none focus-visible:ring-2 focus-visible:ring-white/75"
    >
      Add information
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
              <DialogTitle
                as="h3"
                class="text-lg font-medium leading-6 text-gray-900"
              >
                Add Profile Information
              </DialogTitle>

              <form
                @submit.prevent="
                  addProfileData(
                    $event.target.bio.value,
                    $event.target.phone.value
                  )
                "
                class="mt-4"
              >
                <div class="mb-4">
                  <label
                    for="bio"
                    class="block text-sm font-medium text-gray-700 mb-1"
                    >Bio</label
                  >
                  <input
                    type="text"
                    id="bio"
                    class="w-full border border-gray-300 rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Enter your bio"
                  />
                </div>
                <div class="mb-4">
                  <label
                    for="phone"
                    class="block text-sm font-medium text-gray-700 mb-1"
                    >Phone</label
                  >
                  <input
                    type="text"
                    id="phone"
                    class="w-full border border-gray-300 rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Enter your phone number"
                  />
                </div>
                <div class="mt-4">
                  <button
                    type="submit"
                    class="inline-flex justify-center rounded-md border border-transparent bg-blue-100 px-4 py-2 text-sm font-medium text-blue-900 hover:bg-blue-200 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2"
                  >
                    Save
                  </button>
                </div>
              </form>
            </DialogPanel>
          </TransitionChild>
        </div>
      </div>
    </Dialog>
  </TransitionRoot>
</template>
