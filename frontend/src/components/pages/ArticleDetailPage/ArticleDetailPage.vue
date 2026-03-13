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
      </div>
    </div>

    <!-- Article Detail Template -->
    <ArticleDetailTemplate
      v-else-if="articleStore.currentArticle"
      :article="articleStore.currentArticle || null"
    />
  </div>
</template>

<script setup>
import { onMounted, watch } from "vue";
import { useRoute } from "vue-router";
import ArticleDetailTemplate from "../../templates/ArticleDetail/ArticleDetail.vue";
import { useArticleStore } from "../../../stores/article.js";

const route = useRoute();
const articleStore = useArticleStore();

// Fetch article when component is mounted
onMounted(async () => {
  await articleStore.fetchArticleById(route.params.id);
});

</script>
