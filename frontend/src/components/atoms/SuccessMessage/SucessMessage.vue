<script setup>

const props = defineProps({
  message: {
    type: String,
    required: true,
  },
});
const emit = defineEmits(["close"]);
</script>

<template>
<Transition name="slide-fade">
    <!-- From Uiverse.io by seyed-mohsen-mousavi --> 
<div v-if="props.message" class="flex flex-col gap-2 w-60 sm:w-72 text-[10px] sm:text-xs fixed inset-0 z-90">
  <div
    class="self-center mt-5 success-alert cursor-default flex items-center justify-between w-full h-12 sm:h-14 rounded-lg bg-[#232531] px-[10px]"
  >
    <div class="flex gap-2">
      <div class="text-[#2b9875] bg-white/5 backdrop-blur-xl p-1 rounded-lg">
        <svg
          xmlns="http://www.w3.org/2000/svg"
          fill="none"
          viewBox="0 0 24 24"
          stroke-width="1.5"
          stroke="currentColor"
          class="w-6 h-6"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            d="m4.5 12.75 6 6 9-13.5"
          ></path>
        </svg>
      </div>
        <p class="text-gray-300 self-center">{{ props.message }}</p>
    </div>
    <button
      class="text-gray-600 text-gray-600 hover:bg-white/5 p-1 rounded-md transition-colors ease-linear"
      @click="emit('close')"
    >
      <svg
        xmlns="http://www.w3.org/2000/svg"
        fill="none"
        viewBox="0 0 24 24"
        stroke-width="1.5"
        stroke="currentColor"
        class="w-6 h-6"
      >
        <path
          stroke-linecap="round"
          stroke-linejoin="round"
          d="M6 18 18 6M6 6l12 12"
        ></path>
      </svg>
    </button>
  </div>
</div>
</Transition>
</template>

<style>
.slide-fade-enter-active {
  transition: all 0.3s ease-out;
}

.slide-fade-leave-active {
  transition: all 0.8s cubic-bezier(1, 0.5, 0.8, 1);
}

.slide-fade-enter-from,
.slide-fade-leave-to {
  transform: translateY(-20px);
  opacity: 0;
}
</style>