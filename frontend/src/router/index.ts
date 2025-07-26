import { createRouter, createWebHistory } from "vue-router";
import HomeView from "../views/HomeView.vue";
import { useAuthStore } from "@/stores/auth";
import { getUserType } from "@/utils/auth";

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: "/",
      name: "home",
      component: HomeView,
      meta: {
        requiresGuest: true,
      },
    },
    {
      path: "/admins/login",
      name: "admin_login",
      props: { role: "Admin" },
      component: () => import("../views/LoginView.vue"),
      meta: {
        requiresGuest: true,
      },
    },
    {
      path: "/users/login",
      name: "user_login",
      props: { role: "User" },
      component: () => import("../views/LoginView.vue"),
      meta: {
        requiresGuest: true,
      },
    },
    {
      path: "/admins",
      name: "admin_dashboard",
      props: { role: "Admin" },
      component: () => import("../views/DashboardView.vue"),
      meta: {
        requiresAuth: true,
        role: "admin",
      },
    },
    {
      path: "/users",
      name: "user_dashboard",
      props: { role: "User" },
      component: () => import("../views/DashboardView.vue"),
      meta: {
        requiresAuth: true,
        role: "user",
      },
    },
    {
      path: "/:pathMatch(.*)*",
      name: "404",
      component: () => import("../views/404View.vue"),
    },
  ],
});

router.beforeEach(async (to) => {
  const authStore = useAuthStore();
  if (!authStore.isInitialized) {
    await authStore.init();
  }  
  if (to.meta.requiresAuth && !authStore.isLoggedIn) {
    return "/";
  }
  if (to.meta.requiresGuest && authStore.isLoggedIn) {
    const type = getUserType();
    return `/${type}s`;
  }
});

export default router;
