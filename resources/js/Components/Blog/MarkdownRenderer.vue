<script setup>
import { computed, onMounted, ref, watch } from 'vue';
import { useMarkdown } from '@/composables/useMarkdown';

const props = defineProps({
    content: {
        type: String,
        default: '',
    },
    html: {
        type: String,
        default: '',
    },
});

const { render } = useMarkdown();
const container = ref(null);

const renderedHtml = computed(() => props.html || render(props.content));

onMounted(() => highlightCode());
watch(renderedHtml, () => highlightCode());

async function highlightCode() {
    if (!container.value) return;

    const blocks = container.value.querySelectorAll('pre code');
    if (!blocks.length) return;

    try {
        const { codeToHtml } = await import('shiki');
        const theme = 'github-dark';

        for (const block of blocks) {
            const lang = block.className.replace('language-', '') || 'text';
            const code = block.textContent;
            block.parentElement.outerHTML = await codeToHtml(code, { lang, theme });
        }
    } catch {
        // Fallback: keep default styling
    }
}
</script>

<template>
    <div
        ref="container"
        class="prose-cyber"
        v-html="renderedHtml"
    />
</template>
