<script setup lang="ts">
import type { Post } from "@/types";
import PostForm from "./PostForm.vue";
import type { ErrorObject } from "@/types";
import type { User } from "@/types";

const props = defineProps<{
  open: boolean;
  mode: "add" | "edit";
  post?: Post;
  loading: boolean;
  errors: ErrorObject;
  users?: User[];
}>();

const emit = defineEmits(["close", "submitted"]);
</script>

<template>
  <div
    v-if="open"
    class="fixed inset-0 bg-black/50 flex items-center justify-center z-50"
    @click.self="emit('close')"
  >
    <div
      class="bg-modern-dark text-white rounded-xl p-6 w-full max-w-md shadow-xl relative"
    >
      <PostForm
        :mode="mode"
        :post="post"
        @close="emit('close')"
        @submitted="emit('submitted', $event)"
        :loading
        :errors
        :users
      />

      <button
        @click="emit('close')"
        class="cursor-pointer absolute top-3 right-3 w-9 h-9 rounded-full bg-gray-700 hover:bg-gray-600 flex items-center justify-center text-white text-xl"
      >
        &times;
      </button>
    </div>
  </div>
</template>
