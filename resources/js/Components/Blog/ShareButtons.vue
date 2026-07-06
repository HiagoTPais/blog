<script setup>
import { Link2, Twitter, Linkedin } from 'lucide-vue-next';
import { computed } from 'vue';

const props = defineProps({
    title: String,
    url: String,
});

const shareUrl = computed(() => props.url || (typeof window !== 'undefined' ? window.location.href : ''));

function copyLink() {
    navigator.clipboard.writeText(shareUrl.value);
}

function shareTwitter() {
    window.open(
        `https://twitter.com/intent/tweet?text=${encodeURIComponent(props.title)}&url=${encodeURIComponent(shareUrl.value)}`,
        '_blank'
    );
}

function shareLinkedIn() {
    window.open(
        `https://www.linkedin.com/sharing/share-offsite/?url=${encodeURIComponent(shareUrl.value)}`,
        '_blank'
    );
}
</script>

<template>
    <div class="flex items-center gap-3">
        <span class="text-sm text-cyber-muted font-mono">share:</span>
        <button
            class="p-2 rounded-md text-cyber-muted hover:text-cyber-primary hover:bg-cyber-primary/10 transition-colors"
            title="Copiar link"
            @click="copyLink"
        >
            <Link2 class="w-4 h-4" />
        </button>
        <button
            class="p-2 rounded-md text-cyber-muted hover:text-cyber-primary hover:bg-cyber-primary/10 transition-colors"
            title="Compartilhar no Twitter"
            @click="shareTwitter"
        >
            <Twitter class="w-4 h-4" />
        </button>
        <button
            class="p-2 rounded-md text-cyber-muted hover:text-cyber-primary hover:bg-cyber-primary/10 transition-colors"
            title="Compartilhar no LinkedIn"
            @click="shareLinkedIn"
        >
            <Linkedin class="w-4 h-4" />
        </button>
    </div>
</template>
