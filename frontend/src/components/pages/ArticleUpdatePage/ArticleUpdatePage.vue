<template>
  <div>
    <!-- Loading State -->
    <div v-if="articleStore.loading" class="min-h-screen flex items-center justify-center">
      <div class="text-center">
        <div
          class="inline-block animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600 mb-4"
        ></div>
        <p class="text-gray-600">Loading article...</p>
      </div>
    </div>

    <!-- Error State -->
    <div
      v-else-if="articleStore.error"
      class="min-h-screen flex items-center justify-center"
    >
      <div class="text-center max-w-md">
        <h2 class="text-2xl font-bold text-gray-900 mb-2">
          Error Loading Article
        </h2>
        <p class="text-gray-600 mb-4">{{ articleStore.error }}</p>
        <button
          @click="router.push('/')"
          class="mt-4 inline-flex items-center justify-center rounded-md bg-blue-600 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-700"
        >
          Go Home
        </button>
      </div>
    </div>

    <!-- Article Form -->
    <div v-else-if="articleStore.currentArticle" class="min-h-screen flex flex-col bg-gray-50">
      <Header />
      <main class="flex-1 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 w-full">
        <ArticleForm :article="articleStore.currentArticle" :is-update="true" />
      </main>
      <Footer />
    </div>
  </div>
</template>

<script setup>
import { onMounted } from "vue";
import { useRoute, useRouter } from "vue-router";
import Header from "../../organisms/Header/Header.vue";
import Footer from "../../organisms/Footer/Footer.vue";
import ArticleForm from "../../organisms/ArticleForm/ArticleForm.vue";
import { useArticleStore } from "../../../stores/article.js";

const route = useRoute();
const router = useRouter();
const articleStore = useArticleStore();

// Fetch article when component is mounted
onMounted(async () => {
  await articleStore.fetchArticleById(route.params.id);
});
</script>
