<template>
  <div class="min-h-screen flex flex-col bg-gray-50">
    <Header />
    
    <main class="flex-1 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 w-full">
      <div class="mb-8">
        <Heading :level="1" size="3xl" class="mb-2">
          Article Archive
        </Heading>
        <Text as="p" size="lg" color="muted">
          Browse our collection of articles
        </Text>
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
