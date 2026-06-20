<script setup>
import TaskPanel from "../../molecules/TaskPanel/TaskPanel.vue";
import MenuButton from "../../atoms/Button/MenuButton.vue";
import EditIcon from "../../atoms/Icons/EditIcon.vue";

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
                <TaskPanel />
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