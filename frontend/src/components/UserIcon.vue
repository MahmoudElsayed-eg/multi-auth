<script setup lang="ts">
import { ref } from "vue";
import { useAuthStore } from "@/stores/auth";
import { useRouter } from "vue-router";

const showMenu = ref(false);
const auth = useAuthStore();
const router = useRouter();

const toggleMenu = () => {
  showMenu.value = !showMenu.value;
};

const closeMenu = () => {
  showMenu.value = false;
};

const logout = async () => {
  await auth.logout();
  router.replace("/");
  closeMenu();
};
</script>

<template>
  <div class="relative">
    <button
      @click="toggleMenu"
      class="cursor-pointer w-10 h-10 rounded-full bg-purple-500 hover:bg-purple-600 flex items-center justify-center"
    >
      <svg
        class="w-6 h-6 text-white"
        fill="none"
        stroke="currentColor"
        stroke-width="2"
        viewBox="0 0 24 24"
        xmlns="http://www.w3.org/2000/svg"
      >
        <path
          stroke-linecap="round"
          stroke-linejoin="round"
          d="M5.121 17.804A9 9 0 0112 15a9 9 0 016.879 2.804M15 11a3 3 0 11-6 0 3 3 0 016 0z"
        />
      </svg>
    </button>

    <div
      v-if="showMenu"
      class="absolute right-0 mt-2 w-60 bg-modern-dark text-white shadow-lg rounded-xl p-4 border border-gray-700 z-50"
    >
      <p class="font-semibold text-lg">{{ auth.user?.name }}</p>
      <p class="text-sm text-gray-400">{{ auth.user?.email }}</p>
      <button
        @click="logout"
        class="cursor-pointer mt-4 w-full bg-purple-500 hover:bg-purple-600 text-white py-2 px-4 rounded-lg transition"
      >
        Logout
      </button>
    </div>
  </div>
</template>
