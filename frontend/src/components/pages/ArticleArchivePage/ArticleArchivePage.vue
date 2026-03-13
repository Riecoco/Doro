<template>
  <div>
    <!-- Loading State -->
    <div v-if="loading" class="min-h-screen flex items-center justify-center">
      <div class="text-center">
        <div
          class="inline-block animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600 mb-4"
        ></div>
        <p class="text-gray-600">Loading articles...</p>
      </div>
    </div>

    <!-- Error State -->
    <div
      v-else-if="error"
      class="min-h-screen flex items-center justify-center"
    >
      <div class="text-center max-w-md">
        <h2 class="text-2xl font-bold text-gray-900 mb-2">
          Error Loading Articles
        </h2>
        <p class="text-gray-600 mb-4">{{ error }}</p>
        <button
          @click="fetchArticles"
          class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors"
        >
          Try Again
        </button>
      </div>
    </div>

    <!-- Article Archive Template -->
    <ArticleArchive
      v-else
      :articles="articles"
    />
  </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import ArticleArchive from "../../templates/ArticleArchive/ArticleArchive.vue";
import axios from "../../../utils/axios.js";

const articles = ref([]);
const loading = ref(true);
const error = ref(null);

/**
 * Fetch articles from the API
 */
const fetchArticles = async () => {
  loading.value = true;
  error.value = null;

  try {
    const response = await axios.get("/articles");
    articles.value = response.data;
  } catch (err) {
    console.error("Error fetching articles:", err);
    error.value =
      err.response?.data?.message || err.message || "Failed to load articles. Please try again later.";
    articles.value = [];
  } finally {
    loading.value = false;
  }
};

// Fetch articles when component is mounted
onMounted(() => {
  fetchArticles();
});
</script>
