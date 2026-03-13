<template>
  <div>
    <!-- Loading State -->
    <div v-if="loading" class="min-h-screen flex items-center justify-center">
      <div class="text-center">
        <div
          class="inline-block animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600 mb-4"
        ></div>
        <p class="text-gray-600">Loading article...</p>
      </div>
    </div>

    <!-- Error State -->
    <div
      v-else-if="error"
      class="min-h-screen flex items-center justify-center"
    >
      <div class="text-center max-w-md">
        <div class="text-red-600 text-5xl mb-4">⚠️</div>
        <h2 class="text-2xl font-bold text-gray-900 mb-2">
          Error Loading Article
        </h2>
        <p class="text-gray-600 mb-4">{{ error }}</p>
        <div class="flex gap-4 justify-center">
          <button
            @click="fetchArticle"
            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors"
          >
            Try Again
          </button>
          <router-link
            to="/"
            class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors"
          >
            Back to Articles
          </router-link>
        </div>
      </div>
    </div>

    <!-- Article Detail Template -->
    <ArticleDetailTemplate
      v-else-if="article"
      :article="article"
    />
  </div>
</template>

<script setup>
import { ref, onMounted, watch } from "vue";
import { useRoute } from "vue-router";
import ArticleDetailTemplate from "../../templates/ArticleDetail/ArticleDetail.vue";
import { get } from "../../../utils/api.js";

const route = useRoute();

const article = ref(null);
const loading = ref(true);
const error = ref(null);

/**
 * Fetch article from the API
 */
const fetchArticle = async () => {
  const articleId = route.params.id;
  
  if (!articleId) {
    error.value = "Article ID is missing";
    loading.value = false;
    return;
  }

  loading.value = true;
  error.value = null;

  try {
    const response = await get(`/articles/${articleId}`);

    if (!response.ok) {
      if (response.status === 404) {
        throw new Error("Article not found");
      }
      throw new Error(
        `Failed to fetch article: ${response.status} ${response.statusText}`,
      );
    }

    const data = await response.json();
    article.value = data;
  } catch (err) {
    console.error("Error fetching article:", err);
    error.value =
      err.message || "Failed to load article. Please try again later.";
    article.value = null;
  } finally {
    loading.value = false;
  }
};

// Fetch article when component is mounted
onMounted(() => {
  fetchArticle();
});

// Watch for route changes (e.g., navigating from one article to another)
watch(() => route.params.id, () => {
  fetchArticle();
});
</script>
