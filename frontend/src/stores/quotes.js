import { defineStore } from 'pinia'
import { ref, computed } from 'vue'
import axios from '../utils/axios.js'

export const useQuotesStore = defineStore('quotes', () => {
    const quotes = ref([]);
    const currentQuote = ref(null);
    const currentPage = ref(1);
    const totalPages = ref(1);
    const loading = ref(false);
    const error = ref(null);
    const success = ref(null);

    const showQuotes = ref(
        JSON.parse(localStorage.getItem("show_quotes") ?? "true")
    );

    function setShowQuotes(value) {
        showQuotes.value = value;
        localStorage.setItem("show_quotes", JSON.stringify(value));
    }

    async function getQuoteById(id) {
        loading.value = true;
        try {
            const response = await axios.get(`/quotes/${id}`);
            currentQuote.value = response.data;
            return currentQuote.value;
        } catch (err) {
            error.value = err.response?.data?.error || 'Failed to fetch quote';
            return null;
        } finally {
            loading.value = false;
        }
    }

    async function getRandomQuote() {
        loading.value = true;
        try {
            const response = await axios.get('/quotes/random');
            currentQuote.value = response.data;
            return currentQuote.value;
        }
        catch (err) {
            error.value = err.response?.data?.error || 'Failed to fetch random quote';
            return null;
        }
        finally {
            loading.value = false;
        }
    }

    async function getAllQuotes(page = currentPage.value) {
        loading.value = true;
        try {
            const response = await axios.get('/quotes', {
                params: {
                    page: page
                }
            });
            quotes.value = response.data.quotes ?? [];
            totalPages.value = response.data.totalPages ?? 1;
            currentPage.value = page;

            return quotes.value;
        } catch (err) {
            error.value = err.response?.data?.error || 'Failed to fetch quotes';
            quotes.value = [];
            return [];
        } finally {
            loading.value = false;
        }
    }

    async function createQuote(quoteData) {
        loading.value = true;
        try {
            const response = await axios.post('/quotes', quoteData);
            quotes.value.push(response.data);
            success.value = response.data.message || "Quote created successfully!";
            return response.data.quote || response.data;
        }
        catch (err) {
            error.value = err.response?.data?.error || 'Failed to create quote';
            return null;
        }
        finally {
            loading.value = false;
        }
    }

    async function updateQuote(id, quoteData) {
        loading.value = true;
        try {
            const response = await axios.patch(`/quotes/${id}`, quoteData);
            const index = quotes.value.findIndex(q => q.id === id);
            if (index !== -1) {
                quotes.value[index] = response.data;
            }
            success.value = response.data.message || "Quote updated successfully!";
            return response.data.quote || response.data;
        }
        catch (err) {
            error.value = err.response?.data?.error || 'Failed to update quote';
            return null;
        }
        finally {
            loading.value = false;
        }
    }

    async function deleteQuote(id) {
        loading.value = true;
        try {
            const response = await axios.delete(`/quotes/${id}`);
            quotes.value = quotes.value.filter(q => q.id !== id);
            success.value = response.data.message || "Quote deleted successfully!";
            return true;
        }
        catch (err) {
            error.value = err.response?.data?.error || 'Failed to delete quote';
            return false;
        }
        finally {
            loading.value = false;
        }
    }


    return {
        quotes,
        currentQuote,
        currentPage,
        totalPages,
        loading,
        error,
        success,
        getQuoteById,
        getRandomQuote,
        getAllQuotes,
        createQuote,
        updateQuote,
        deleteQuote,
        showQuotes,
        setShowQuotes,
    }
})
