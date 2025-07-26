<script setup lang="ts">
import { ref, watch } from "vue";
import type { Meta, Post, User } from "@/types";

const backendLink = import.meta.env.VITE_API_BASE_URL || "http://localhost:8000/storage/";
const props = defineProps<{
  role: string;
  users: User[];
  posts: { data: Post[]; meta: Meta };
}>();

const emit = defineEmits<{
  (e: "edit", post: Post): void;
  (e: "delete", post: Post): void;
  (e: "page", page: number): void;
}>();

const currentPage = ref(props.posts.meta.current_page);

watch(
  () => props.posts.meta.current_page,
  (newPage) => {
    currentPage.value = newPage;
  }
);

const getUserName = (userId: number) => {
  return props.users.find((u) => u.id === userId)?.name || "Unknown";
};
</script>

<template>
  <div class="p-3 w-full text-white overflow-x-auto">
    <table class="w-full text-left border-separate border-spacing-y-2">
      <thead>
        <tr class="text-purple-500">
          <th>ID</th>
          <th>Title</th>
          <th>Status</th>
          <th>Content</th>
          <th>Image</th>
          <th v-if="role == 'Admin'">User</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr
          v-for="post in posts.data"
          :key="post.id"
          class="bg-[#2a2a2a] hover:bg-[#333] transition"
        >
          <td class="p-2">{{ post.id }}</td>
          <td class="p-2">{{ post.title }}</td>
          <td class="p-2">{{ post.status }}</td>
          <td class="p-2">{{ post.content }}</td>
          <td class="p-2">
            <img
              v-if="post.pic"
              :src="backendLink + post.pic"
              class="w-16 h-16 object-cover rounded"
              alt="Post Image"
            />
            <span v-else class="text-gray-400">No image</span>
          </td>
          <td v-if="role == 'Admin'" class="p-2">
            {{ getUserName(post.user_id) }}
          </td>
          <td class="p-2">
            <div class="flex gap-2">
              <button
                @click="emit('edit', post)"
                class="cursor-pointer bg-purple-500 hover:bg-purple-600 text-white px-3 py-1 rounded"
              >
                Edit
              </button>
              <button
                @click="emit('delete', post)"
                class="cursor-pointer bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded"
              >
                Delete
              </button>
            </div>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
  <!-- Pagination -->
  <div class="flex justify-center my-4 gap-2">
    <button
      class="px-3 py-1 bg-gray-700 rounded text-white hover:bg-gray-600"
      :disabled="currentPage <= 1"
      @click="emit('page', currentPage - 1)"
    >
      Prev
    </button>

    <button
      class="px-3 py-1 bg-gray-700 rounded text-white hover:bg-gray-600"
      v-for="page in posts.meta.last_page"
      :key="page"
      :class="{ 'bg-purple-500': page === currentPage }"
      :disabled="page === currentPage"
      @click="emit('page', page)"
    >
      {{ page }}
    </button>

    <button
      class="px-3 py-1 bg-gray-700 rounded text-white hover:bg-gray-600"
      :disabled="currentPage >= posts.meta.last_page"
      @click="emit('page', currentPage + 1)"
    >
      Next
    </button>
  </div>
</template>
