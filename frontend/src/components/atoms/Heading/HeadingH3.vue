<template>
  <h3 class="heading-h3 font-dm-sans" :class="customClass">
    <slot />
  </h3>
</template>

<script setup>
defineProps({
  customClass: {
    type: String,
    default: "",
  },
});
</script>
