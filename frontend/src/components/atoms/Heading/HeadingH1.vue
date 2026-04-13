<template>
  <h1 class="heading-h1 font-dm-sans" :class="customClass">
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
