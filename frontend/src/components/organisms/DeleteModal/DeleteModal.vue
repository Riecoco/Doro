<script setup>
import {ref} from 'vue';
import Modal from '../../molecules/Modal/Modal.vue';
import { useQuotesStore } from "../../../stores/quotes";

const quotesStore = useQuotesStore();

const emit = defineEmits(['deleteQuote'])
const isDisabled = ref(false);

const props = defineProps({
    id: {
        type: [Number, String],
        required: true
    }
})

async function deleteQuote() {
    isDisabled.value = true;
    await quotesStore.deleteQuote(props.id);
    await quotesStore.getAllQuotes(quotesStore.currentPage);
    emit('deleteQuote');
    isDisabled.value = false;
}

</script>

<template>
     <Modal
        @close="emit('close')"
        @submit="deleteQuote"
        resource="Quote"
        action="Delete"
        :isDisabled="isDisabled"
        class="space-y-3"
    >
        <p class="text-center text-lg font-dm-sans">Are you sure you want to delete this quote?</p>
        <p class="text-center text-sm text-gray-500 font-dm-sans">This action cannot be undone.</p>
    </Modal>
</template>
