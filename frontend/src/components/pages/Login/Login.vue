<template>
  <div v-if="loading" class="min-h-screen flex items-center justify-center">
    <div class="text-center">
      <Loader />
      <p class="mt-4 text-gray-500">Loading...</p>
    </div>
  </div>
  <form
    v-else
    @submit.prevent="handleLogin"
    class="bg-white rounded-lg shadow-xl text-sm text-gray-500 border border-gray-200 p-8 py-12 w-80 sm:w-352px m-auto mt-24 flex flex-col space-y-3"
  >
    <p class="text-2xl font-medium text-center">
      <span class="text-indigo-500">Login</span>
    </p>

    <FormInput
      v-model="email"
      type="email"
      label="Email"
      placeholder="johndoe@gmail.com"
    />
    <FormInput
      v-model="password"
      type="password"
      label="Password"
      placeholder="••••••••"
    />

    <p class="mt-4">
      Create an account?
      <RouterLink to="/signup" class="text-indigo-500">Click here</RouterLink>
    </p>

    <ErrorMessage v-if="error" :message="error" @close="error = ''" />

    <SignInButton>Log in</SignInButton>
  </form>
</template>

<script setup>
import FormInput from "../components/atoms/FormInput/FormInput.vue";
import SignInButton from "../components/atoms/Button/SignInButton.vue";
import { ref, onMounted } from "vue";
import axios from "../../../utils/axios.js";
import { setAuthToken, getAuthToken } from "../../../utils/axios.js";
import router from "../../../router/index.js";
import Loader from "@/components/atoms/Loader/Loader.vue";
import ErrorMessage from "@/components/molecules/Message/ErrorMessage.vue";

const loading = ref(true);
const user = ref(null);
const error = ref("");
const email = ref("");
const password = ref("");

onMounted(async () => {
  try {
    loading.value = true;
    if (!getAuthToken()) {
      return; // No token, user can login through form
    }
    const response = await axios.get("/auth/me");
    user.value = response.data;
    setTimeout(() => {}, 1000); // Simulate a short delay for better UX
    router.push("/");
  } catch (err) {
    user.value = null;
    error.value =
      err.response?.data?.error ||
      "An error occurred while fetching user data.";
  } finally {
    loading.value = false;
  }
});

const handleLogin = async () => {
  try {
    loading.value = true;
    const response = await axios.post("/auth/login", {
      email: email.value,
      password: password.value,
    });
    setAuthToken(response.data.token);
    user.value = response.data.user;
    setTimeout(() => {}, 1000);
    router.push("/");
  } catch (err) {
    if (err.response?.status === 401) {
      error.value = "Invalid email or password. Please try again.";
    } else {
      error.value =
        err.response?.data?.error || "An error occurred during login.";
    }
    router.push("/login");
  } finally {
    loading.value = false;
  }
};
</script>
