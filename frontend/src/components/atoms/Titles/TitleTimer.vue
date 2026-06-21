<template>
  <h1 class="timer font-noto-serif-display" :class="customClass">
    <slot />
  </h1>
</template>

<script setup>
defineProps({
  customClass: {
    type: String,
    default: "",
  },
});
</script>
