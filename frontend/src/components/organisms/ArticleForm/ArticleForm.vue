<template>
  <form @submit.prevent="onSubmit" class="max-w-3xl mx-auto">
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
      <div class="mb-6">
        <Heading :level="2" size="2xl" class="mb-2">
          {{ isUpdate ? "Edit Article" : "Create Article" }}
        </Heading>
      </div>

      <div v-if="articleStore.error" class="mb-4 p-4 bg-red-50 border-l-4 border-red-500 rounded-md">
        <div class="flex">
          <div class="flex-shrink-0">
            <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
              <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
            </svg>
          </div>
          <div class="ml-3">
            <p class="text-sm font-medium text-red-800">{{ articleStore.error }}</p>
          </div>
        </div>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="md:col-span-2">
          <label class="block text-sm font-medium text-gray-700 mb-1">Title</label>
          <input
            v-model="title"
            type="text"
            class="w-full rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-blue-600 disabled:opacity-50 disabled:cursor-not-allowed"
            placeholder="Article title"
            :disabled="articleStore.loading"
          />
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Author</label>
          <input
            v-model="author"
            type="text"
            class="w-full rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-blue-600 disabled:opacity-50 disabled:cursor-not-allowed"
            placeholder="Author name"
            :disabled="articleStore.loading"
          />
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Category</label>
          <input
            v-model="category"
            type="text"
            class="w-full rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-blue-600 disabled:opacity-50 disabled:cursor-not-allowed"
            placeholder="Category"
            :disabled="articleStore.loading"
          />
        </div>

        <div class="md:col-span-2">
          <label class="block text-sm font-medium text-gray-700 mb-1">Published</label>
          <input
            v-model="published"
            type="date"
            class="w-full rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-blue-600 disabled:opacity-50 disabled:cursor-not-allowed"
            :disabled="articleStore.loading"
          />
        </div>

        <div class="md:col-span-2">
          <label class="block text-sm font-medium text-gray-700 mb-1">Content</label>
          <textarea
            v-model="content"
            rows="10"
            class="w-full rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-blue-600 disabled:opacity-50 disabled:cursor-not-allowed"
            placeholder="Write your article..."
            :disabled="articleStore.loading"
          />
        </div>
      </div>

      <div class="mt-6 flex items-center justify-end gap-3">
        <button
          type="button"
          class="inline-flex items-center justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed"
          @click="router.push('/')"
          :disabled="articleStore.loading"
        >
          Cancel
        </button>
        <button
          type="submit"
          class="inline-flex items-center justify-center rounded-md bg-blue-600 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-700 disabled:opacity-50 disabled:cursor-not-allowed"
          :disabled="articleStore.loading"
        >
          <span v-if="articleStore.loading" class="mr-2">
            <svg class="animate-spin h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
              <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
              <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
          </span>
          {{ isUpdate ? "Update" : "Create" }}
        </button>
      </div>
    </div>
  </form>
</template>

<script setup>
import { ref } from "vue";
import { useRouter } from "vue-router";
import Heading from "../../atoms/Heading/Heading.vue";
import { useArticleStore } from "../../../stores/article.js";

const props = defineProps({
  article: {
    type: Object,
    default: () => ({}),
  },
  isUpdate: {
    type: Boolean,
    default: false,
  },
});

const router = useRouter();
const articleStore = useArticleStore();

const id = ref(props.article?.id);
const title = ref(props.article?.title ?? "");
const author = ref(props.article?.author ?? "");
const category = ref(props.article?.category ?? "");
const published = ref(props.article?.published ?? "");
const content = ref(props.article?.content ?? "");

async function onSubmit() {


  const articleData = {
    title: title.value,
    author: author.value,
    category: category.value,
    published: published.value,
    content: content.value,
  };

  if (props.isUpdate && id.value) {
    articleData.id = id.value;
  }

  try {
    if (props.isUpdate) {
      await articleStore.updateArticle(articleData);
    } else {
      await articleStore.createArticle(articleData);
    }
    router.push("/");
  } catch (error) {
    // Error is handled by the store and displayed in the template
    // The error will be visible in the error display section
  }
}
</script>

