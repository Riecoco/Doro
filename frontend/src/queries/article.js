import { useQuery, useMutation, useQueryClient } from '@tanstack/vue-query'
import axios from '../utils/axios.js'

/**
 * Query keys for article queries
 */
export const articleKeys = {
  all: ['articles'],
  lists: () => [...articleKeys.all, 'list'],
  list: (filters) => [...articleKeys.lists(), { filters }],
  details: () => [...articleKeys.all, 'detail'],
  detail: (id) => [...articleKeys.details(), id],
}

/**
 * Fetch all articles
 */
export function useArticles() {
  return useQuery({
    queryKey: articleKeys.lists(),
    queryFn: async () => {
      const response = await axios.get('/articles')
      return response.data
    },
  })
}

/**
 * Fetch a single article by ID
 * @param {number|string} articleId - Article ID
 */
export function useArticle(articleId) {
  return useQuery({
    queryKey: articleKeys.detail(articleId),
    queryFn: async () => {
      if (!articleId) {
        throw new Error('Article ID is missing')
      }
      const response = await axios.get(`/articles/${articleId}`)
      return response.data
    },
    enabled: !!articleId,
  })
}

/**
 * Create a new article
 */
export function useCreateArticle() {
  const queryClient = useQueryClient()

  return useMutation({
    mutationFn: async (article) => {
      const response = await axios.post('/articles', article)
      return response.data
    },
    onSuccess: () => {
      // Invalidate and refetch articles list
      queryClient.invalidateQueries({ queryKey: articleKeys.lists() })
    },
  })
}

/**
 * Update an existing article
 */
export function useUpdateArticle() {
  const queryClient = useQueryClient()

  return useMutation({
    mutationFn: async (article) => {
      const articleId = article.id || article._id
      const response = await axios.put(`/articles/${articleId}`, article)
      return response.data
    },
    onSuccess: (data, variables) => {
      const articleId = variables.id || variables._id
      // Invalidate and refetch articles list and the specific article
      queryClient.invalidateQueries({ queryKey: articleKeys.lists() })
      queryClient.invalidateQueries({ queryKey: articleKeys.detail(articleId) })
    },
  })
}
