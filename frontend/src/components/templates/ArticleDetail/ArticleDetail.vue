<template>
  <div class="min-h-screen flex flex-col bg-gray-50">
    <Header />
    
    <main class="flex-1 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 w-full">
      <ArticleDetailComponent :article="article" />
    </main>
    
    <Footer />
  </div>
</template>

<script setup>
import Header from '../../organisms/Header/Header.vue';
import Footer from '../../organisms/Footer/Footer.vue';
import ArticleDetailComponent from '../../organisms/ArticleDetail/ArticleDetail.vue';

defineProps({
  article: {
    type: Object,
    required: true,
  },
});
</script>
