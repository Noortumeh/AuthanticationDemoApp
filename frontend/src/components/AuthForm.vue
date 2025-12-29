<script setup>
import { reactive } from "vue";
import { defineProps } from "vue";

const props = defineProps({
  fields: {
    type: Array,
    required: true,
  },
  formTitle: {
    type: String,
    required: true,
  },
  loading: {
    type: Boolean,
    default: false,
  },
  defaultValues: {
    type: Object,
    default: () => ({}),
    required: false,
  },
});

console.log("defaultValues: ");
console.log(props.defaultValues);

const emit = defineEmits(["submitForm"]);

const form = reactive({});
props.fields.forEach((field) => {
  form[field.id] = props.defaultValues[field.id] || "";
});

const handleSubmit = () => {
  emit("submitForm", { ...form });
};
</script>

<template>
  <form
    @submit.prevent="handleSubmit"
    class="max-w-md mx-auto mt-20 p-6 bg-white rounded-lg shadow-md"
  >
    <h2 class="text-2xl font-bold mb-6 text-center">{{ formTitle }}</h2>
    <div v-for="field in fields" :key="field.id" class="mb-4">
      <label
        class="block text-gray-700 text-sm font-bold mb-2"
        for="{{field.id}}"
        >{{ field.name }}</label
      >
      <input
        v-model="form[field.id]"
        :type="field.type"
        :placeholder="field.placeholder"
        :id="field.id"
        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
      >
    </div>
    <div class="flex items-center justify-between">
      <button
        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
        type="submit"
        :disabled="loading"
      >
        {{ loading ? "Submitting..." : "Submit" }}
      </button>
      <div v-if="formTitle === 'Login'">
        <RouterLink
          class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800"
          to="/forgot-password"
        >
          Forgot Password?
        </RouterLink>
      </div>
    </div>
  </form>
</template>
