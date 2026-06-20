<script setup>
import Settings from "../../molecules/SettingsPanel/SettingsPanel.vue";
import MenuButton from "../../atoms/Button/MenuButton.vue";
import GearIcon from "../../atoms/Icons/GearIcon.vue";

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
                v-if="activeMenuIndex === 2"
                class="w-64 sm:w-80 md:w-100 lg:w-150 p-3 mb-7 bg-black/10 backdrop-blur-md text-white border border-white/20 rounded-lg menu right"
              >
                <Settings />
              </section>
            </Transition>
            <MenuButton
              :index="2"
              :activeMenuIndex="activeMenuIndex"
              @toggle="emit('toggleMenu', 2)"
            >
              <GearIcon />
            </MenuButton>
          </div>
</template>