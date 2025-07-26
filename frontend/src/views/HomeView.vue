<script setup lang="ts">
import RouterMain from '@/components/RouterMain.vue'
</script>

<template>
  <main class="flex flex-col h-screen justify-center items-center">
    <h1 class="text-6xl text-purple-500 font-bold mb-8">Multi Auth</h1>
    <RouterMain class="mb-4" to="/admins/login" name="Admin Login" />
    <RouterMain to="/users/login" name="User Login" />
  </main>
</template>
