<script setup>
import SelectTimerButton from "../../atoms/Button/SelectTimerButton.vue";

const props = defineProps({
  selectedTimerMode: {
    type: String,
    required: true,
  },
  focusMinute: {
    type: Number,
    default: 25,
  },
  shortBreakMinute: {
    type: Number,
    default: 5,
  },
  longBreakMinute: {
    type: Number,
    default: 15,
  },
});

const emit = defineEmits(["selectTimerMode"]);

function handleSelect(mode) {
  emit("selectTimerMode", mode);
}
</script>

<template>
    <!-- minute should be dynamic based on user settings -->
    <div class="flex grid-cols-3 gap-x-4 mt-6 text-sm md:text-md lg:text-md">
          <SelectTimerButton
            mode="focus"
            :selectedTimerMode="selectedTimerMode"
            :minute="focusMinute"
            @select="handleSelect"
          />

          <SelectTimerButton
            mode="short break"
            :selectedTimerMode="selectedTimerMode"
            :minute="shortBreakMinute"
            @select="handleSelect"
          />
          <SelectTimerButton
            mode="long break"
            :selectedTimerMode="selectedTimerMode"
            :minute="longBreakMinute"
            @select="handleSelect"
          />
        </div>
</template>
