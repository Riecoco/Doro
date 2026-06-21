<script setup>
import MenuButton from "../../atoms/Button/MenuButton.vue";
import MusicNoteIcon from "../../atoms/Icons/MusicNoteIcon.vue";

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
                v-if="activeMenuIndex === 1"
                class="w-64 sm:w-80 md:w-100 lg:w-150 p-3 mb-7 bg-black/10 backdrop-blur-md text-white border border-white/20 rounded-lg menu"
              >
                <p class="text-center text-white/60">Coming soon 🚀</p>
              </section>
            </Transition>
            <MenuButton
              :index="1"
              :activeMenuIndex="activeMenuIndex"
              @toggle="emit('toggleMenu', 1)"
            >
              <MusicNoteIcon />
            </MenuButton>
          </div>
</template>