<template>
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width" />
    <title>Doro Home</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&family=Noto+Serif+Display:ital,wght@0,100..900;1,100..900&display=swap"
      rel="stylesheet"
    />
  </head>
  <body
    class="bg-[url(/src/assets/img/default-bg.jpg)] bg-cover bg-center bg-fixed"
  >
    <section
      class="h-dvh place-items-center flex flex-col justify-center space-y-15 relative"
    >
      <div
        class="place-content-center place-items-center bg-black/10 backdrop-blur-md text-white border border-white/20 rounded-lg px-20 py-10 w-fit h-fit"
      >
        <h2 class="italic text-center">
          {{ greeting }}, what's on the agenda today?
        </h2>

        <div class="flex grid-cols-3 gap-x-4 mt-6">
          <SelectTimerButton
            mode="focus"
            :selectedTimerMode="selectedTimerMode"
            :minute="Number(25)"
            @select="selectTimerMode"
          />

          <SelectTimerButton
            mode="short break"
            :selectedTimerMode="selectedTimerMode"
            :minute="Number(5)"
            @select="selectTimerMode"
          />
          <SelectTimerButton
            mode="long break"
            :selectedTimerMode="selectedTimerMode"
            :minute="Number(15)"
            @select="selectTimerMode"
          />
        </div>

        <div class="place-items-baseline">
          <p
            v-if="remaining > 0 || remaining != null"
            class="timer tabular-nums"
          >
            {{ Duration.fromObject({ seconds: remaining }).toFormat("mm:ss") }}
          </p>
          <p v-else class="timer tabular-nums">
            {{ Duration.fromObject({ seconds: duration }).toFormat("mm:ss") }}
          </p>
        </div>

        <!-- Timer controls -->
        <div class="grid grid-cols-2 gap-4">
          <div v-if="!hasStarted">
            <button @click="startTimer()" class="mt-4 py-2 px-2 cursor-pointer">
              <Play />
            </button>
          </div>
          <div v-else-if="hasStarted && isRunning">
            <button @click="pauseTimer()" class="mt-4 py-2 px-2 cursor-pointer">
              <Pause />
            </button>
          </div>
          <div v-else-if="hasStarted && !isRunning">
            <button
              @click="resumeTimer()"
              class="mt-4 py-2 px-2 cursor-pointer"
            >
              <Play />
            </button>
          </div>
          <button @click="stopTimer()" class="mt-4 py-2 px-2 cursor-pointer">
            <CycleIcon />
          </button>
        </div>
      </div>
      <section
        class="flex justify-between p-3 place-self-start w-full fixed bottom-0"
      >
        <div class="grid grid-cols-2 gap-x-5">
          <div class="btm-panel">
            <Transition name="menu">
              <section
                v-if="activeMenuIndex === 0"
                class="w-64 sm:w-80 md:w-100 lg:w-150 p-3 mb-7 bg-black/10 backdrop-blur-md text-white border border-white/20 rounded-lg menu"
              >
                <form
                  v-if="tasks != null && tasks.length > 0"
                  v-for="task in tasks"
                  :key="task.id"
                  class="flex items-center space-x-2"
                >
                  <div>
                    <SixDots />
                  </div>
                  <input
                    type="checkbox"
                    :id="task.id"
                    v-model="task.completed"
                  />
                  <label :for="task.id">{{ task.name }}</label>
                </form>
                <div v-else class="text-white/60 text-center">
                  <p>You've got no tasks yet, want to get started?</p>
                  <button
                    @click="addTask()"
                    class="mt-4 border border-white/20 text-white py-2 px-4 rounded-md hover:bg-white hover:text-black focus:outline-none focus:ring-2 focus:ring-green-500 cursor-pointer"
                  >
                    Add Task
                  </button>
                </div>
              </section>
            </Transition>
            <MenuButton
              :index="0"
              :activeMenuIndex="activeMenuIndex"
              @toggle="toggleMenu"
            >
              <EditIcon />
            </MenuButton>
          </div>
          <div class="btm-panel">
            <Transition name="menu">
              <section
                v-if="activeMenuIndex === 1"
                class="w-64 sm:w-80 md:w-100 lg:w-150 p-3 mb-7 bg-black/10 backdrop-blur-md text-white border border-white/20 rounded-lg menu"
              >
                <p class="text-center text-white/60">No notifications yet</p>
              </section>
            </Transition>
            <MenuButton
              :index="1"
              :activeMenuIndex="activeMenuIndex"
              @toggle="toggleMenu"
            >
              <MusicNoteIcon />
            </MenuButton>
          </div>
        </div>
        <div>
          <div class="btm-panel">
            <Transition name="menu">
              <section
                v-if="activeMenuIndex === 2"
                class="w-64 sm:w-80 md:w-100 lg:w-150 p-3 mb-7 bg-black/10 backdrop-blur-md text-white border border-white/20 rounded-lg menu right"
              >
                <Settings :user="authStore.user" />
              </section>
            </Transition>
            <MenuButton
              :index="2"
              :activeMenuIndex="activeMenuIndex"
              @toggle="toggleMenu"
            >
              <GearIcon />
            </MenuButton>
          </div>
        </div>
      </section>
    </section>
  </body>
