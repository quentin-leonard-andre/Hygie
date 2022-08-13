<script>
    import { useForm } from '@inertiajs/inertia-vue3'

    export default {
        components: {
            useForm
        },
        props: {
            seances: {
                type: Array,
                default: [],
            },
        },
        data() {
            return {
                form: useForm({
                    nom: null,
                })
            };
        },
        methods: {
            submit(id){
                this.form.delete(
                    route("seances.destroy", {
                        seance: id
                    }),{}
                );
            },
            redirectTo(route){
                window.location.href = route;
            }
        }
        
    }
</script>

<template>

        <!-- Recherche -->
        <input type="text" placeholder="Rechercher ..." class="input input-bordered w-full max-w-xs mt-4" />

        <!-- Table -->
        <div class="overflow-x-auto mt-4">
            <table class="table w-full">
                <!-- Entete -->
                <thead>
                    <tr>
                        <th class="text-center"></th>
                        <th>Date de début</th>
                        <th>Date de fin</th>
                        <th></th>
                    </tr>
                </thead>
                <!-- Contenu -->
                <tbody>
                    <tr v-for="seance in seances" class="hover">
                        <th v-on:click="redirectTo(route('seances.show', {seance: seance.id}))" class="text-center cursor-pointer">{{seance.id}}</th>
                        <td v-on:click="redirectTo(route('seances.show', {seance: seance.id}))" class="cursor-pointer">{{seance.date_debut}}</td>
                        <td v-on:click="redirectTo(route('seances.show', {seance: seance.id}))" class="cursor-pointer">{{seance.date_fin}}</td>
                        <td class="text-center">
                            <div class="flex justify-end items-center gap-2">
                                <a class="btn btn-info" :href="route('seances.edit', {
                                    seance: seance.id
                                })">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"><path d="M19.769 9.923l-12.642 12.639-7.127 1.438 1.438-7.128 12.641-12.64 5.69 5.691zm1.414-1.414l2.817-2.82-5.691-5.689-2.816 2.817 5.69 5.692z"/></svg>
                                </a>
                                <form @submit.prevent="submit(seance.id)">
                                    <button class="btn btn-error" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" fill-rule="evenodd" clip-rule="evenodd" viewBox="0 0 24 24"><path d="M19 24h-14c-1.104 0-2-.896-2-2v-16h18v16c0 1.104-.896 2-2 2m3-19h-20v-2h6v-1.5c0-.827.673-1.5 1.5-1.5h5c.825 0 1.5.671 1.5 1.5v1.5h6v2zm-12-2h4v-1h-4v1z"/></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>

            <!-- Alerte si vide -->
            <div v-if="seances.length==0" class="alert alert-info shadow-lg my-3">
                <div>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="stroke-current flex-shrink-0 w-6 h-6"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span>Aucune séance n'existe pour l'instant.</span>
                </div>
            </div>
        </div>

</template>
