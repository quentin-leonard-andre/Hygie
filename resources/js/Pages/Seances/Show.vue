<script>
    import moment from 'moment';
    import 'moment/dist/locale/fr';
    import { useForm } from '@inertiajs/inertia-vue3'

    export default {
        components: {
            useForm
        },
        props: {
            seance: {
                type: Object,
                default: null
            },
            message: {
                type: String
            },
        },
        setup(props){
            moment.locale('fr');
            //Formatage des dates
            props.seance.date_debut = moment(new Date(props.seance.date_debut)).format('LLL');
            props.seance.date_fin = moment(new Date(props.seance.date_fin)).format('LLL');
        },
        data(){
            return {
                form: useForm({
                })
            };
        },
        methods: {
            submit(id){
                this.form.delete(
                    route("exercices.destroy", {
                        seance: this.seance.id,
                        exercice: id
                    }),{}
                );
            },
        }
    }
</script>

<template>
    <div class="mt-6">
        <h2 class="text-3xl">Séance du {{ seance.date_debut }}</h2>

        <p>Date de début {{ seance.date_debut }}</p>
        <p>Date de fin {{ seance.date_fin }}</p>

        <!-- Panel exercices -->
        <div class="mt-6">
            <h2 class="text-2xl">Exercices</h2>

            <div class='my-3 flex gap-2'>
                <a :href="route('exercices.create', {seance: seance.id})" class="btn mt-6 btn-primary">Nouveau</a>
                <a :href="route('seances.edit', {seance: seance.id})" class="btn mt-6 btn-secondary">Modifier</a>
            </div>
            

            <!-- Table -->
            <div class="overflow-x-auto mt-4">
                <table class="table w-full">
                    <thead>
                        <th>Série</th>
                        <th>Machine</th>
                        <th>Répétitions</th>
                        <th>Poids</th>
                        <th>Distance</th>
                        <th>Niveau</th>
                        <th>Temps</th>
                        <th></th>
                    </thead>

                    <tbody>
                        <tr v-for="exercice in seance.exercices">
                            <td>{{ exercice.numero_serie }}</td>
                            <td><span v-if="exercice.machine">{{ exercice.machine.nom }}</span></td>
                            <td>{{ exercice.repetitions }}</td>
                            <td>{{ exercice.poids }}</td>
                            <td>{{ exercice.distance }}</td>
                            <td>{{ exercice.niveau }}</td>
                            <td>{{ exercice.temps }}</td>
                            <td>
                                <td class="text-center">
                                    <div class="flex justify-end items-center gap-2">
                                        <a class="btn btn-info" :href="route('exercices.edit', {
                                            seance: seance.id,
                                            exercice: exercice.id
                                        })">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"><path d="M19.769 9.923l-12.642 12.639-7.127 1.438 1.438-7.128 12.641-12.64 5.69 5.691zm1.414-1.414l2.817-2.82-5.691-5.689-2.816 2.817 5.69 5.692z"/></svg>
                                        </a>
                                        <form @submit.prevent="submit(exercice.id)">
                                            <button class="btn btn-error" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" fill-rule="evenodd" clip-rule="evenodd" viewBox="0 0 24 24"><path d="M19 24h-14c-1.104 0-2-.896-2-2v-16h18v16c0 1.104-.896 2-2 2m3-19h-20v-2h6v-1.5c0-.827.673-1.5 1.5-1.5h5c.825 0 1.5.671 1.5 1.5v1.5h6v2zm-12-2h4v-1h-4v1z"/></svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>
