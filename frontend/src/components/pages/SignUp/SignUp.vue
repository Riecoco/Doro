<template>
  <div v-if="authStore.loading" class="min-h-screen flex items-center justify-center">
    <div class="text-center">
      <Loader />
      <p class="mt-4 text-gray-500">Loading...</p>
    </div>
  </div>
  <form
    v-else
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
    <Message
      v-if="authStore.error"
      :message="authStore.error"
      @close="authStore.error = ''"
    />
    <SignInButton @click="handleSignin()">Sign Up</SignInButton>
    <p class="text-center mt-4">
      Already have an account?
      <RouterLink to="/login" class="text-blue-500 underline"
        >Log In</RouterLink
      >
    </p>
  </form>
</template>

<script setup>
import FormInput from "../../atoms/FormInput/FormInput.vue";
import SignInButton from "../../atoms/Button/SignInButton.vue";
import { RouterLink } from "vue-router";
import { onMounted, ref } from "vue";
import router from "../../../router/index.js";
import { useAuthStore } from "../../../stores/auth.js";
import Loader from "../../atoms/Loader/Loader.vue";
import Message from "../../molecules/Message/Message.vue";

const username = ref("");
const email = ref("");
const password = ref("");
const confirmPasswordValue = ref("");

const authStore = useAuthStore();

onMounted(() => {
  if (authStore.user) {
    router.push("/");
  }
});

async function handleSignin() {
  if (password.value !== confirmPasswordValue.value) {
    authStore.error = "Passwords do not match.";
    return;
  }

  await authStore.register(username.value, email.value, password.value);
}
</script>
