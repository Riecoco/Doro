<script setup>
import {ref} from 'vue';
import Modal from '../../molecules/Modal/Modal.vue';
import FormInput from '../../atoms/FormInput/FormInput.vue';

const props = defineProps({
  action: {
    type: String,
    required: true
  },
  quote: {
    type: Object,
    default: null
  }
})

const emit = defineEmits(['submitQuote'])

const text = ref(props.quote?.text ?? "");
const author = ref(props.quote?.author ?? "");

function submitQuote(){
  emit('submitQuote', {
    text: text.value.trim(),
    author: author.value.trim()
  })
}

</script>

<template>
  <Modal @submit="submitQuote" resource="Quote" :action="props.action" class="space-y-3">
    <textarea  v-model="text" id="message" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-white rounded-lg border border-gray-300 outline-indigo-500 focus:ring-blue-500 focus:border-blue-500 max-h-40 overflow-auto" placeholder="Your message..."></textarea>
    <FormInput v-model="author" type="text" label="author" placeholder="Simon Fable"/>
  </Modal>
</template>
