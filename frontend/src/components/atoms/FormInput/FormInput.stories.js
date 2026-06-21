/**
 * Storybook stories for FormInput component
 */
import FormInput from './FormInput.vue';

export default {
    title: 'Atoms/FormInput',
    component: FormInput,
    tags: ['autodocs'],
    argTypes: {
        type: {
            control: 'select',
            options: ['text', 'email', 'password', 'number'],
        },
        label: {
            control: 'text',
        },
        placeholder: {
            control: 'text',
        },
    },
};

const Template = (args) => ({
    components: { FormInput },
    setup() {
        return { args };
    },
    template: '<FormInput v-bind="args" />',
});

export const Default = Template.bind({});
Default.args = {
    label: 'Username',
    placeholder: 'Enter your username',
    type: 'text',
};

export const Email = Template.bind({});
Email.args = {
    label: 'Email Address',
    placeholder: 'your@email.com',
    type: 'email',
};

export const Password = Template.bind({});
Password.args = {
    label: 'Password',
    placeholder: 'Enter your password',
    type: 'password',
};

export const Number = Template.bind({});
Number.args = {
    label: 'Age',
    placeholder: 'Enter your age',
    type: 'number',
};
