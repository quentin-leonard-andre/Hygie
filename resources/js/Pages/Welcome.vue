<script setup>
import { Head, Link } from '@inertiajs/inertia-vue3';

defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    laravelVersion: String,
    phpVersion: String,
})
</script>

<template>
    <Head title="Bienvenue" />

    <div class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 ">
        <div v-if="canLogin" class="fixed top-0 right-0 px-6 py-4">
            <Link v-if="$page.props.auth.user" :href="route('dashboard')" class="text-sm text-gray-700 underline">
                Plateforme
            </Link>

            <template v-else>
                <Link :href="route('login')" class="text-sm text-gray-700 underline">
                    Connexion
                </Link>

                <Link v-if="canRegister" :href="route('register')" class="ml-4 text-sm text-gray-700 underline">
                    Inscription
                </Link>
            </template>
        </div>
    </div>
</template>