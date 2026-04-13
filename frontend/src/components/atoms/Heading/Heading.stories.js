/**
 * Storybook stories for DM Sans heading components
 */
import HeadingH1 from './HeadingH1.vue';
import HeadingH2 from './HeadingH2.vue';
import HeadingH3 from './HeadingH3.vue';

export default {
    title: 'Atoms/Heading',
    tags: ['autodocs'],
};

export const H1 = {
    render: () => ({
        components: { HeadingH1 },
        template: '<HeadingH1>This is H1 heading (32px, weight 700)</HeadingH1>',
    }),
};

export const H2 = {
    render: () => ({
        components: { HeadingH2 },
        template: '<HeadingH2>This is H2 heading (24px, weight 600)</HeadingH2>',
    }),
};

export const H3 = {
    render: () => ({
        components: { HeadingH3 },
        template: '<HeadingH3>This is H3 heading (20px, weight 600)</HeadingH3>',
    }),
};
