<script setup lang="ts">
import { ref } from 'vue'

const menuItems = ref([
  { name: 'My dashboard', icon: 'home', path: '/dashboard' },
  { name: 'Two factor authentication', icon: 'users', path: '/accounts' },
])

const icons: Record<string, string> = {
  home: `<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>`,
  users: `<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M15 21a6 6 0 00-9-5.197m0 0A5.995 5.995 0 003 16v-1a6 6 0 016-6v-1a4 4 0 014-4h2a4 4 0 014 4v1a6 6 0 01-6 6v1a6 6 0 01-9-5.197z"></path></svg>`,
  
};
</script>

<template>
  <aside class="w-64 flex-shrink-0 bg-white shadow-md flex flex-col h-full">
    <nav class="flex-1 px-4 py-6 flex flex-col space-y-2">
      <Link 
        v-for="item in menuItems" 
        :key="item.name"
        :href="item.path" 
        class="flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-gray-100 transition-colors"
        :class="{ 'text-white bg-gradient-to-r from-orange-400 to-pink-500 shadow-lg': $page.url === item.path }"
      >
        <div v-html="icons[item.icon]" class="w-6 h-6 mr-3"></div>
        <span class="font-medium">{{ item.name }}</span>
      </Link>
    </nav>
  </aside>
</template> 