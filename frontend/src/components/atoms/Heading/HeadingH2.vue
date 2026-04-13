<template>
  <h2 class="heading-h2 font-dm-sans" :class="customClass">
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
