<script setup>
import TaskPanel from "../../molecules/TaskPanel/TaskPanel.vue";
import MenuButton from "../../atoms/Button/MenuButton.vue";
import EditIcon from "../../atoms/Icons/EditIcon.vue";
import { RouterLink } from "vue-router";
import { useAuthStore } from "../../../stores/auth.js";

const authStore = useAuthStore();

const props = defineProps({
  activeMenuIndex: {
    type: Number,
    required: true,
  },
});

const emit = defineEmits(["toggleMenu"]);

</script>

<template>
    <div class="btm-panel">
            <Transition name="menu">
              <section
                v-if="activeMenuIndex === 0"
                class="w-64 sm:w-80 md:w-100 lg:w-150 p-1 mb-7 bg-black/10 backdrop-blur-md text-white border border-white/20 rounded-lg menu"
              >
                <TaskPanel v-if="authStore.user" />
                <div v-else class="flex h-60 flex-col items-center justify-center gap-3 p-4 text-center">
                  <p class="text-sm text-white/70">Log in to view and manage your tasks.</p>
                  <RouterLink
                    to="/login"
                    class="rounded-md bg-black/40 px-4 py-2 text-sm hover:bg-black/60"
                  >
                    Log in
                  </RouterLink>
                </div>
              </section>
            </Transition>
            <MenuButton
              :index="0"
              :activeMenuIndex="activeMenuIndex"
              @toggle="emit('toggleMenu', 0)"
            >
              <EditIcon />
            </MenuButton>
          </div>
</template>
