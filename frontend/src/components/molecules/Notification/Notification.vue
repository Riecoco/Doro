<script setup>
import SuccessMessage from "../../atoms/SuccessMessage/SucessMessage.vue";
import ErrorMessage from "../../atoms/ErrorMessage/ErrorMessage.vue";
import { useAuthStore } from "../../../stores/auth.js";
import { useQuotesStore } from "../../../stores/quotes.js";
import { useTasksStore } from "../../../stores/tasks.js";

const authStore = useAuthStore();
const quotesStore = useQuotesStore();
const tasksStore = useTasksStore();

function clearSuccess() {
  authStore.success = null;
  quotesStore.success = null;
}

function clearError() {
  authStore.error = null;
  quotesStore.error = null;
  tasksStore.error = null;
}
</script>

<template>
        <SuccessMessage
            :message="authStore.success || quotesStore.success || ''"
            @close="clearSuccess"
        />
        <ErrorMessage
            :message="authStore.error || quotesStore.error || tasksStore.error || ''"
            @close="clearError"
        />

</template>
