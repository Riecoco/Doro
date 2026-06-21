<script setup>
import { ref } from "vue";
import TaskMenu from "../TaskMenu/TaskMenu.vue";
import MusicMenu from "../MusicMenu/MusicMenu.vue";
import SettingsMenu from "../SettingsMenu/SettingsMenu.vue";

const activeMenuIndex = ref(-1);
function toggleMenu(index) {
  activeMenuIndex.value = activeMenuIndex.value === index ? -1 : index;
}

</script>

<template>
    <section class="flex justify-between p-3 place-self-start w-full fixed bottom-0">
        <div class="grid grid-cols-2 gap-x-5">
            <TaskMenu :activeMenuIndex="activeMenuIndex" @toggleMenu="toggleMenu" />
            <MusicMenu :activeMenuIndex="activeMenuIndex" @toggleMenu="toggleMenu" />
        </div>
          <SettingsMenu :activeMenuIndex="activeMenuIndex" @toggleMenu="toggleMenu" />
    </section>
</template>

<style>
.btm-panel {
  position: relative;
}

.menu {
  position: absolute;
  bottom: 100%;
}

.menu.right {
  right: 0;
}

.menu-enter-active,
.menu-leave-active {
  transition: all 0.25s cubic-bezier(0, 0.55, 0.45, 1);
}

.menu-enter-from,
.menu-leave-to {
  opacity: 0;
  visibility: hidden;
  transform: translateY(10px);
}
</style>
