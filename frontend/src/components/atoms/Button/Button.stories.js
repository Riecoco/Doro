/**
 * Storybook stories for Button components
 */
import MenuButton from './MenuButton.vue';
import SelectTimerButton from './SelectTimerButton.vue';

// MenuButton Stories
export default {
    title: 'Atoms/Button/MenuButton',
    component: MenuButton,
    tags: ['autodocs'],
    argTypes: {
        activeMenuIndex: {
            control: 'number',
        },
        index: {
            control: 'number',
        },
    },
};

const MenuButtonTemplate = (args) => ({
    components: { MenuButton },
    setup() {
        return { args };
    },
    template: '<MenuButton v-bind="args"><span>Menu Item</span></MenuButton>',
});

export const MenuButtonClosed = MenuButtonTemplate.bind({});
MenuButtonClosed.args = {
    activeMenuIndex: -1,
    index: 0,
};

export const MenuButtonOpen = MenuButtonTemplate.bind({});
MenuButtonOpen.args = {
    activeMenuIndex: 0,
    index: 0,
};

// SelectTimerButton Stories
export const SelectTimerButtonStory = {
    title: 'Atoms/Button/SelectTimerButton',
    component: SelectTimerButton,
    tags: ['autodocs'],
    argTypes: {
        minute: {
            control: 'number',
        },
        selectedTimerMode: {
            control: 'text',
        },
        mode: {
            control: 'text',
        },
    },
};

const SelectTimerButtonTemplate = (args) => ({
    components: { SelectTimerButton },
    setup() {
        return { args };
    },
    template: '<SelectTimerButton v-bind="args" />',
});

export const SelectTimerButtonInactive = SelectTimerButtonTemplate.bind({});
SelectTimerButtonInactive.args = {
    minute: 5,
    selectedTimerMode: 'work',
    mode: 'break',
};

export const SelectTimerButtonActive = SelectTimerButtonTemplate.bind({});
SelectTimerButtonActive.args = {
    minute: 5,
    selectedTimerMode: 'work',
    mode: 'work',
};
