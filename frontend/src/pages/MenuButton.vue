<template>
  <button
    :class="{ 'is-open': activeMenuIndex === index }"
    @click="$emit('toggle', index)"
    class="bg-black/10 backdrop-blur-md text-white border border-white/20 rounded-lg menu-btn"
  >
    <slot></slot>
  </button>
</template>

<script setup>
const props = defineProps({
  activeMenuIndex: {
    type: Number,
    required: true,
  },
  index: {
    type: Number,
    required: true,
  },
});
</script>

<style scoped>
.menu-btn {
  width: fit-content;
  padding: 0.5rem;
  height: fit-content;
  transition: transform 0.25s cubic-bezier(0.34, 1.56, 0.64, 1);
  transform: translateY(0);
}

.menu-btn.is-open {
  background-color: rgba(122, 86, 0, 0.315);
  backdrop-filter: blur(10px);
  transform: translateY(-1rem);
}
</style>
