import { defineStore } from 'pinia'
import { ref } from 'vue'
import axios from '../utils/axios.js'

export const useTasksStore = defineStore('tasks', () => {
    const tasks = ref([]);
    const currentTask = ref(null);
    const loading = ref(false);
    const error = ref(null);

    async function getTaskById(id) {
        try {
            const response = await axios.get(`/tasks/${id}`);
            currentTask.value = response.data;
            return currentTask.value;
        } catch (err) {
            error.value = err.response?.data?.error || 'Failed to fetch task';
            return null;
        }
    }

    async function getAllTasksByStatus(isCompleted, showLoading = true) {
        if (showLoading) loading.value = true;
        try {
            const response = await axios.get('/tasks', {
                params: {
                    isCompleted: isCompleted
                }
            });
            tasks.value = response.data;
            return tasks.value;
        } catch (err) {
            error.value = err.response?.data?.error || 'Failed to fetch tasks';
            tasks.value = [];
            return [];
        } finally {
            if (showLoading) loading.value = false;
        }
    }

    async function createTask(taskData) {
        try{
            const response = await axios.post('/tasks', taskData);
            return response.data;
        } catch (err) {
            error.value = err.response?.data?.error || 'Failed to create task';
            return null;
        }
    }

    async function updateTask(id, taskData) {
        try {
            const response = await axios.patch(`/tasks/${id}`, taskData);
            return response.data;
        } catch (err) {
            error.value = err.response?.data?.error || 'Failed to update task';
            return null;
        }
    }

    async function deleteTask(id) {
        try {
            await axios.delete(`/tasks/${id}`);
            return true;
        } catch (err) {
            error.value = err.response?.data?.error || 'Failed to delete task';
            return false;
        }
    }

    return {
        tasks,
        currentTask,
        loading,
        error,
        getTaskById,
        getAllTasksByStatus,
        createTask,
        updateTask,
        deleteTask
    };
});
