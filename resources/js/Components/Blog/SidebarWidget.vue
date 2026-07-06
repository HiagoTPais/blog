<script setup>
defineProps({
    title: {
        type: String,
        required: true,
    },
});
</script>

<template>
    <div class="cyber-card p-5">
        <h3 class="font-mono text-sm font-semibold text-cyber-primary mb-4 flex items-center gap-2">
            <span class="text-cyber-muted">//</span>
            {{ title }}
        </h3>
        <slot />
    </div>
</template>
