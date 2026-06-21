<script setup>
import Play from "../../atoms/Icons/Play.vue";
import Pause from "../../atoms/Icons/Pause.vue";
import CycleIcon from "../../atoms/Icons/CycleIcon.vue";

const props = defineProps({
    hasStarted: {
        type: Boolean,
        required: true,
    },
    isRunning: {
        type: Boolean,
        required: true,
    },
})

const emit = defineEmits(["startTimer", "pauseTimer", "resumeTimer", "stopTimer"]);
</script>

<template>
    <div class="grid grid-cols-2 gap-4">
        <div v-if="!props.hasStarted">
            <button @click="emit('startTimer')" class="mt-4 py-2 px-2 cursor-pointer">
              <Play />
            </button>
        </div>
        <div v-else-if="props.hasStarted && props.isRunning">
            <button @click="emit('pauseTimer')" class="mt-4 py-2 px-2 cursor-pointer">
              <Pause />
            </button>
        </div>
        <div v-else-if="props.hasStarted && !props.isRunning">
            <button
              @click="emit('resumeTimer')"
              class="mt-4 py-2 px-2 cursor-pointer"
            >
              <Play />
            </button>
        </div>
        <button @click="emit('stopTimer')" class="mt-4 py-2 px-2 cursor-pointer">
            <CycleIcon />
        </button>
    </div>
</template>