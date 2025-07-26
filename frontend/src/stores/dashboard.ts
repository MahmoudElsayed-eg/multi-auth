import type { Meta, Post, User } from "@/types";
import apiClient from "@/utils/api";
import {
  clearAuth,
  getAuthToken,
  getUserType,
  isValidUserType,
} from "@/utils/auth";
import { defineStore } from "pinia";
import { computed, ref } from "vue";

export const useDashboardStore = defineStore("dashboard", () => {
  const posts = ref<{data:Post[],meta:Meta} | null>(null);
  const users = ref<User[]>([]);
  async function getDashboardData(query = "") {
    const type = getUserType();
    if (!type || !isValidUserType(type)) {
      return;
    }
    const { data } = await apiClient.get(`/${type}s?` + query);
    users.value = data.users ?? [];
    posts.value = data.posts;
  }
  return { getDashboardData, posts, users };
});
