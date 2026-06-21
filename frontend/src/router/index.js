import { createRouter, createWebHistory } from 'vue-router';
import Login from '../components/pages/Login/Login.vue';
import Home from '../components/pages/Home/Home.vue';
import SignUp from '../components/pages/SignUp/SignUp.vue';
import QuotesDashboard from '../components/pages/Quotes/QuotesDashboard.vue';

const routes = [
  {
    path: '/',
    name: 'Home',
    component: Home,
  },
  {
    path: '/login',
    name: 'Login',
    component: Login,
  },
  {
    path: '/signup',
    name: 'Signup',
    component: SignUp,
  },
  {
    path: '/quotes',
    name: 'QuotesDashboard',
    component: QuotesDashboard,
  },
    {
    path: '/test',
    name: 'Test',
    component: () => import('../components/TestComponent.vue'),
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
