<script setup>
import SideMenu from "./Components/SideMenu.vue";
</script>
<template>
    <div class="flex h-screen bg-gray-50">
        <SideMenu />
        <main class="flex-1 overflow-auto p-6">
            <h1 class="title">welcome to the dashboard {{ $page.props.auth.user.name }}</h1>
        </main>
    </div>
</template>
