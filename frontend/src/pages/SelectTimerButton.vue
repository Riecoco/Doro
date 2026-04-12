<template>
  <button
    :class="{ 'is-active': selectedTimerMode === mode }"
    @click="$emit('select', mode)"
    class="py-2 px-4 bg-black/20 backdrop-blur-md text-white border border-white/50 rounded-4xl hover:bg-black/40 focus:outline-none focus:ring-2 focus:ring-white/50 cursor-pointer timer-select"
  >
    <slot>{{ mode }}</slot>
  </button>
</template>

<script setup>
const props = defineProps({
  minute: {
    type: Number,
    required: true,
  },
  selectedTimerMode: {
    type: String,
    required: true,
  },
  mode: {
    type: String,
    required: true,
  },
});
</script>

<style scoped>
.timer-select {
  width: fit-content;
}
.timer-select.is-active {
  background-color: rgba(122, 86, 0, 0.315);
  backdrop-filter: blur(10px);
}
</style>
