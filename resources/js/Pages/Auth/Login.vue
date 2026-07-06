<script setup>
import { Link, Head, useForm } from '@inertiajs/vue3';

defineProps({
    canResetPassword: Boolean,
    status: String,
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

function submit() {
    form.post(route('login'));
}
</script>

<template>
    <div class="min-h-screen flex items-center justify-center bg-cyber-bg p-4">
        <Head title="Login" />

        <div class="w-full max-w-md cyber-card p-8">
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-14 h-14 rounded-lg bg-cyber-primary/10 border border-cyber-primary/30 mb-4 overflow-hidden">
                    <img src="/img/icone.png" alt="Logo" class="w-10 h-10 object-contain" />
                </div>
                <h1 class="font-mono text-xl text-cyber-primary">admin_login</h1>
            </div>

            <div v-if="status" class="mb-4 text-sm text-cyber-primary">{{ status }}</div>

            <form class="space-y-4" @submit.prevent="submit">
                <div>
                    <label class="block text-sm font-mono text-cyber-muted mb-1">Email</label>
                    <input v-model="form.email" type="email" class="cyber-input w-full px-3 py-2" required autofocus />
                    <p v-if="form.errors.email" class="mt-1 text-xs text-red-400">{{ form.errors.email }}</p>
                </div>

                <div>
                    <label class="block text-sm font-mono text-cyber-muted mb-1">Senha</label>
                    <input v-model="form.password" type="password" class="cyber-input w-full px-3 py-2" required />
                    <p v-if="form.errors.password" class="mt-1 text-xs text-red-400">{{ form.errors.password }}</p>
                </div>

                <label class="flex items-center gap-2 text-sm text-cyber-muted">
                    <input v-model="form.remember" type="checkbox" class="rounded border-cyber-border bg-cyber-bg text-cyber-primary focus:ring-cyber-primary" />
                    Lembrar-me
                </label>

                <button type="submit" class="cyber-btn w-full" :disabled="form.processing">
                    {{ form.processing ? 'Entrando...' : 'Entrar' }}
                </button>
            </form>

            <div class="mt-6 text-center">
                <Link :href="route('home')" class="text-sm text-cyber-muted hover:text-cyber-primary font-mono transition-colors">
                    ← Voltar ao blog
                </Link>
            </div>
        </div>
    </div>
</template>
