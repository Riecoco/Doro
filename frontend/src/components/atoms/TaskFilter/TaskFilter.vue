<script setup>
const activeValue = defineModel({
  type: Number,
  default: 0,
});
const options = ['To-Do', 'Completed'];

const list = (index) => {
  return activeValue.value === index
    ? 'bg-olive-950/50'
    : ' ';
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
    :class="[list(index), 'flex-1 px-3 py-2 border border-white/20 text-white backdrop-blur-md rounded-md hover:bg-[#7a560050] font-bold text-sm md:text-md lg:text-md']"
    @click="toggleFilter(index)"
  >
    {{ option }}
  </button>
</template>
