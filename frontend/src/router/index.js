import { createRouter, createWebHistory } from 'vue-router'
import ArticleArchivePage from '../components/pages/ArticleArchivePage/ArticleArchivePage.vue'
import ArticleDetailPage from '../components/pages/ArticleDetailPage/ArticleDetailPage.vue'
import ArticleCreatePage from '../components/pages/ArticleCreatePage/ArticleCreatePage.vue'
import ArticleUpdatePage from '../components/pages/ArticleUpdatePage/ArticleUpdatePage.vue'

const router = createRouter({
  history: createWebHistory(),
  routes: [
    {
      path: '/',
      name: 'home',
      component: ArticleArchivePage
    },
    {
      path: '/articles/create',
      name: 'article-create',
      component: ArticleCreatePage
    },
    {
      path: '/articles/:id/edit',
      name: 'article-update',
      component: ArticleUpdatePage,
      props: true
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
