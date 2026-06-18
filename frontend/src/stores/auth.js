import { defineStore } from 'pinia'
import { ref } from 'vue'
import axios from '../utils/axios.js'
import { setAuthToken, getAuthToken } from '../utils/axios.js'
import router from '../router'

export const useAuthStore = defineStore("auth", () => {
  const user = ref(null);
  const token = ref(getAuthToken());
  const error = ref(null);

    async function login(email, password) {
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
            }
    
    }

    async function logout() {
        error.value = null;
        try {
            await axios.post("/auth/logout");
            setAuthToken(null);
            token.value = null;
            user.value = null;
            router.push("/login");
        }
        catch (err) {
            error.value = err.response?.data?.message || 'Logout failed';
        }
    }

    async function fetchUser() {
        if (!getAuthToken()) return;

        try {
            const response = await axios.get("/auth/me");
            if (response.data) {
            user.value = response.data;
            }
        } catch (err) {
            if (err.response && err.response.status === 401) {
            return;
            }
            console.error("Error fetching user data:", err);
        }
    }

  return {
    user,
    token,
    error,
    login,
    logout,
    fetchUser,
  };
})

export default useAuthStore
