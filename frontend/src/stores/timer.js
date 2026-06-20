import { defineStore } from "pinia";
import { computed, ref } from "vue";
import { Duration } from "luxon";
import { useCountdown } from "@vueuse/core";

export const useTimerStore = defineStore("timer", () => {
    const finished = ref("");
    const minutes = ref(25);
    const seconds = ref(0);
    const hasStarted = ref(false);
    const isRunning = ref(false);
    const selectedTimerMode = ref("focus");

    const duration = computed(() => {
    return minutes.value * 60 + seconds.value;
    });

    const { remaining, start, stop, pause, resume } = useCountdown(duration, {
        onComplete() {
            stopTimer();
            finished.value = "Time's up!";
        },
        onStart() {
            finished.value = "";
        }
    });

    const clockMinutes = computed(() =>
        Duration.fromObject({ seconds: remaining.value }).toFormat("mm:ss")
    );
    const clockSeconds = computed(() =>
        Duration.fromObject({ seconds: duration.value }).toFormat("mm:ss")
    );

    const greeting = computed(() => {
        const hour = new Date().getHours();
        if (hour < 12) return "Good morning";
        else if (hour < 18) return "Good afternoon";
        else return "Good evening";
    });

    const startTimer = () => {
        start();
        hasStarted.value = true;
        isRunning.value = true;
    };

    const pauseTimer = () => {
        pause();
        isRunning.value = false;
    };

    const resumeTimer = () => {
        resume();
        isRunning.value = true;
    };

    const stopTimer = () => {
        stop();
        hasStarted.value = false;
        isRunning.value = false;
    };

    function selectTimerMode(mode) {
        selectedTimerMode.value = mode;
        if (mode === "focus") {
            minutes.value = 25;
            seconds.value = 0;
        } else if (mode === "short break") {
            minutes.value = 5;
            seconds.value = 0;
        } else if (mode === "long break") {
            minutes.value = 15;
            seconds.value = 0;
        }
        stopTimer();
    }

    return {
        finished,
        minutes,
        seconds,
        duration,
        remaining,
        hasStarted,
        isRunning,
        selectedTimerMode,
        startTimer,
        pauseTimer,
        resumeTimer,
        stopTimer,
        selectTimerMode,
        greeting,
        clockMinutes,
        clockSeconds
    };

});
