import { createRouter, createWebHistory } from 'vue-router';
import LandingPage from '../pages/LandingPage.vue';
import LoginPage from '../pages/LoginPage.vue';
import HelloWorld from '../pages/HelloWorld.vue';

const routes = [
  {
    path: '/',
    name: 'HelloWorld',
    component: HelloWorld,
  },
  {
    path: '/login',
    name: 'Login',
    component: LoginPage,
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
