<script>
    import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
    import { Head } from '@inertiajs/inertia-vue3';

    import Index from '@/Pages/Machines/Index.vue';
    import Create from '@/Pages/Machines/Create.vue';

    export default {
        components: {
            BreezeAuthenticatedLayout,
            Head,
            Index,
            Create,
        },
        props: {
            machines: {
                type: Array,
                default: []
            },
            machine: {
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
            errors: Object,
        },
        data() {
            return {
                tab_links: [
                    {
                        nom: 'Liste',
                        route: route('machines.index')
                    },
                    {
                        nom: 'Nouveau',
                        route: route('machines.create')
                    }
                ]
            }
        }
    }
</script>

<template>
    <Head title="Machines" />

    <BreezeAuthenticatedLayout>
        <h1 class='text-4xl'>Machines</h1>

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
        <Index v-if="active_tab == 'Liste'" :machines="machines"></Index>

        <!-- Nouveau -->
        <Create v-if="active_tab == 'Nouveau'" :errors="errors"></Create>

        <!-- Modification -->
        <Create v-if="active_tab == 'Edition'" :errors="errors" :machine="machine"></Create>

    </BreezeAuthenticatedLayout>
</template>
