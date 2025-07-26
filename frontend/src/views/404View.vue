<script setup lang="ts">
import RouterMain from '@/components/RouterMain.vue';


</script>

<template>
   <main class="flex flex-col h-screen justify-center items-center">
    <h1 class="text-6xl text-purple-500 font-bold mb-4">404</h1>
    <p class="text-purple-500 mb-4">Page Not Found</p>
    <RouterMain to="/" name="BackToHome" />
  </main>
</template>