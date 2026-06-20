<script setup>
const props = defineProps({
  remaining: {
    type: Number,
    required: true,
  },
  clockMinutes: {
    type: String,
    required: true,
  },
  clockSeconds: {
    type: String,
    required: true,
  },
});
</script>

<template>
    <div class="place-items-baseline">
          <p
            v-if="props.remaining > 0"
            class="timer tabular-nums"
          >
            {{ props.clockMinutes }}
          </p>
          <p v-else class="timer tabular-nums">
            {{ props.clockSeconds }}
          </p>
        </div>
</template>

<style scoped>
    .timer {
        font-size: 5rem;
        font-family: "Noto Serif Display", serif;
        font-weight: 700;
    }

</style>
