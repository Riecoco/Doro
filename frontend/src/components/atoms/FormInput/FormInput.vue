<template>
  <div>
    <label class="block font-dm-sans text-md">{{ label }}</label>
    <input
      :type="type"
      @input="$emit('update:modelValue', $event.target.value)"
      :placeholder="placeholder"
      required
      min="0"
      class="border border-gray-200 rounded w-full p-2 mt-1 outline-indigo-500 font-dm-sans text-lg"
    />
  </div>
</template>

<script setup>
const props = defineProps({
  type: {
    type: String,
    default: "text",
  },
  label: {
    type: String,
    required: true,
  },
  placeholder: {
    type: String,
    default: "type here",
  },
  modelValue: {
    type: [String, Number],
    default: "",
  },
});

const emits = defineEmits(["update:modelValue"]);
</script>
