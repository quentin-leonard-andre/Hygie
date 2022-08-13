<script>
    import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
    import { Head } from '@inertiajs/inertia-vue3';
    import moment from 'moment';

    export default {
        components: {
            BreezeAuthenticatedLayout,
            Head
        },
        props: {
            machines: {
                type: Array,
                default: []
            }
        },
        methods: {
            redirectTo(route){
                window.location.href = route;
            }
        }
    }
</script>

<template>
    <Head title="Dashboard" />

    <BreezeAuthenticatedLayout>
        <h1 class='text-4xl'>Bienvenue</h1>

        <div class="mt-12 rounded-lg flex flex-col sm:flex-row gap-4">
            <div class="stats shadow border">
                <div class="stat">
                    <div class="stat-title">Dernière séance</div>
                    <div class="stat-value">1h36</div>
                    <div class="stat-desc">3 utilisées fréquemment</div>
                </div>
            </div>

            <div v-on:click="redirectTo(route('machines.index'))" class="stats shadow border cursor-pointer">
                <div class="stat">
                    <div class="stat-title">Machines</div>
                    <div class="stat-value">{{machines.length}}</div>
                </div>
            </div>
        </div>

    </BreezeAuthenticatedLayout>
</template>