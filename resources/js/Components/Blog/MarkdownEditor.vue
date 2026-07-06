<script setup>
import { ref, computed, watch } from 'vue';
import { Eye, Edit3 } from 'lucide-vue-next';
import MarkdownRenderer from './MarkdownRenderer.vue';

const content = defineModel({ type: String, default: '' });

const activeTab = ref('edit');

const toolbarItems = [
    { label: 'H1', prefix: '# ', suffix: '' },
    { label: 'H2', prefix: '## ', suffix: '' },
    { label: 'H3', prefix: '### ', suffix: '' },
    { label: 'B', prefix: '**', suffix: '**' },
    { label: 'I', prefix: '*', suffix: '*' },
    { label: 'Link', prefix: '[', suffix: '](url)' },
    { label: 'Code', prefix: '```\n', suffix: '\n```' },
    { label: 'Quote', prefix: '> ', suffix: '' },
    { label: 'List', prefix: '- ', suffix: '' },
    { label: 'Check', prefix: '- [ ] ', suffix: '' },
    { label: 'Table', prefix: '| Col1 | Col2 |\n|------|------|\n| ', suffix: ' | val |' },
    { label: 'Img', prefix: '![alt](', suffix: ')' },
];

const textarea = ref(null);

function insertMarkdown(prefix, suffix) {
    const el = textarea.value;
    if (!el) return;

    const start = el.selectionStart;
    const end = el.selectionEnd;
    const selected = content.value.substring(start, end);
    const replacement = prefix + (selected || 'texto') + suffix;

    content.value = content.value.substring(0, start) + replacement + content.value.substring(end);

    setTimeout(() => {
        el.focus();
        el.setSelectionRange(start + prefix.length, start + prefix.length + (selected || 'texto').length);
    }, 0);
}

const wordCount = computed(() => {
    return content.value.trim().split(/\s+/).filter(Boolean).length;
});
</script>

<template>
    <div class="cyber-card overflow-hidden">
        <!-- Tabs -->
        <div class="flex items-center justify-between border-b border-cyber-border px-4">
            <div class="flex">
                <button
                    :class="[
                        'flex items-center gap-2 px-4 py-3 text-sm font-mono transition-colors border-b-2',
                        activeTab === 'edit'
                            ? 'border-cyber-primary text-cyber-primary'
                            : 'border-transparent text-cyber-muted hover:text-cyber-text',
                    ]"
                    type="button"
                    @click="activeTab = 'edit'"
                >
                    <Edit3 class="w-4 h-4" />
                    Editar
                </button>
                <button
                    :class="[
                        'flex items-center gap-2 px-4 py-3 text-sm font-mono transition-colors border-b-2',
                        activeTab === 'preview'
                            ? 'border-cyber-primary text-cyber-primary'
                            : 'border-transparent text-cyber-muted hover:text-cyber-text',
                    ]"
                    type="button"
                    @click="activeTab = 'preview'"
                >
                    <Eye class="w-4 h-4" />
                    Preview
                </button>
            </div>
            <span class="text-xs text-cyber-muted font-mono">{{ wordCount }} palavras</span>
        </div>

        <!-- Toolbar -->
        <div v-if="activeTab === 'edit'" class="flex flex-wrap gap-1 p-2 border-b border-cyber-border bg-cyber-bg/50">
            <button
                v-for="item in toolbarItems"
                :key="item.label"
                type="button"
                class="px-2 py-1 text-xs font-mono text-cyber-muted hover:text-cyber-primary hover:bg-cyber-primary/10 rounded transition-colors"
                @click="insertMarkdown(item.prefix, item.suffix)"
            >
                {{ item.label }}
            </button>
        </div>

        <!-- Editor / Preview -->
        <div class="min-h-[400px]">
            <textarea
                v-show="activeTab === 'edit'"
                ref="textarea"
                v-model="content"
                class="w-full min-h-[400px] p-4 bg-transparent text-cyber-text font-mono text-sm resize-y focus:outline-none"
                placeholder="Escreva seu conteúdo em Markdown..."
            />
            <div v-show="activeTab === 'preview'" class="p-6 min-h-[400px]">
                <MarkdownRenderer :content="content" />
            </div>
        </div>
    </div>
</template>
