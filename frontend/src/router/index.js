import { createRouter, createWebHistory } from 'vue-router';
import Login from '../components/pages/Login/Login.vue';
import Home from '../components/pages/Home/Home.vue';
import SignUp from '../components/pages/SignUp/SignUp.vue';

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
  }
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
