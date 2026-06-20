<script setup>
import { useTemplateRef } from 'vue'
import { ref } from 'vue';

const target = useTemplateRef('target')
const task = ref('');
const emit = defineEmits(['add']);

const handleAddTask = () => {
    if (task.value.trim() !== '') {
        emit('add', task.value);
        task.value = '';
    }
};
</script>

<template>
    <div class="flex flex-row gap-2">
        <div class="flex-6">
        <input
            v-model="task"
            type="text"
            placeholder="+ Add a new task..."
            class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-[#7a560070]"
        />
            </div>
        <button
            @click="handleAddTask"
            class="flex-1 px-4 py-2 bg-[#7a560070] text-white rounded-md hover:bg-[#7a560090] font-bold outline-white/30 outline-1 outline focus:outline-none focus:ring-2 focus:ring-[#7a560070]"
        >
            Add
        </button>
    </div>

</template>