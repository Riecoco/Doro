<script setup>
import { onMounted } from "vue";
import TimerControls from "../../molecules/TimerControls/TimerControls.vue";
import TimerModes from "../../molecules/TimerModes/TimerModes.vue";
import Clock from "../../atoms/Clock/Clock.vue";
import { useTimerStore } from "../../../stores/timer.js";
import { useQuotesStore } from "../../../stores/quotes.js";
import { useAuthStore } from "../../../stores/auth.js";

const timerStore = useTimerStore();
const quotesStore = useQuotesStore();
const authStore = useAuthStore();

onMounted(async () => {
  await authStore.fetchUser();

  if (quotesStore.showQuotes && authStore.user) {
    await quotesStore.getRandomQuote();
  }
});
</script>

<template>
  <div
    class="flex flex-col items-center bg-black/10 backdrop-blur-md text-white border border-white/20 rounded-lg px-20 py-10 w-fit h-fit"
  >
    <div class="min-h-6 italic text-center text-white/80 text-sm md:text-md">
      <p v-if="quotesStore.showQuotes && quotesStore.currentQuote">
        “{{ quotesStore.currentQuote.text }}” — {{ quotesStore.currentQuote.author }}
      </p>
      <p v-else>
        {{ timerStore.greeting }}<template v-if="authStore.user?.name">
          {{ authStore.user.name }}</template
        >, ready to get to business?
      </p>
    </div>

    <TimerModes
      :selectedTimerMode="timerStore.selectedTimerMode"
      @selectTimerMode="timerStore.selectTimerMode"
    />

    <Clock
      :remaining="timerStore.remaining"
      :clockMinutes="timerStore.clockMinutes"
      :clockSeconds="timerStore.clockSeconds"
    />

    <TimerControls
      :hasStarted="timerStore.hasStarted"
      :isRunning="timerStore.isRunning"
      @startTimer="timerStore.startTimer"
      @pauseTimer="timerStore.pauseTimer"
      @resumeTimer="timerStore.resumeTimer"
      @stopTimer="timerStore.stopTimer"
    />
  </div>
</template>
