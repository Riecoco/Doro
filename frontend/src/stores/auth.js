import { defineStore } from 'pinia'
import { ref } from 'vue'
import axios from '../utils/axios.js'
import { setAuthToken, getAuthToken } from '../utils/axios.js'
import router from '../router'

export const useAuthStore = defineStore("auth", () => {
  const loading = ref(false);
  const user = ref(null);
  const token = ref(getAuthToken());
  const error = ref(null);
  const success = ref(null);

    async function login(email, password) {
        loading.value = true;
        error.value = null;
        try {
            const response = await axios.post("/auth/login", { email, password });
            setAuthToken(response.data.token);
            token.value = response.data.token;
            user.value = response.data.user;
            if (user.value?.role === "admin") {
                router.push("/quotes");
                } else {
                router.push("/");
                }
            } catch (err) {
                if (err.response?.status === 401) {
                error.value = "Invalid email or password. Please try again.";
                } else {
                error.value =
                    err.response?.data?.error || "An error occurred during login.";
                }
                router.push("/login");
            } finally {
                loading.value = false;
        }
    
    }

    async function logout() {
        error.value = null;
        setAuthToken(null);
        token.value = null;
        user.value = null;
        success.value = "You've been logged out successfully.";
        await router.replace("/");
    }

    async function fetchUser() {
        if (!getAuthToken()) return;
        if (user.value) return;

        loading.value = true;

        try {
            const response = await axios.get("/auth/me");
            if (response.data) {
            user.value = response.data;
            }
            if (user.value?.role === "admin") {
                router.push("/quotes");
            } else {
                router.push("/");
            }
        } catch (err) {
            console.error("Error fetching user data:", err);
        } finally {
            loading.value = false;
        }
    }

  return {
    user,
    token,
    loading,
    error,
    login,
    logout,
    fetchUser,
  };
})

export default useAuthStore
