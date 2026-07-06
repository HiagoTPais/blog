<script setup>
import Sidebar from '@/Components/Blog/Sidebar.vue';
import Topbar from '@/Components/Blog/Topbar.vue';

defineProps({
    breadcrumbs: {
        type: Array,
        default: () => [{ label: 'Home', href: 'home' }],
    },
});
</script>

<template>
    <div class="min-h-screen bg-cyber-bg">
        <Sidebar />

        <div class="lg:pl-64">
            <Topbar :breadcrumbs="breadcrumbs" />

            <main class="p-4 lg:p-6">
                <slot />
            </main>
        </div>
    </div>
</template>
