<template>
  <button
    :class="{ 'is-active': selectedTimerMode === mode }"
    @click="$emit('select', mode)"
    class="py-2 px-4 bg-black/20 backdrop-blur-md text-white border border-white/50 rounded-4xl hover:bg-black/40 focus:outline-none focus:ring-2 focus:ring-white/50 cursor-pointer timer-select"
  >
    <component v-if="sm" :is="selectModeIcon(mode)" class="w-4 h-4" />
    <slot v-else>{{ mode }}</slot>
  </button>
</template>

<script setup>
import { breakpointsTailwind, useBreakpoints } from "@vueuse/core";
import Coffee from "../../atoms/Icons/Coffee.vue";
import Bed from "../../atoms/Icons/Bed.vue";
import Focus from "../../atoms/Icons/Focus.vue";

const breakpoints = useBreakpoints(breakpointsTailwind);
const sm = breakpoints.smaller("sm");

function selectModeIcon(mode) {
  switch (mode) {
    case "focus":
      return Focus;
    case "short break":
      return Coffee;
    case "long break":
      return Bed;
    default:
      return null;
  }
}

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