</template>

<script setup>
import { ref, computed, onMounted } from "vue";
import router from "../../../router/index.js";
import { Duration } from "luxon";
import axios from "../../../utils/axios.js";
import { useAuthStore } from "../../../stores/auth.js";
import { useCountdown } from "@vueuse/core";
import MenuButton from "../../atoms/Button/MenuButton.vue";
import EditIcon from "../../atoms/Icons/EditIcon.vue";
import MusicNoteIcon from "../../atoms/Icons/MusicNoteIcon.vue";
import GearIcon from "../../atoms/Icons/GearIcon.vue";
import SixDots from "../../atoms/Icons/SixDots.vue";
import SelectTimerButton from "../../atoms/Button/SelectTimerButton.vue";
import CycleIcon from "../../atoms/Icons/CycleIcon.vue";
import Play from "../../atoms/Icons/Play.vue";
import Pause from "../../atoms/Icons/Pause.vue";
import Settings from "../../organisms/Settings/Settings.vue";

// use timer config values later to set the initial duration of the timer.
// db will automatically store time in seconds, so we won't need convert when fetching,
// but we'll need to convert when setting the timer duration in the settings
const minutes = ref(25);
const seconds = ref(0);
const hasStarted = ref(false);
const isRunning = ref(false);

const duration = computed(() => {
  return minutes.value * 60 + seconds.value;
});

const { remaining, start, stop, pause, resume } = useCountdown(duration, {
  onComplete() {
    stopTimer();
    // send notification
    console.log("Countdown completed!");
  },
});

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

const handleSubmit = (event) => {
  const formData = new FormData(event.currentTarget);
  minutes.value = Number(formData.get("minutes") || 25);
  seconds.value = Number(formData.get("seconds") || 0);
  stopTimer();
};

const selectedTimerMode = ref("focus");
function selectTimerMode(mode) {
  selectedTimerMode.value = mode;
  // set timer duration based on selected mode
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

const activeMenuIndex = ref(-1);
function toggleMenu(index) {
  activeMenuIndex.value = activeMenuIndex.value === index ? -1 : index;
}

const tasks = ref(null);
const user = ref(null);
const authStore = useAuthStore();

onMounted(async () => {
  await authStore.fetchUser();
  user.value = authStore.user;
});

// const getTasks = async () => {
//   if (!authStore.token) return;
//   try {
//     const response = await axios.get("/tasks");
//     if (response.data) {
//       tasks.value = response.data;
//     }
//   } catch (err) {
//     console.error("Error fetching tasks:", err);
//   }
// };

</script>

<style scoped>
.timer {
  font-size: 8rem;
  font-family: "Noto Serif Display", serif;
  font-weight: 700;
}

.btm-panel {
  position: relative;
}

.menu {
  position: absolute;
  bottom: 100%;
}
.menu.right {
  right: 0;
}

.menu-enter-active,
.menu-leave-active {
  transition: all 0.25s cubic-bezier(0, 0.55, 0.45, 1);
}
.menu-enter-from,
.menu-leave-to {
  opacity: 0;
  visibility: hidden;
  transform: translateY(10px);
}

body {
  font-family: "DM Sans", sans-serif;
}
</style>
