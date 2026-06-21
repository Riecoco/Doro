<template>
  <div v-if="authStore.loading" class="min-h-screen flex items-center justify-center">
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
    <Message
      v-if="authStore.error"
      :message="authStore.error"
      @close="authStore.error = ''"
    />
    <SignInButton @click="handleLogin">Log in</SignInButton>
    <p class="mt-4">
      Create an account?
      <RouterLink to="/signup" class="text-indigo-500">Click here</RouterLink>
    </p>
  </form>
</template>

<script setup>
import FormInput from "../../atoms/FormInput/FormInput.vue";
import SignInButton from "../../atoms/Button/SignInButton.vue";
import { ref, onMounted } from "vue";
import axios from "../../../utils/axios.js";
import useAuthStore from "../../../stores/auth.js";
import router from "../../../router/index.js";
import Loader from "../../atoms/Loader/Loader.vue";
import Message from "../../molecules/Message/Message.vue";

const authStore = useAuthStore();
const user = ref(null);
const email = ref("");
const password = ref("");

onMounted(async () => {
    await authStore.fetchUser();
});

const handleLogin = async () => {
    await authStore.login(email.value, password.value);
};
</script>
