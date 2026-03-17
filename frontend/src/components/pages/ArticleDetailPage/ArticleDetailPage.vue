<template>
  <div>
    <!-- Loading State -->
    <div v-if="isLoading" class="min-h-screen flex items-center justify-center">
      <div class="text-center">
        <div
          class="inline-block animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600 mb-4"
        ></div>
        <p class="text-gray-600">Loading article...</p>
      </div>
    </div>

    <!-- Error State -->
    <div
      v-else-if="isError"
      class="min-h-screen flex items-center justify-center"
    >
      <div class="text-center max-w-md">
        <h2 class="text-2xl font-bold text-gray-900 mb-2">
          Error Loading Article
        </h2>
        <p class="text-gray-600 mb-4">
          {{ error?.response?.status === 404 ? "Article not found" : (error?.response?.data?.message || error?.message || "Failed to load article. Please try again later.") }}
        </p>
      </div>
    </div>

    <!-- Article Detail Template -->
    <ArticleDetailTemplate
      v-else-if="article"
      :article="article || null"
    />
  </div>
</template>

<script setup>
import { useRoute } from "vue-router";
import ArticleDetailTemplate from "../../templates/ArticleDetail/ArticleDetail.vue";
import { useArticle } from "../../../queries/article.js";

const route = useRoute();
const { data: article, isLoading, isError, error } = useArticle(route.params.id);
</script>
