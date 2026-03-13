import { createRouter, createWebHistory } from 'vue-router'
import ArticleArchivePage from '../components/pages/ArticleArchivePage/ArticleArchivePage.vue'
import ArticleDetailPage from '../components/pages/ArticleDetailPage/ArticleDetailPage.vue'

const router = createRouter({
  history: createWebHistory(),
  routes: [
    {
      path: '/',
      name: 'home',
      component: ArticleArchivePage
    },
    {
      path: '/articles/:id',
      name: 'article-detail',
      component: ArticleDetailPage,
      props: true
    }
  ]
})

export default router
