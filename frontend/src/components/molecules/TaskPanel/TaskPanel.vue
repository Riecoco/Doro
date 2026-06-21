<script setup>
import { ref, onMounted } from 'vue';
import TaskFilter from '../../atoms/TaskFilter/TaskFilter.vue';
import TaskForm from '../../atoms/TaskInput/TaskInput.vue';
import TaskItem from '../../atoms/TaskItem/TaskItem.vue';
import { useTasksStore } from '../../../stores/tasks';
import Loader from '../../atoms/Loader/Loader.vue';

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
    <div v-if="tasksStore.loading" class="flex h-60 flex-col items-center justify-center gap-2">
        <Loader />
        <p class="text-gray-300">Loading...</p>
    </div>
    <div v-else class="flex flex-col gap-3 m-4 pr-3 font-dm-sans scroll overflow-y-auto touch-pan-y h-60">
        <div class="flex w-full gap-2">
            <TaskFilter @completedStatus="handleCompletedStatus"/>
        </div>
        <TaskForm v-if="filterStatus === false" @add="addTask"/>
        <TaskItem v-if="tasks.length > 0" v-for="task in tasks" :key="task.id" :task="task" @delete="deleteTask" @update="updateTask" @toggle-complete="toggleComplete"/>
        <div v-else class="text-gray-300 text-center mt-4">No tasks available.</div>
    </div>
</template>
