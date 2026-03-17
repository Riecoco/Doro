<template>
  <div class="min-h-screen flex flex-col bg-gray-50">
    <Header />
    
    <main class="flex-1 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 w-full">
      <div class="mb-8 flex justify-between items-center">
        <div>
          <Heading :level="1" size="3xl" class="mb-2">
            Article Archive
          </Heading>
          <Text as="p" size="lg" color="muted">
            Browse our collection of articles
          </Text>
        </div>
        <router-link
          to="/articles/create"
          class="inline-flex items-center justify-center rounded-md bg-blue-600 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-700 transition-colors"
        >
          <svg class="h-5 w-5 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
            <path d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" />
          </svg>
          Create Article
        </router-link>
      </div>
      
      
      <!-- Article Grid -->
      <div v-if="articles && articles.length > 0" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <ArticleCard
          v-for="article in articles"
          :key="article.id"
          :article="article"
        />
      </div>
      
      <!-- Empty State -->
      <div v-else class="text-center py-12">
        <Text as="p" size="lg" color="muted">
          No articles found.
        </Text>
      </div>
      
    </main>
    
    <Footer />
  </div>
</template>

<script setup>
import Header from '../../organisms/Header/Header.vue';
import Footer from '../../organisms/Footer/Footer.vue';
import ArticleCard from '../../organisms/ArticleCard/ArticleCard.vue';
import Heading from '../../atoms/Heading/Heading.vue';
import Text from '../../atoms/Text/Text.vue';

defineProps({
  articles: {
    type: Array,
    default: () => [],
  },
  showFilters: {
    type: Boolean,
    default: false,
  },
  showPagination: {
    type: Boolean,
    default: false,
  },
});
</script>
