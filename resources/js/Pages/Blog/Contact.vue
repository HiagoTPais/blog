<script setup>
import { useForm, usePage } from '@inertiajs/vue3';
import { Github, Linkedin, Mail, Send, CheckCircle } from 'lucide-vue-next';
import BlogLayout from '@/Layouts/BlogLayout.vue';
import SeoHead from '@/Components/Blog/SeoHead.vue';

defineProps({
    social: Object,
    seo: Object,
});

const page = usePage();

const form = useForm({
    name: '',
    email: '',
    subject: '',
    message: '',
});

function submit() {
    form.post(route('contact.store'), {
        preserveScroll: true,
        onSuccess: () => form.reset(),
    });
}
</script>

<template>
    <BlogLayout :breadcrumbs="[{ label: 'Home', href: 'home' }, { label: 'Contato' }]">
        <SeoHead :seo="seo" />

        <div class="max-w-4xl mx-auto grid gap-6 lg:grid-cols-5">
            <!-- Form -->
            <div class="lg:col-span-3 cyber-card p-6">
                <h1 class="font-mono text-xl text-cyber-primary mb-6">
                    <span class="text-cyber-muted">$</span> send_message
                </h1>

                <div
                    v-if="page.props.flash?.success"
                    class="flex items-center gap-2 p-4 mb-6 rounded-md bg-cyber-primary/10 border border-cyber-primary/30 text-cyber-primary text-sm"
                >
                    <CheckCircle class="w-5 h-5 shrink-0" />
                    {{ page.props.flash.success }}
                </div>

                <form class="space-y-4" @submit.prevent="submit">
                    <div>
                        <label class="block text-sm font-mono text-cyber-muted mb-1">Nome</label>
                        <input v-model="form.name" type="text" class="cyber-input w-full px-3 py-2" required />
                        <p v-if="form.errors.name" class="mt-1 text-xs text-red-400">{{ form.errors.name }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-mono text-cyber-muted mb-1">Email</label>
                        <input v-model="form.email" type="email" class="cyber-input w-full px-3 py-2" required />
                        <p v-if="form.errors.email" class="mt-1 text-xs text-red-400">{{ form.errors.email }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-mono text-cyber-muted mb-1">Assunto</label>
                        <input v-model="form.subject" type="text" class="cyber-input w-full px-3 py-2" required />
                        <p v-if="form.errors.subject" class="mt-1 text-xs text-red-400">{{ form.errors.subject }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-mono text-cyber-muted mb-1">Mensagem</label>
                        <textarea
                            v-model="form.message"
                            rows="6"
                            class="cyber-input w-full px-3 py-2 resize-y"
                            required
                        />
                        <p v-if="form.errors.message" class="mt-1 text-xs text-red-400">{{ form.errors.message }}</p>
                    </div>

                    <button
                        type="submit"
                        class="cyber-btn w-full sm:w-auto"
                        :disabled="form.processing"
                    >
                        <Send class="w-4 h-4" />
                        {{ form.processing ? 'Enviando...' : 'Enviar Mensagem' }}
                    </button>
                </form>
            </div>

            <!-- Contact info -->
            <div class="lg:col-span-2 space-y-6">
                <div class="cyber-card p-6">
                    <h2 class="font-mono text-sm text-cyber-primary mb-4">
                        <span class="text-cyber-muted">//</span> contact.info
                    </h2>
                    <div class="space-y-4">
                        <a
                            :href="`mailto:${social.email}`"
                            class="flex items-center gap-3 text-cyber-muted hover:text-cyber-primary transition-colors"
                        >
                            <Mail class="w-5 h-5" />
                            <span class="text-sm">{{ social.email }}</span>
                        </a>
                        <a
                            :href="social.github"
                            target="_blank"
                            rel="noopener"
                            class="flex items-center gap-3 text-cyber-muted hover:text-cyber-primary transition-colors"
                        >
                            <Github class="w-5 h-5" />
                            <span class="text-sm">GitHub</span>
                        </a>
                        <a
                            :href="social.linkedin"
                            target="_blank"
                            rel="noopener"
                            class="flex items-center gap-3 text-cyber-muted hover:text-cyber-primary transition-colors"
                        >
                            <Linkedin class="w-5 h-5" />
                            <span class="text-sm">LinkedIn</span>
                        </a>
                    </div>
                </div>

                <div class="cyber-card p-6">
                    <p class="text-sm text-cyber-muted leading-relaxed">
                        Envie uma mensagem e responderei o mais breve possível.
                    </p>
                </div>
            </div>
        </div>
    </BlogLayout>
</template>
