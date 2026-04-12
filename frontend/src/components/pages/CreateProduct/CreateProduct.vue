<template>
  <div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="bg-white rounded-lg shadow-md p-6">
        <h1 class="text-3xl font-bold text-gray-900 mb-6">
          Create New Product
        </h1>

        <form @submit.prevent="handleSubmit" class="space-y-6">
          <div>
            <div></div>
            <label
              for="name"
              class="block text-sm font-medium text-gray-700 mb-2"
            >
              Product Name *
            </label>
            <input
              id="name"
              v-model="form.name"
              type="text"
              required
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
              placeholder="Enter product name"
            />
          </div>

          <div>
            <label
              for="price"
              class="block text-sm font-medium text-gray-700 mb-2"
            >
              Price *
            </label>
            <input
              id="price"
              v-model.number="form.price"
              type="number"
              step="0.01"
              min="0"
              required
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
              placeholder="0.00"
            />
          </div>

          <div>
            <label
              for="description"
              class="block text-sm font-medium text-gray-700 mb-2"
            >
              Description *
            </label>
            <textarea
              id="description"
              v-model="form.description"
              required
              rows="4"
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
              placeholder="Enter product description"
            ></textarea>
          </div>

          <div>
            <label
              for="category_id"
              class="block text-sm font-medium text-gray-700 mb-2"
            >
              Category *
            </label>
            <select
              id="category_id"
              v-model.number="form.category_id"
              required
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
            >
              <option value="" disabled>Select a category</option>
              <option
                v-for="category in categories"
                :key="category.id"
                :value="category.id"
              >
                {{ category.name }}
              </option>
            </select>
          </div>

          <div
            v-if="error"
            class="bg-red-50 border border-red-200 rounded-lg p-4"
          >
            <p class="text-red-800 text-sm">{{ error }}</p>
          </div>

          <div class="flex gap-4">
            <button
              type="submit"
              :disabled="loading"
              class="flex-1 px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium disabled:opacity-50 disabled:cursor-not-allowed"
            >
              {{ loading ? "Saving..." : "Create Product" }}
            </button>
            <router-link
              to="/"
              class="px-6 py-3 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors font-medium"
            >
              Cancel
            </router-link>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import { useRouter } from "vue-router";
import axios from "axios";
import config from "../../../config.js";

const router = useRouter();

const form = ref({
  name: "",
  price: 0,
  description: "",
  category_id: 1,
});

const loading = ref(false);
const error = ref(null);
const categories = ref([]);

const baseUrl = config.apiDomain;

/**
 * Fetch categories from the API
 */
const fetchCategories = async () => {
  try {
    const response = await axios.get(`${baseUrl}/categories`);
    categories.value = response.data;
    // Set default category_id if categories exist
    if (categories.value.length > 0) {
      form.value.category_id = categories.value[0].id;
    }
  } catch (err) {
    console.error("Error fetching categories:", err);
    // Don't set error state for category fetch failure, just log it
  }
};

/**
 * Handle form submission
 */
const handleSubmit = async () => {
  loading.value = true;
  error.value = null;

  try {
    await axios.post(`${baseUrl}/products`, form.value);
    router.push("/");
  } catch (err) {
    console.error("Error saving product:", err);
    error.value =
      err.response?.data?.message ||
      err.message ||
      "Failed to save product. Please try again.";
  } finally {
    loading.value = false;
  }
};

onMounted(() => {
  fetchCategories();
});
</script>
