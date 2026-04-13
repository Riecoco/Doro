<template>
  <h2 class="logo font-noto-serif-display" :class="customClass">
    <slot />
  </h2>
</template>

<script setup>
defineProps({
  customClass: {
    type: String,
    default: "",
  },
});
</script>
