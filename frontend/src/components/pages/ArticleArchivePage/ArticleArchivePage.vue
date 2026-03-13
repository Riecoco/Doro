<template>
  <div>
    <!-- Loading State -->
    <div v-if="articleStore.loading" class="min-h-screen flex items-center justify-center">
      <div class="text-center">
        <div
          class="inline-block animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600 mb-4"
        ></div>
        <p class="text-gray-600">Loading articles...</p>
      </div>
    </div>

    <!-- Error State -->
    <div
      v-else-if="articleStore.error"
      class="min-h-screen flex items-center justify-center"
    >
      <div class="text-center max-w-md">
        <h2 class="text-2xl font-bold text-gray-900 mb-2">
          Error Loading Articles
        </h2>
        <p class="text-gray-600 mb-4">{{ articleStore.error }}</p>
      </div>
    </div>

    <!-- Article Archive Template -->
    <ArticleArchive
      v-else
      :articles="articleStore.articles"
    />
  </div>
</template>

<script setup>
import { onMounted } from "vue";
import ArticleArchive from "../../templates/ArticleArchive/ArticleArchive.vue";
import { useArticleStore } from "../../../stores/article.js";

const articleStore = useArticleStore();

// Fetch articles when component is mounted
onMounted(async () => {
  await articleStore.fetchArticles();
});
</script>
