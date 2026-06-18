<template>
  <div class="fixed inset-0 z-50 flex items-start sm:items-center justify-center p-4 pt-10 sm:pt-4 backdrop-blur-md">
    <div class="w-full max-w-md max-h-[90vh] overflow-y-auto border border-black rounded-xl shadow-lg bg-violet-100">
      <div class="p-4 sm:p-5 space-y-3">
        <div class="flex justify-between items-start gap-4">
          <h2 class="text-xl sm:text-2xl font-bold">
            {{ props.action }} {{ props.resource }}
          </h2>

          <button
            type="button"
            @click="emit('close')"
            class="bg-indigo-500 hover:bg-indigo-600 transition-all text-white px-3 py-1 cursor-pointer rounded-xl"
          >
            &times;
          </button>
        </div>

        <slot></slot>

        <button
          type="button"
          @click="emit('submit')"
          class="bg-indigo-500 hover:bg-indigo-600 transition-all text-white py-2 rounded-md cursor-pointer px-3 w-full sm:w-auto"
        >
          {{ props.action }}
        </button>
      </div>
    </div>
  </div>
</template>

<script setup>
const props = defineProps({
  resource: {
    type: String,
    required: true
  },
  action: {
    type: String,
    required: true
  }
})

const emit = defineEmits(['close', 'submit'])
</script>