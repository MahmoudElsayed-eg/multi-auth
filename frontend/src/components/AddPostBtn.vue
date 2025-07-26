<script setup lang="ts">
const emit = defineEmits(['open']);
</script>

<template>
  <button
    @click="$emit('open')"
    class="cursor-pointer bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded transition"
  >
    + Add Post
  </button>
</template>