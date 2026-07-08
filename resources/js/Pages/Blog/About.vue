<script setup>
import { Link } from '@inertiajs/vue3';
import { Github, Linkedin, Mail, ExternalLink, Download } from 'lucide-vue-next';
import BlogLayout from '@/Layouts/BlogLayout.vue';
import SeoHead from '@/Components/Blog/SeoHead.vue';

defineProps({
    profile: Object,
    seo: Object,
});
</script>

<template>
    <BlogLayout :breadcrumbs="[{ label: 'Home', href: 'home' }, { label: 'About' }]">
        <SeoHead :seo="seo" />

        <div class="max-w-4xl mx-auto space-y-6">
            <!-- Hero -->
            <div class="cyber-card p-8 text-center">
                <div class="w-32 h-32 mx-auto rounded-full bg-cyber-primary/10 border-2 border-cyber-primary/30 flex items-center justify-center overflow-hidden">
                    <img
                        v-if="profile.avatar"
                        :src="profile.avatar"
                        :alt="profile.name"
                        class="w-full h-full object-cover"
                        @error="$event.target.style.display = 'none'"
                    />
                    <span v-else class="text-4xl font-mono text-cyber-primary">{{ profile.name.charAt(0) }}</span>
                </div>

                <h1 class="mt-6 text-3xl font-bold text-cyber-text">{{ profile.name }}</h1>
                <p class="mt-2 text-cyber-primary font-mono">{{ profile.title }}</p>

                <p class="mt-4 text-cyber-muted max-w-2xl mx-auto leading-relaxed">
                    {{ profile.bio }}
                </p>

                <div class="flex flex-wrap items-center justify-center gap-4 mt-6">
                    <a :href="profile.github" target="_blank" rel="noopener" class="cyber-btn-outline">
                        <Github class="w-4 h-4" /> GitHub
                    </a>
                    <a :href="profile.linkedin" target="_blank" rel="noopener" class="cyber-btn-outline">
                        <Linkedin class="w-4 h-4" /> LinkedIn
                    </a>
                    <a :href="`mailto:${profile.email}`" class="cyber-btn-outline">
                        <Mail class="w-4 h-4" /> Email
                    </a>
                    <a
                        v-if="profile.resume_url"
                        :href="profile.resume_url"
                        download="Hiago-Pais-CV.pdf"
                        class="cyber-btn-outline"
                    >
                        <Download class="w-4 h-4" /> Baixar CV
                    </a>
                </div>
            </div>

            <!-- Summary -->
            <div class="cyber-card p-6">
                <h2 class="font-mono text-lg text-cyber-primary mb-4">
                    <span class="text-cyber-muted">//</span> about.summary
                </h2>
                <p class="text-cyber-muted leading-relaxed whitespace-pre-line">{{ profile.summary }}</p>
            </div>

            <!-- Experience -->
            <div class="cyber-card p-6">
                <h2 class="font-mono text-lg text-cyber-primary mb-4">
                    <span class="text-cyber-muted">//</span> experience.log
                </h2>
                <div class="space-y-6">
                    <div
                        v-for="(exp, index) in profile.experience"
                        :key="index"
                        class="relative pl-6 border-l-2 border-cyber-primary/30"
                    >
                        <div class="absolute -left-[5px] top-1 w-2 h-2 rounded-full bg-cyber-primary" />
                        <h3 class="font-semibold text-cyber-text">{{ exp.company }}</h3>
                        <p class="text-sm text-cyber-primary font-mono">{{ exp.role }} · {{ exp.period }}</p>
                        <p class="mt-2 text-sm text-cyber-muted">{{ exp.description }}</p>
                        <ul v-if="exp.highlights?.length" class="mt-2 space-y-1">
                            <li
                                v-for="(item, itemIndex) in exp.highlights"
                                :key="itemIndex"
                                class="text-sm text-cyber-muted flex gap-2"
                            >
                                <span class="text-cyber-primary shrink-0">•</span>
                                <span>{{ item }}</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Technologies -->
            <div class="cyber-card p-6">
                <h2 class="font-mono text-lg text-cyber-primary mb-4">
                    <span class="text-cyber-muted">//</span> skills.json
                </h2>
                <div class="grid gap-6 sm:grid-cols-2">
                    <div v-for="(skills, category) in profile.technologies" :key="category">
                        <h3 class="text-sm font-mono text-cyber-text mb-2">{{ category }}</h3>
                        <div class="flex flex-wrap gap-2">
                            <span
                                v-for="skill in skills"
                                :key="skill"
                                class="cyber-tag"
                            >
                                {{ skill }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </BlogLayout>
</template>
