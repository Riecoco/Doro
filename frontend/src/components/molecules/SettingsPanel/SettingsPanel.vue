<template>
  <div
    class="scroll font-dm-sans h-60 overflow-y-auto touch-pan-y flex flex-col w-full space-y-10 p-1 pr-3"
  >
    <h2 class="text-base sm:text-lg md:text-xl font-bold mb-5 text-white">Settings</h2>
    <section v-if="!authStore.user" class="flex-col space-y-1 text-sm md:text-base">
      <h4 class="text-base md:text-lg">Account</h4>
      <RouterLink
        to="/login"
        class="lg:text-md rounded-md w-full h-fit flex flex-row justify-between p-3 bg-black/50 hover:bg-black/70"
      >
        <p>Log in</p>
        <ArrowToTopRight />
      </RouterLink>
      <RouterLink
        to="/signup"
        class="lg:text-md rounded-md w-full h-fit flex flex-row justify-between p-3 bg-black/50 hover:bg-black/70"
        ><p>Sign Up</p>
        <ArrowToTopRight
      /></RouterLink>
    </section>
    <section v-else class="flex-col space-y-1 text-sm md:text-base">
      <div @click="authStore.logout()"
        class="rounded-md w-full h-fit flex flex-row justify-between p-3 bg-black/30 hover:bg-white/30">
        <p>Log out</p>  
        <ArrowToTopRight />
      </div>
      <RouterLink to="/quotes" v-if="authStore.user?.role === 'admin'" class="rounded-md w-full h-fit flex flex-row justify-between p-3 bg-black/30 hover:bg-white/30"><p>Quotes</p>
        <ArrowToTopRight />
      </RouterLink>
    </section>

    <section class="flex flex-col space-y-1">
      <h4 class="text-base md:text-lg">General</h4>
      <div class="flex items-center justify-between gap-3 text-sm md:text-base">
        <span class="min-w-0 text-gray-300">Show motivational quotes (they won't show up unless you're logged in).</span>
        <Toggle
          :checked="quotesStore.showQuotes"
          @update:checked="quotesStore.setShowQuotes"
        />
      </div>
    </section>

    <section class="flex flex-col space-y-1">
      <h4 class="text-base md:text-lg">Timer Settings (in mins)</h4>
      <div class="flex lg:flex-row flex-col lg:space-x-6 space-y-4 text-sm md:text-base">
        <FormInput type="number" label="Pomodoro" placeholder="25" />
        <FormInput type="number" label="Short Break" placeholder="5" />
        <FormInput type="number" label="Long Break" placeholder="15" />
      </div>
    </section>
  </div>
</template>

<script setup>
import { RouterLink } from "vue-router";
import ArrowToTopRight from "../../atoms/Icons/ArrowToTopRight.vue";
import FormInput from "../../atoms/FormInput/FormInput.vue";
import Toggle from "../../atoms/Toggle/Toggle.vue";
import { useAuthStore } from "../../../stores/auth";
import { useQuotesStore } from "../../../stores/quotes";
const authStore = useAuthStore();
const quotesStore = useQuotesStore();

</script>
