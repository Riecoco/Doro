<script setup>
import Modal from '../../molecules/Modal/Modal.vue';
import { useQuotesStore } from "../../../stores/quotes";

const quotesStore = useQuotesStore();

defineEmits(['deleteQuote'])

defineProps({
    id: {
        type: Number,
        required: true
    }
})

function deleteQuote() {
    quotesStore.deleteQuote(props.id);
    emit('deleteQuote');
}

</script>

<template>
    <Modal @submit="deleteQuote()" resource="Quote" :action="'Delete'" class="space-y-3">
        <p class="text-center text-lg font-dm-sans">Are you sure you want to delete this quote?</p>
        <p class="text-center text-sm text-gray-500 font-dm-sans">This action cannot be undone.</p>
    </Modal>
</template>