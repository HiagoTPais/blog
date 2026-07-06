<script setup>
import { Link } from '@inertiajs/vue3';
import { ChevronLeft, ChevronRight } from 'lucide-vue-next';

defineProps({
    links: {
        type: Array,
        default: () => [],
    },
    meta: {
        type: Object,
        default: () => ({}),
    },
});

function isPrevious(label) {
    return label.includes('Previous') || label.includes('Anterior');
}

function isNext(label) {
    return label.includes('Next') || label.includes('Próximo');
}
</script>

<template>
    <nav v-if="links.length > 3" class="flex items-center justify-center gap-1 mt-8">
        <template v-for="(link, index) in links" :key="index">
            <Link
                v-if="link.url"
                :href="link.url"
                :class="[
                    'inline-flex items-center justify-center min-w-[2.25rem] h-9 px-3 rounded-md text-sm font-mono transition-colors',
                    link.active
                        ? 'bg-cyber-primary text-cyber-bg'
                        : 'text-cyber-muted hover:text-cyber-text hover:bg-cyber-card border border-cyber-border',
                ]"
                preserve-scroll
            >
                <ChevronLeft v-if="isPrevious(link.label)" class="w-4 h-4" />
                <ChevronRight v-else-if="isNext(link.label)" class="w-4 h-4" />
                <span v-else v-html="link.label" />
            </Link>
            <span
                v-else
                :class="[
                    'inline-flex items-center justify-center min-w-[2.25rem] h-9 px-3 rounded-md text-sm font-mono',
                    'text-cyber-muted/50 cursor-not-allowed border border-cyber-border/50',
                ]"
            >
                <ChevronLeft v-if="isPrevious(link.label)" class="w-4 h-4" />
                <ChevronRight v-else-if="isNext(link.label)" class="w-4 h-4" />
                <span v-else v-html="link.label" />
            </span>
        </template>
    </nav>
</template>
