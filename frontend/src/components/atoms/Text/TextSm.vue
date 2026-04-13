<template>
  <p class="text-sm font-normal font-dm-sans" :class="customClass">
    <slot />
  </p>
</template>

<script setup>
const props = defineProps({
  customClass: {
    type: String,
    default: "",
  },
});
</script>
