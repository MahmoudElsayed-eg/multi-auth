<script setup lang="ts">
import { ref } from "vue";
import Spinner from "@/components/Spinner.vue";
import type { ErrorObject } from "@/types";
import handleValidationErrors from "@/utils/errors";
import { useAuthStore } from "@/stores/auth";
import { useRouter } from "vue-router";

const props = defineProps<{
  role: string;
}>();
const loading = ref(false);
const errors = ref<ErrorObject>({});
const authStore = useAuthStore();
const formData = ref({
  email: "",
  password: "",
});
const router = useRouter();
const login = async () => {
  try {
    loading.value = true;
    errors.value = {};
    switch (props.role) {
      case "Admin":
        await authStore.adminLogin(
          formData.value.email,
          formData.value.password
        );
        router.push("/admins");
        break;
      case "User":
        await authStore.userLogin(
          formData.value.email,
          formData.value.password
        );
        router.push("/users");
        break;
      default:
        return;
    }
  } catch (error: any) {
    handleValidationErrors(error, errors);
  } finally {
    loading.value = false;
  }
};
</script>
<template>
  <main class="flex flex-col h-screen items-center justify-center">
    <h1 class="text-3xl font-bold text-purple-500 mb-6">{{ role }} Login</h1>

    <form
      @submit.prevent="login"
      action=""
      class="w-full max-w-sm bg-white/5 p-6 rounded-lg shadow-lg backdrop-blur-sm space-y-4"
    >
      <div class="flex flex-col">
        <label for="email" class="mb-1 text-sm font-medium">Email</label>
        <input
          type="email"
          id="email"
          class="bg-white/10 border border-white/20 text-white px-4 py-2 rounded focus:outline-none focus:ring-2 focus:ring-purple-500 placeholder-gray-400"
          placeholder="you@example.com"
          v-model="formData.email"
        />
        <span v-if="errors.email" class="text-red-400 text-sm mt-1">{{
          errors.email.message
        }}</span>
        <span v-if="errors.general" class="text-red-400 text-sm mt-1">{{
          errors.general.message
        }}</span>
      </div>

      <div class="flex flex-col">
        <label for="password" class="mb-1 text-sm font-medium">Password</label>
        <input
          type="password"
          id="password"
          class="bg-white/10 border border-white/20 text-white px-4 py-2 rounded focus:outline-none focus:ring-2 focus:ring-purple-500 placeholder-gray-400"
          placeholder="••••••••"
          v-model="formData.password"
        />
        <span v-if="errors.password" class="text-red-400 text-sm mt-1">{{
          errors.password.message
        }}</span>
      </div>

      <button
        type="submit"
        class="w-full bg-purple-600 hover:bg-purple-700 text-white font-semibold py-2 px-4 rounded transition"
        :disabled="loading"
      >
        <template v-if="loading">
          <Spinner />
        </template>
        <template v-else> Login </template>
      </button>
      <router-link
        to="/"
        class="block text-center text-sm text-gray-300 hover:text-white transition mt-2"
      >
        ← Back to Home
      </router-link>
    </form>
  </main>
</template>
