<script>
    import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
    import { Head } from '@inertiajs/inertia-vue3';

    import Index from '@/Pages/Seances/Index.vue';
    import Create from '@/Pages/Seances/Create.vue';
    import Show from '@/Pages/Seances/Show.vue';
    import ExerciceCreate from '@/Pages/Exercices/Create.vue';

    export default {
        components: {
            BreezeAuthenticatedLayout,
            Head,
            Index,
            Create,
            Show,
            ExerciceCreate
        },
        props: {
            seances: {
                type: Array,
                default: []
            },
            seance: {
                type: Object,
                default: null
            },
            exercice: {
                type: Object,
                default: null
            },
            active_tab: {
                type: String, 
                default: "Liste"
            },
            message: {
                type: String
            },
            machines: {
                type: Array,
                default: []
            },
            errors: Object,
        },
        data() {
            return {
                tab_links: [
                    {
                        nom: 'Liste',
                        route: route('seances.index')
                    },
                    {
                        nom: 'Nouveau',
                        route: route('seances.create')
                    }
                ]
            }
        }
    }
</script>

<template>
    <Head title="Séances" />

    <BreezeAuthenticatedLayout>
        <h1 class='text-4xl'>Séances</h1>

        <div v-if="$page.props.flash.message" class="alert alert-success shadow-lg mt-6">
            <div>
                <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current flex-shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                <span>{{$page.props.flash.message}}</span>
            </div>
        </div>

        <!-- Liens -->
        <div class="tabs tabs-boxed mt-6">
            <a v-for="tab_link in tab_links" :href="tab_link.route" @click="active_tab = tab_link.nom" class="tab tab-lg" :class="{'tab-active': (tab_link.nom == active_tab)}">{{tab_link.nom}}</a> 
        </div>

        <!-- Index -->
        <Index v-if="active_tab == 'Liste'" :seances="seances"></Index>

        <!-- Nouveau -->
        <Create v-if="active_tab == 'Nouveau'" :errors="errors"></Create>

        <!-- Modification -->
        <Create v-if="active_tab == 'Edition'" :errors="errors" :seance="seance"></Create>

        <!-- Voir -->
        <Show v-if="active_tab == 'Voir'" :seance="seance"></Show>

        <!-- Nouvel exercice -->
        <ExerciceCreate v-if="active_tab == 'Exercice/Create'" :errors="errors" :seance="seance" :machines="machines" :exercice="exercice"></ExerciceCreate>

    </BreezeAuthenticatedLayout>
</template>
