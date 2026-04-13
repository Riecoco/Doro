<template>
  <form
    @submit.prevent="handleSignin"
    class="flex flex-col space-y-4 bg-white text-gray-500 max-w-85 m-auto mt-12 w-full md:p-6 p-4 py-8 text-left text-sm rounded-lg shadow-[0px_0px_10px_0px] shadow-black/10"
  >
    <h2 class="text-2xl font-bold mb-9 text-center text-gray-800">Sign Up</h2>

    <div class="flex flex-col space-y-3">
      <FormInput
        v-model="username"
        type="text"
        label="Username"
        placeholder="Username"
      />
      <FormInput
        v-model="email"
        type="email"
        label="Email"
        placeholder="Email"
      />
      <FormInput
        v-model="password"
        type="password"
        label="Password"
        placeholder="••••••••"
      />
      <FormInput
        v-model="confirmPasswordValue"
        type="password"
        label="Confirm Password"
        placeholder="••••••••"
      />
    </div>
    <ErrorMessage v-if="error" :message="error" @close="error = ''" />

    <SignInButton>Sign Up</SignInButton>
    <p class="text-center mt-4">
      Already have an account?
      <RouterLink to="/login" class="text-blue-500 underline"
        >Log In</RouterLink
      >
    </p>
  </form>
</template>

<script setup>
import ErrorMessage from "@/components/molecules/Message/ErrorMessage.vue";
import FormInput from "@/components/atoms/FormInput/FormInput.vue";
import SignInButton from "@/components/atoms/Button/SignInButton.vue";
import axios, { getAuthToken, setAuthToken } from "@/utils/axios.js";
import { RouterLink } from "vue-router";
import { onMounted, ref } from "vue";
import router from "@/router";

const loading = ref(false);
const error = ref("");
const username = ref("");
const email = ref("");
const password = ref("");
const confirmPasswordValue = ref("");

onMounted(() => {
  if (getAuthToken()) {
    router.push("/"); // if already logged in, redirect to home page
  }
});

async function handleSignin() {
  error.value = ""; // Clear any previous errors
  loading.value = true;

  if (password.value !== confirmPasswordValue.value) {
    error.value = "Passwords do not match.";
    loading.value = false;
    return;
  }

  try {
    const response = await axios.post("/auth/register", {
      username: username.value,
      email: email.value,
      password: password.value,
    });
    if (response.status === 201) {
      //automatic login after successful registration
      const loginResponse = await axios.post("/auth/login", {
        email: email.value,
        password: password.value,
      });
      setAuthToken(loginResponse.data.token);
      setTimeout(() => {}, 1000);
      router.push("/");
    }
  } catch (err) {
    console.log(err.response?.data);
    error.value =
      err.response?.data.error ||
      "An error occurred during sign up. Please try again.";
  } finally {
    loading.value = false;
  }
}
</script>
