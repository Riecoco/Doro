<template>
  <div
    class="font-dm-sans h-80 overflow-y-auto touch-pan-y flex flex-col w-full space-y-10 p-3"
  >
    <h2 class="text-2xl font-bold mb-5 text-white">Settings</h2>
    <div v-if="!user" class="flex-col space-y-1">
      <h4 class="text-lg font-medium">Account</h4>
      <RouterLink
        to="/login"
        class="rounded-md w-full h-fit flex flex-row justify-between p-3 bg-black/50 hover:bg-black/70"
      >
        <p>Log in</p>
        <ArrowToTopRight />
      </RouterLink>
      <RouterLink
        to="/signup"
        class="rounded-md w-full h-fit flex flex-row justify-between p-3 bg-black/50 hover:bg-black/70"
        ><p>Sign Up</p>
        <ArrowToTopRight
      /></RouterLink>
    </div>
    <div v-else class="flex-col space-y-1">
      <div @click="authStore.logout()"
        class="rounded-md w-full h-fit flex flex-row justify-between p-3 bg-black/30 hover:bg-white/30">
        <p>Log out</p>  
        <ArrowToTopRight />
      </div>
      <RouterLink to="/quotes" v-if="user?.role === 'admin'" class="rounded-md w-full h-fit flex flex-row justify-between p-3 bg-black/30 hover:bg-white/30"><p>Quotes</p>
        <ArrowToTopRight />
      </RouterLink>
    </div>
    <div class="flex flex-col space-y-1">
      <h4 class="text-lg font-medium">Timer Settings (in mins)</h4>
      <div class="flex flex-row space-x-6">
        <FormInput type="number" label="Pomodoro" placeholder="25" />
        <FormInput type="number" label="Short Break" placeholder="5" />
        <FormInput type="number" label="Long Break" placeholder="15" />
      </div>
    </div>
  </div>
</template>

<script setup>
import { RouterLink } from "vue-router";
import ArrowToTopRight from "../../atoms/Icons/ArrowToTopRight.vue";
import FormInput from "../../atoms/FormInput/FormInput.vue";
import { useAuthStore } from "../../../stores/auth";

const authStore = useAuthStore();

const props = defineProps({
  user: {
    type: Object,
    default: null,
  },
});



</script>
