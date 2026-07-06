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

                <div class="flex items-center justify-center gap-4 mt-6">
                    <a :href="profile.github" target="_blank" rel="noopener" class="cyber-btn-outline">
                        <Github class="w-4 h-4" /> GitHub
                    </a>
                    <a :href="profile.linkedin" target="_blank" rel="noopener" class="cyber-btn-outline">
                        <Linkedin class="w-4 h-4" /> LinkedIn
                    </a>
                    <a :href="`mailto:${profile.email}`" class="cyber-btn-outline">
                        <Mail class="w-4 h-4" /> Email
                    </a>
                </div>
            </div>

            <!-- Summary -->
            <div class="cyber-card p-6">
                <h2 class="font-mono text-lg text-cyber-primary mb-4">
                    <span class="text-cyber-muted">//</span> about.summary
                </h2>
                <p class="text-cyber-muted leading-relaxed">{{ profile.summary }}</p>
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
                        <h3 class="font-semibold text-cyber-text">{{ exp.role }}</h3>
                        <p class="text-sm text-cyber-primary font-mono">{{ exp.company }} · {{ exp.period }}</p>
                        <p class="mt-2 text-sm text-cyber-muted">{{ exp.description }}</p>
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

            <!-- Projects -->
            <div class="cyber-card p-6">
                <h2 class="font-mono text-lg text-cyber-primary mb-4">
                    <span class="text-cyber-muted">//</span> projects/
                </h2>
                <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                    <div
                        v-for="project in profile.projects"
                        :key="project.name"
                        class="p-4 rounded-lg border border-cyber-border hover:border-cyber-primary/40 transition-colors"
                    >
                        <h3 class="font-semibold text-cyber-text">{{ project.name }}</h3>
                        <p class="mt-2 text-sm text-cyber-muted">{{ project.description }}</p>
                        <a
                            v-if="project.url"
                            :href="project.url"
                            target="_blank"
                            rel="noopener"
                            class="inline-flex items-center gap-1 mt-3 text-sm text-cyber-primary hover:text-cyber-hover font-mono"
                        >
                            <ExternalLink class="w-3.5 h-3.5" /> visit
                        </a>
                    </div>
                </div>
            </div>

            <!-- Goal -->
            <div class="cyber-card p-6">
                <h2 class="font-mono text-lg text-cyber-primary mb-4">
                    <span class="text-cyber-muted">//</span> career.goal
                </h2>
                <p class="text-cyber-muted leading-relaxed">{{ profile.goal }}</p>
            </div>
        </div>
    </BlogLayout>
</template>
