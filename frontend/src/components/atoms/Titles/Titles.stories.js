/**
 * Storybook stories for Noto Serif Display title components
 */
import TitleTimer from './TitleTimer.vue';
import TitleLogo from './TitleLogo.vue';

export default {
    title: 'Atoms/Titles',
    tags: ['autodocs'],
};

export const Timer = {
    render: () => ({
        components: { TitleTimer },
        template: '<TitleTimer>Timer Title (96px)</TitleTimer>',
    }),
};

export const Logo = {
    render: () => ({
        components: { TitleLogo },
        template: '<TitleLogo>Logo Title (36px)</TitleLogo>',
    }),
};
