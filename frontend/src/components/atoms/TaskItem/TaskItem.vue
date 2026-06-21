<script setup>
import { ref } from 'vue';
import Trash from '../Icons/Trash.vue';
import { onClickOutside } from '@vueuse/core';
import { useTemplateRef } from 'vue';

    /**
      * TaskItem behavior
      *
      * Normal state:
      * - Show task as a small card.
      * - Show checkbox/tick button for completed.
      * - Show delete button.
      *
      * Editing state:
      * - When the user clicks the task text, replace the text with an input.
      * - The input starts with the current task title.
      * - When the input loses focus, save the change.
      * - If the text is empty, cancel the edit and restore the old value.
      *
      */

const props = defineProps({
  task: {
    type: Object,
    required: true
  }
})

const emit = defineEmits(['update', 'delete', 'toggle-complete'])

const editTarget = useTemplateRef('editTarget');
const editMode = ref(false);
const taskTitle = ref(props.task.title);

function startEditing() {
  taskTitle.value = props.task.title
  editMode.value = true
}

function saveTask() {
  const trimmedTitle = taskTitle.value.trim()

  if (trimmedTitle === '') {
    taskTitle.value = props.task.title
    editMode.value = false
    return
  }

  if (trimmedTitle !== props.task.title) {
    emit('update', {
      ...props.task,
      title: trimmedTitle
    })
  }

  editMode.value = false
}

function cancelEdit() {
  taskTitle.value = props.task.title
  editMode.value = false
}

onClickOutside(editTarget, () => {
  if (editMode.value) {
    saveTask()
  }
})

</script>

<template>
    <div>
        <div class="flex items-center justify-between p-4 backdrop-blur-md bg-black/20 rounded-md shadow-sm">
            <div class="flex items-center gap-3">
                <input type="checkbox" :checked="task.isCompleted" @click="emit('toggle-complete', props.task)" class="form-checkbox h-5 w-5" />
                <div>
                    <input
                        v-if="editMode"
                        ref="editTarget"
                        type="text"
                        v-model="taskTitle"
                        @keyup.enter="saveTask"
                        @keyup.esc="cancelEdit"
                        class="border-none text-white text-md font-medium focus:ring-0 focus:outline-none grow-0"
                    />
                    <span v-else class="text-white" @click="startEditing">{{ task.title }}</span>
                </div>
            </div>
            <button class="text-red-500 hover:text-red-700 focus:outline-none" @click="emit('delete', props.task.id)">
                <Trash />
            </button>
        </div>
    </div>
</template>
