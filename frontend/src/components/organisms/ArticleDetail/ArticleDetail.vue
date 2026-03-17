<template>
  <article class="max-w-4xl mx-auto">
    <div class="mb-6 flex justify-between items-center">
      <router-link
        to="/"
        class="inline-flex items-center text-blue-600 hover:text-blue-700 transition-colors"
      >
        <svg
          class="w-5 h-5 mr-2"
          fill="none"
          stroke="currentColor"
          viewBox="0 0 24 24"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M15 19l-7-7 7-7"
          />
        </svg>
        Back to Articles
      </router-link>
      <router-link
        :to="`/articles/${article.id}/edit`"
        class="inline-flex items-center justify-center rounded-md bg-blue-600 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-700 transition-colors"
      >
        <svg class="h-4 w-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
          <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
        </svg>
        Edit Article
      </router-link>
    </div>
    
    <header class="mb-6">
      <div class="mb-4">
        <CategoryBadge :category="article.category" />
      </div>
      
      <Heading :level="1" size="3xl" class="mb-4">
        {{ article.title }}
      </Heading>
      
      <ArticleMeta 
        :author="article.author" 
        :published="article.published" 
        class="mb-6"
      />
    </header>
    
    <div class="prose prose-lg max-w-none">
      <Text 
        as="div" 
        size="base" 
        color="default"
        class="whitespace-pre-line leading-relaxed"
      >
        {{ article.content }}
      </Text>
    </div>
  </article>
</template>

<script setup>
import Heading from '../../atoms/Heading/Heading.vue';
import Text from '../../atoms/Text/Text.vue';
import ArticleMeta from '../../molecules/ArticleMeta/ArticleMeta.vue';
import CategoryBadge from '../../molecules/CategoryBadge/CategoryBadge.vue';

defineProps({
  article: {
    type: Object,
    required: true,
    validator: (value) => {
      return value.id && value.title && value.author && value.category && value.published && value.content;
    },
  },
});
</script>

<style scoped>
.prose {
  color: #374151;
}

.prose p {
  margin-bottom: 1.25em;
}
</style>
