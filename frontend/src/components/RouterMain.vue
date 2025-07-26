<script setup lang="ts">
defineProps<{
  name: string;
  to: string;
}>();
</script>

<template>
  <router-link
    :to
    class="block w-52 px-4 py-2 rounded-lg bg-purple-500/20 hover:bg-purple-500/30 text-center backdrop-blur-sm transition duration-200"
    >{{ name }}</router-link
  >
</template>
