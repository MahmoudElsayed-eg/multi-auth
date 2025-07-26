<script setup lang="ts">
import type { Post, User } from "@/types";
import { ref, watch, defineProps, defineEmits, type Ref } from "vue";
import Spinner from "./Spinner.vue";
import type { ErrorObject } from "@/types";
import { useAuthStore } from "@/stores/auth";

const authStore = useAuthStore();
const props = defineProps<{
  mode: "add" | "edit";
  users?: User[];
  post?: Post;
  loading: boolean;
  errors: ErrorObject;
}>();

const emit = defineEmits<{
  (e: "submitted", post: Post): void;
  (e: "close"): void;
}>();

const title = ref("");
const content = ref("");
const user_id = ref(0);
const status = ref<"draft" | "published">("draft");
const pic = ref<File | null>(null);

watch(
  () => props.post,
  (newPost) => {
    if (props.mode === "edit" && newPost) {
      title.value = newPost.title;
      content.value = newPost.content;
      user_id.value = newPost.user_id;
      status.value = newPost.status;
    } else {
      title.value = "";
      content.value = "";
      user_id.value = 0;
      status.value = 'draft'
    }
    pic.value = null;
  },
  { immediate: true }
);

const handlePicChange = (e: Event) => {
  const file = (e.target as HTMLInputElement)?.files?.[0] || null;
  pic.value = file;
};

const handleSubmit = () => {
  const payload: Post = {
    id: props.post?.id || 0,
    title: title.value,
    content: content.value,
    user_id: props.users?.length ? user_id.value : authStore.user?.id,
    status: status.value,
    pic: pic.value,
  };

  emit("submitted", payload);
};
</script>

<template>
  <form @submit.prevent="handleSubmit" class="space-y-4">
    <h2 class="text-xl font-semibold text-white">
      {{ props.mode === "edit" ? "Edit Post" : "Add New Post" }}
    </h2>

    <div>
      <label class="block text-sm font-medium mb-1 text-white">Title</label>
      <input
        v-model="title"
        type="text"
        required
        class="w-full px-3 py-2 bg-[#2a2a2a] text-white rounded border border-gray-600 focus:outline-none focus:border-purple-500"
      />
      <span v-if="errors.title" class="text-red-400 text-sm mt-1">{{
        errors.title.message
      }}</span>
    </div>

    <div>
      <label class="block text-sm font-medium mb-1 text-white">Content</label>
      <textarea
        v-model="content"
        required
        class="w-full px-3 py-2 bg-[#2a2a2a] text-white rounded border border-gray-600 focus:outline-none focus:border-purple-500"
        rows="4"
      ></textarea>
      <span v-if="errors.content" class="text-red-400 text-sm mt-1">{{
        errors.content.message
      }}</span>
    </div>
    <div>
      <label class="block text-sm font-medium mb-1 text-white">Status</label>
      <select
        v-model="status"
        class="w-full px-3 py-2 bg-[#2a2a2a] text-white rounded border border-gray-600 focus:outline-none focus:border-purple-500"
      >
        <option value="draft">Draft</option>
        <option value="published">Published</option>
      </select>
    </div>
    <div v-if="props.users?.length">
      <label class="block text-sm font-medium mb-1 text-white">User</label>
      <select
        v-model="user_id"
        class="w-full px-3 py-2 bg-[#2a2a2a] text-white rounded border border-gray-600 focus:outline-none focus:border-purple-500"
      >
        <option value="" disabled>Select user</option>
        <option v-for="user in props.users" :key="user.id" :value="user.id">
          {{ user.name }}
        </option>
      </select>
      <span v-if="errors.user_id" class="text-red-400 text-sm mt-1">{{
        errors.user_id.message
      }}</span>
    </div>

    <div>
      <label class="block text-sm font-medium mb-1 text-white"
        >Image (optional)</label
      >
      <input
        type="file"
        accept="image/*"
        @change="handlePicChange"
        class="text-white bg-[#2a2a2a] rounded border border-gray-600 file:bg-purple-600 file:text-white file:border-none file:px-3 file:py-1 file:rounded hover:file:bg-purple-700 max-w-full"
      />
      <span v-if="errors.pic" class="text-red-400 text-sm mt-1">{{
        errors.pic.message
      }}</span>
    </div>

    <button
      :disabled="loading"
      type="submit"
      class="cursor-pointer w-full bg-purple-600 hover:bg-purple-700 text-white py-2 rounded"
    >
      <template v-if="loading">
        <Spinner />
      </template>
      <template v-else>
        {{ props.mode === "edit" ? "Update" : "Submit" }}
      </template>
    </button>
  </form>
</template>
