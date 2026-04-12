<template>
  <div class="place-items-baseline">
    <p v-if="remaining > 0 || remaining != null" class="timer tabular-nums">
      {{ Duration.fromObject({ seconds: remaining }).toFormat("mm:ss") }}
    </p>
    <p v-else class="timer tabular-nums">
      {{ Duration.fromObject({ seconds: duration }).toFormat("mm:ss") }}
    </p>
  </div>
</template>

<script setup>
import { useTimer } from "vue-timer-hook";
import { Duration } from "luxon";

const props = defineProps({
  duration: {
    type: Number,
    required: true,
  },
  remaining: {
    type: Number,
    required: false,
  },
});
</script>
