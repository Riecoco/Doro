<script setup>
import { ref, reactive, computed, onMounted } from 'vue';
import TaskFilter from './atoms/TaskFilter/TaskFilter.vue';
import TaskForm from './atoms/TaskInput/TaskInput.vue';
import TaskItem from './atoms/TaskItem/TaskItem.vue';
import { useTasksStore } from '../stores/tasks';

const tasksStore = useTasksStore();
const tasks = ref([]);
const filterStatus = ref(false);

onMounted(async () => {
    tasks.value = await tasksStore.getAllTasksByStatus(false);
});

const handleCompletedStatus = async (isCompleted) => {
    filterStatus.value = isCompleted;
    tasks.value = await tasksStore.getAllTasksByStatus(isCompleted);
};

async function addTask(title) {
    await tasksStore.createTask({ title });
    tasks.value = await tasksStore.getAllTasksByStatus(filterStatus.value);
}

async function updateTask({ id, title }) {
    await tasksStore.updateTask(id, { title });
    tasks.value = await tasksStore.getAllTasksByStatus(filterStatus.value);
}

async function deleteTask(taskId) {
    await tasksStore.deleteTask(taskId);
    tasks.value = await tasksStore.getAllTasksByStatus(filterStatus.value);
}

async function toggleComplete(task) {
    await tasksStore.updateTask(task.id, { isCompleted: !task.isCompleted });
    tasks.value = await tasksStore.getAllTasksByStatus(filterStatus.value);
}


</script>

<template>
    <div class="flex flex-col gap-3 m-4 font-dm-sans">
        <div class="flex w-full gap-2">
            <TaskFilter @completedStatus="handleCompletedStatus"/>
        </div>
        <TaskForm @add="addTask"/>
        <TaskItem v-if="tasks.length > 0" v-for="task in tasks" :key="task.id" :task="task" @delete="deleteTask" @update="updateTask" @toggle-complete="toggleComplete"/>
        <div v-else class="text-gray-500 text-center mt-4">No tasks available.</div>
    </div>
</template>
