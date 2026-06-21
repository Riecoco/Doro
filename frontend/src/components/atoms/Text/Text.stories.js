/**
 * Storybook stories for DM Sans body text components
 */
import TextSm from './TextSm.vue';
import TextMd from './TextMd.vue';
import TextLg from './TextLg.vue';

export default {
    title: 'Atoms/Text',
    tags: ['autodocs'],
};

export const Small = {
    render: () => ({
        components: { TextSm },
        template: '<TextSm>This is small body text (text-sm)goodgrief</TextSm>',
    }),
};

export const Medium = {
    render: () => ({
        components: { TextMd },
        template: '<TextMd>This is medium body text (text-base)</TextMd>',
    }),
};

export const Large = {
    render: () => ({
        components: { TextLg },
        template: '<TextLg>This is large body text (text-lg)</TextLg>',
    }),
};
