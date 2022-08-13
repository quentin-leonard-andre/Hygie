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
            machines: Array,
            machine: {
                type: Object,
                default: null
            }
        },
        data(props) {
            let form = useForm({
                nom: null,
            });

            if(props.machine !== null){
                form.nom = props.machine.nom;
            }

            //Retourne les données
            return {
                form
            }
        },
        methods: {
            submit(){
                if(this.machine){
                    this.form.put(
                        route("machines.update", {machine: this.machine.id}),{
                            onSuccess: () => this.form.reset(),
                        }, {
                            preserveState: true,
                        }
                    );
                }
                else{
                    this.form.post(
                        route("machines.store"),{
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

    <div v-if="machine">
        <h2 class='text-xl mt-6'>Modification de "{{form.nom}}"</h2>
    </div>

    <form @submit.prevent="submit">
        <!-- Nom -->
        <div class="mt-4 flex flex-col gap-2">
            <label for="nom">Nom</label>
            <input id="nom" v-model="form.nom" type="text" placeholder="Nom ..." class="input input-bordered w-full max-w-md" :class="{'input-error': (errors && errors.nom)}"/>
            <div class="text-error" v-if="errors && errors.nom">{{ errors.nom }}</div>
        </div>

        <!-- Bouton de validation -->
        <div class="mt-4 flex justify-end">
            <button class="btn btn-primary" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">Enregistrer</button>
        </div>
    </form>
    
</template>
