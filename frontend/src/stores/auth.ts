import type { User } from "@/types";
import apiClient from "@/utils/api";
import {
  clearAuth,
  getAuthToken,
  getUserType,
  isValidUserType,
} from "@/utils/auth";
import { defineStore } from "pinia";
import { computed, ref } from "vue";

export const useAuthStore = defineStore("auth", () => {
  const user = ref<User | null>(null);
  const isLoggedIn = computed(() => !!user.value);
  const isInitialized = ref(false);
  async function userLogin(email: string, password: string) {
    const response = await apiClient.post("/users/login", { email, password });
    localStorage.setItem("auth_token", response.data.token);
    localStorage.setItem("type", "user");
    await getUser();
  }
  async function adminLogin(email: string, password: string) {
    const response = await apiClient.post("/admins/login", { email, password });
    localStorage.setItem("auth_token", response.data.token);
    localStorage.setItem("type", "admin");
    await getUser();
  }
  async function getUser() {
    const token = getAuthToken();
    const type = getUserType();

    if (!token || !isValidUserType(type)) {
      user.value = null;
      return;
    }

    const apiLink = `/${type}`;

    try {
      const { data } = await apiClient.get(apiLink);
      user.value = data;
    } catch (error) {
      console.error("Failed to fetch user:", error);
      user.value = null;
      clearAuth();
    }
  }

  async function logout() {
    const type = getUserType();
    try {
      await apiClient.delete(`/${type}s/logout`);
    } catch (error) {
      console.warn("Logout request failed, continuing cleanup.", error);
    }

    clearAuth();
    user.value = null;
  }
  async function init() {
    if (isInitialized.value) {
      return;
    }
    try {
      await getUser();
    } finally {
      isInitialized.value = true;
    }
  }
  return {
    user,
    isLoggedIn,
    isInitialized,
    getUser,
    userLogin,
    adminLogin,
    logout,
    init,
  };
});
