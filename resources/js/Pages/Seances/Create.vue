<script>

    import { reactive } from 'vue';
    import { Inertia } from '@inertiajs/inertia'
    import { useForm } from '@inertiajs/inertia-vue3'

    export default {
        components: {
            reactive,
            Inertia,
            useForm
        },
        props: {
            errors: Object,
            seances: Array,
            seance: {
                type: Object,
                default: null
            }
        },
        data(props) {
            let form = useForm({
                date_debut: null,
                date_fin: null,
            });

            if(props.seance !== null){
                form.date_debut = props.seance.date_debut;
                form.date_fin = props.seance.date_fin;
            }

            //Retourne les données
            return {
                form
            }
        },
        methods: {
            submit(){
                if(this.seance){
                    this.form.put(
                        route("seances.update", {seance: this.seance.id}),{
                            onSuccess: () => this.form.reset(),
                        }, {
                            preserveState: true,
                        }
                    );
                }
                else{
                    this.form.post(
                        route("seances.store"),{
                            onSuccess: () => this.form.reset(),
                        }, {
                            preserveState: true,
                        }
                    );
                }
                
            }
        }
    }
</script>

<template>

    <div v-if="seance">
        <h2 class='text-xl mt-6'>Modification d'une séance</h2>
    </div>

    <form @submit.prevent="submit">
        <!-- Date de début -->
        <div class="mt-4 flex flex-col gap-2">
            <label for="date_debut">Date de début</label>
            <input id="date_debut" v-model="form.date_debut" type="datetime-local" placeholder="Date de début ..." class="input input-bordered w-full max-w-md" :class="{'input-error': (errors && errors.date_debut)}"/>
            <div class="text-error" v-if="errors && errors.date_debut">{{ errors.date_debut }}</div>
        </div>

        <!-- Date de fin -->
        <div class="mt-4 flex flex-col gap-2">
            <label for="date_fin">Date de fin</label>
            <input id="date_fin" v-model="form.date_fin" type="datetime-local" placeholder="Date de début ..." class="input input-bordered w-full max-w-md" :class="{'input-error': (errors && errors.date_fin)}"/>
            <div class="text-error" v-if="errors && errors.date_fin">{{ errors.date_fin }}</div>
        </div>

        <!-- Bouton de validation -->
        <div class="mt-4 flex justify-end">
            <button class="btn btn-primary" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">Enregistrer</button>
        </div>
    </form>
    
</template>
