<script setup>
import {
  Dialog,
  DialogPanel,
  DialogTitle,
  TransitionChild,
  TransitionRoot,
} from "@headlessui/vue";

defineProps({
  show: Boolean,
  title: String,
  message: String,
});
</script>

<template>
  <TransitionRoot appear :show="show" as="template">
    <Dialog as="div" @close="$emit('cancel')" class="relative z-10">
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
            <DialogPanel class="bg-white p-6 rounded">
              <DialogTitle class="text-lg font-bold">
                {{ title }}
              </DialogTitle>

              <p class="mt-2 text-gray-600">
                {{ message }}
              </p>

              <div class="flex justify-start gap-3 mt-5">
                <button
                  @click="$emit('cancel')"
                  class="px-4 py-2 rounded bg-gray-200 hover:bg-gray-300 hover:cursor-pointer"
                >
                  Cancel
                </button>
                <button
                  @click="$emit('confirm')"
                  class="px-4 py-2 rounded bg-red-600 text-white hover:bg-red-700 hover:cursor-pointer"
                >
                  Confirm
                </button>
              </div>
            </DialogPanel>
          </TransitionChild>
        </div>
      </div>
    </Dialog>
  </TransitionRoot>
</template>
