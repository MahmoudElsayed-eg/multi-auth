<script setup lang="ts">
import Spinner from './Spinner.vue';

const props = defineProps<{
  open: boolean;
  loading:boolean
}>();

const emit = defineEmits(["close", "delete"]);
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

     <!-- Content -->
      <h2 class="text-lg font-semibold mb-4">Delete Post</h2>
      <p class="mb-6">Are you sure you want to delete this post?</p>

      <!-- Action Buttons -->
      <div class="flex justify-end gap-3">
        <button
          @click="emit('close')"
          class="cursor-pointer px-4 py-2 bg-gray-600 hover:bg-gray-500 rounded text-sm"
        >
          Cancel
        </button>
        <button
        :disabled="loading"
          @click="emit('delete')"
          class="cursor-pointer px-4 py-2 bg-red-600 hover:bg-red-500 rounded text-sm"
        >
        <template v-if="loading">
            <Spinner />
        </template>
        <template v-else>
            Delete
        </template>
        </button>
      <button
        @click="emit('close')"
        class="cursor-pointer absolute top-3 right-3 w-9 h-9 rounded-full bg-gray-700 hover:bg-gray-600 flex items-center justify-center text-white text-xl"
      >
        &times;
      </button>
    </div>
  </div>
  </div>
</template>
