<template>
    <div
      v-if="show"
      id="alert-2"
      class="flex sm:items-center p-4 mb-4 text-sm text-black rounded-sm bg-violet-200"
      role="alert"
    >
      <div class="ms-2 text-sm">{{ message }}</div>
      <button
        type="button"
        @click="
          () => {
            show = false;
            $emit('close');
          }
        "
        class="ms-auto -mx-1.5 -my-1.5 bg-danger-soft text-fg-danger-strong rounded focus:ring-2 focus:ring-danger-medium p-1.5 hover:bg-danger-medium inline-flex items-center justify-center h-8 w-8 shrink-0"
        data-dismiss-target="#alert-2"
        aria-label="Close"
      >
        <span class="sr-only">Close</span>
        <svg
          class="w-4 h-4"
          aria-hidden="true"
          xmlns="http://www.w3.org/2000/svg"
          width="24"
          height="24"
          fill="none"
          viewBox="0 0 24 24"
        >
          <path
            stroke="#201335 "
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M6 18 17.94 6M18 18 6.06 6"
          />
        </svg>
      </button>
    </div>
</template>

<script setup>
import { ref } from "vue";

const props = defineProps({
  message: {
    type: String,
    required: true,
  },
});

const show = ref(true);
defineEmits(["close"]);
</script>
