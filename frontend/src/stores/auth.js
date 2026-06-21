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

    async function register(username, email, password) {
        loading.value = true;
        error.value = null;
        success.value = null;
        try {
            const response = await axios.post("/auth/register", { username, email, password });
            if (response.status === 201) {
            const loginResponse = await axios.post("/auth/login", {
                email,
                password,
            });
            setAuthToken(loginResponse.data.token);
            token.value = loginResponse.data.token;
            user.value = loginResponse.data.user;
            router.push("/");
            }
        } catch (err) {
            error.value =
                err.response?.data?.error || "An error occurred during signup.";
            router.push("/signup");
        } finally {
            loading.value = false;
        }
    }

    async function login(email, password) {
        loading.value = true;
        error.value = null;
        success.value = null;
        try {
            const response = await axios.post("/auth/login", { email, password });
            setAuthToken(response.data.token);
            token.value = response.data.token;
            user.value = response.data.user;
            user.value.role == 'admin' ? router.push("/admin") : router.push("/");
            } catch (err) {
                error.value =
                    err.response?.data?.error || "An error occurred during login.";
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
        await router.replace("/");
        success.value = "You've been logged out successfully.";
    }

    async function fetchUser() {
        if (!getAuthToken()) return;
        if (user.value) return;

        loading.value = true;

        try {
            const response = await axios.get("/auth/me");
            if (response.data) {
                user.value = response.data.user;
                success.value = response.data.message || "User data fetched successfully.";
            }
        } catch (err) {
            error.value = err.response?.data?.error || "Failed to fetch user data.";
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
    register,
    fetchUser,
    success
  };
})

export default useAuthStore
