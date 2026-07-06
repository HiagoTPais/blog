<script setup>
defineProps({
    headings: {
        type: Array,
        default: () => [],
    },
});

function scrollTo(id) {
    const el = document.getElementById(id);
    if (el) {
        el.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }
}
</script>

<template>
    <nav v-if="headings.length" class="cyber-card p-5 sticky top-24">
        <h3 class="font-mono text-sm font-semibold text-cyber-primary mb-4">
            <span class="text-cyber-muted">//</span> table_of_contents
        </h3>
        <ul class="space-y-2">
            <li
                v-for="heading in headings"
                :key="heading.id"
                :style="{ paddingLeft: `${(heading.level - 1) * 12}px` }"
            >
                <button
                    class="text-sm text-cyber-muted hover:text-cyber-primary transition-colors text-left font-mono"
                    @click="scrollTo(heading.id)"
                >
                    {{ heading.text }}
                </button>
            </li>
        </ul>
    </nav>
</template>
