/**
 * STORYBOOK STORIES FILE FOR ICONS
 *
 * This file creates stories for all icon components in the Icons folder.
 * When you open Storybook, you'll see these stories in the sidebar and can interact with them.
 *
 * How to use this file:
 * 1. Run your Storybook server (usually `npm run storybook`)
 * 2. Open the browser to see the Storybook interface
 * 3. Navigate to "Atoms/Icons" in the sidebar
 * 4. View all icons in the AllIcons story
 */

import ArrowToTopRight from "./ArrowToTopRight.vue";
import CycleIcon from "./CycleIcon.vue";
import EditIcon from "./EditIcon.vue";
import GearIcon from "./GearIcon.vue";
import MusicNoteIcon from "./MusicNoteIcon.vue";
import Pause from "./Pause.vue";
import Play from "./Play.vue";
import SixDots from "./SixDots.vue";

export default {
    title: "Atoms/Icons",
    tags: ["autodocs"],
};

export const AllIcons = {
    render: () => ({
        components: {
            ArrowToTopRight,
            CycleIcon,
            EditIcon,
            GearIcon,
            MusicNoteIcon,
            Pause,
            Play,
            SixDots,
        },
        template: `
      <div style="display: flex; flex-wrap: wrap; gap: 2rem; align-items: center;">
        <div style="display: flex; flex-direction: column; align-items: center;">
          <ArrowToTopRight style="width: 40px; height: 40px;" />
          <span>ArrowToTopRight</span>
        </div>
        <div style="display: flex; flex-direction: column; align-items: center;">
          <CycleIcon style="width: 40px; height: 40px;" />
          <span>CycleIcon</span>
        </div>
        <div style="display: flex; flex-direction: column; align-items: center;">
          <EditIcon style="width: 40px; height: 40px;" />
          <span>EditIcon</span>
        </div>
        <div style="display: flex; flex-direction: column; align-items: center;">
          <GearIcon style="width: 40px; height: 40px;" />
          <span>GearIcon</span>
        </div>
        <div style="display: flex; flex-direction: column; align-items: center;">
          <MusicNoteIcon style="width: 40px; height: 40px;" />
          <span>MusicNoteIcon</span>
        </div>
        <div style="display: flex; flex-direction: column; align-items: center;">
          <Pause style="width: 40px; height: 40px;" />
          <span>Pause</span>
        </div>
        <div style="display: flex; flex-direction: column; align-items: center;">
          <Play style="width: 40px; height: 40px;" />
          <span>Play</span>
        </div>
        <div style="display: flex; flex-direction: column; align-items: center;">
          <SixDots style="width: 40px; height: 40px;" />
          <span>SixDots</span>
        </div>
      </div>
    `,
    }),
};
