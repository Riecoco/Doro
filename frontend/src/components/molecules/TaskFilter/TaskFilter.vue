<script setup>
const activeValue = defineModel({
  type: Number,
  default: 0,
});
const options = ['To-Do', 'Completed'];

const list = (index) => {
  return activeValue.value === index
    ? 'bg-olive-950/50 backdrop-blur-md text-white border border-white/20'
    : 'backdrop-blur-md border border-white/20 text-white';
};

const emit = defineEmits(['completedStatus']);

function toggleFilter(index) {
  activeValue.value = index;
  emit('completedStatus', activeValue.value === 1);
}

</script>

<template>
  <button
    v-for="(option, index) in options"
    :key="option"
    :class="[list(index), 'flex-1 px-3 py-2 rounded-md hover:bg-[#7a560050] font-bold']"
    @click="toggleFilter(index)"
  >
    {{ option }}
  </button>
</template>
