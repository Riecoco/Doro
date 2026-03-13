import { defineStore } from 'pinia'
import { ref } from 'vue'
import axios from '../utils/axios.js'

export const useArticleStore = defineStore('article', () => {
  // State
  const articles = ref([])
  const currentArticle = ref(null)
  const loading = ref(false)
  const error = ref(null)

  // Actions
  /**
   * Fetch all articles from the API
   */
  async function fetchArticles() {
    loading.value = true
    error.value = null

    try {
      const response = await axios.get('/articles')
      articles.value = response.data
      return response.data
    } catch (err) {
      console.error('Error fetching articles:', err)
      error.value =
        err.response?.data?.message || err.message || 'Failed to load articles. Please try again later.'
      articles.value = []
      throw err
    } finally {
      loading.value = false
    }
  }

  /**
   * Fetch a single article by ID from the API
   * @param {number|string} articleId - Article ID
   */
  async function fetchArticleById(articleId) {
    console.log("Fetching article by ID:", articleId);
    if (!articleId) {
      error.value = 'Article ID is missing'
      loading.value = false
      return null
    }

    loading.value = true
    error.value = null
    currentArticle.value = null

    try {
      const response = await axios.get(`/articles/${articleId}`)
      currentArticle.value = response.data
      console.log("Article fetched:", currentArticle.value);
      return response.data
    } catch (err) {
      console.error('Error fetching article:', err)
      if (err.response?.status === 404) {
        error.value = 'Article not found'
      } else {
        error.value =
          err.response?.data?.message || err.message || 'Failed to load article. Please try again later.'
      }
      currentArticle.value = null
      throw err
    } finally {
      loading.value = false
    }
  }

  return {
    // State
    articles,
    currentArticle,
    loading,
    error,
    // Getters
    getArticleById,
    // Actions
    fetchArticles,
    fetchArticleById,
  }
})
