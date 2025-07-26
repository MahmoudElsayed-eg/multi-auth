<script setup lang="ts">
import type { User } from "@/types";
import { ref } from "vue";

const props = withDefaults(defineProps<{
  users?: User[];
}>(), {
  users: () => [],
});

const search = ref("");
const status = ref("");
const userId = ref("");
const handleSubmit = () => {
  const query = new URLSearchParams({
    search: search.value,
    status: status.value,
    user_id: userId.value,
  }).toString();
  emit('submitted',query);
};
const emit = defineEmits(['submitted']);
</script>

<template>
  <form @submit.prevent="handleSubmit" class="flex flex-wrap items-end gap-4">
    <div>
      <label for="search" class="block text-sm font-medium text-white"
        >Search</label
      >
      <input
        id="search"
        v-model="search"
        type="text"
        placeholder="Enter search..."
        class="px-3 py-2 rounded border bg-[#2a2a2a] text-white placeholder-gray-400 border-gray-600 focus:border-purple-500 focus:outline-none"
      />
    </div>

    <div>
      <label for="status" class="block text-sm font-medium text-white"
        >Status</label
      >
      <select
        id="status"
        v-model="status"
        class="cursor-pointer px-3 py-2 rounded border bg-[#2a2a2a] text-white border-gray-600 focus:border-purple-500 focus:outline-none"
      >
        <option value="">All</option>
        <option value="draft">Draft</option>
        <option value="published">Published</option>
      </select>
    </div>

    <div v-if="props.users.length > 0">
      <label for="user" class="block text-sm font-medium text-white"
        >User</label
      >
      <select
        id="user"
        v-model="userId"
        class="cursor-pointer px-3 py-2 rounded border bg-[#2a2a2a] text-white border-gray-600 focus:border-purple-500 focus:outline-none"
      >
        <option value="">All</option>
        <option v-for="user in props.users" :key="user.id" :value="user.id">
          {{ user.name }} ({{ user.email }})
        </option>
      </select>
    </div>

    <div>
      <button
        type="submit"
        class="bg-purple-500 text-white py-2 px-4 rounded hover:bg-purple-600 transition"
      >
        Search
      </button>
    </div>
  </form>
</template>
