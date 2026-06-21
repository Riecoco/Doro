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

    const DEFAULT_SETTINGS = {
        focusDuration: 25,
        shortBreakDuration: 5,
        longBreakDuration: 15
    };

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
        const timerSettings = getSavedTimerSettings();
        if (mode === "focus") {
            minutes.value = timerSettings?.focusDuration ?? 25;
            seconds.value = 0;
        } else if (mode === "short break") {
            minutes.value = timerSettings?.shortBreakDuration ?? 5;
            seconds.value = 0;
        } else if (mode === "long break") {
            minutes.value = timerSettings?.longBreakDuration ?? 15;
            seconds.value = 0;
        }
        stopTimer();
    }

    function saveTimerSettings(focusDuration, shortBreakDuration, longBreakDuration) {
        const f = Number(focusDuration);
        const s = Number(shortBreakDuration);
        const l = Number(longBreakDuration);
        const settings = {
            focusDuration: Number.isFinite(f) && f > 0 ? f : DEFAULT_SETTINGS.focusDuration,
            shortBreakDuration: Number.isFinite(s) && s > 0 ? s : DEFAULT_SETTINGS.shortBreakDuration,
            longBreakDuration: Number.isFinite(l) && l > 0 ? l : DEFAULT_SETTINGS.longBreakDuration
        };

        localStorage.setItem("timerSettings", JSON.stringify(settings));
        selectTimerMode(selectedTimerMode.value);

        return settings;
    }

    function resetTimerSettings() {
        localStorage.removeItem("timerSettings");
        const settings = getSavedTimerSettings();
        selectTimerMode(selectedTimerMode.value);

        return settings;
    }

    function getSavedTimerSettings() {
        let timerSettings = null;

        try {
            timerSettings = JSON.parse(localStorage.getItem("timerSettings"));
        } catch {
            localStorage.removeItem("timerSettings");
        }
        
        return {
            focusDuration: Number.isFinite(timerSettings?.focusDuration) && timerSettings?.focusDuration > 0 ? timerSettings.focusDuration : 25,
            shortBreakDuration: Number.isFinite(timerSettings?.shortBreakDuration) && timerSettings?.shortBreakDuration > 0 ? timerSettings.shortBreakDuration : 5,
            longBreakDuration: Number.isFinite(timerSettings?.longBreakDuration) && timerSettings?.longBreakDuration > 0 ? timerSettings.longBreakDuration : 15
        };
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
        clockSeconds,
        saveTimerSettings,
        resetTimerSettings,
        getSavedTimerSettings
    };

});
