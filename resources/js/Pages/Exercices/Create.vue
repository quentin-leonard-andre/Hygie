<script>
    import moment from 'moment';
    import 'moment/dist/locale/fr';

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
            seance: {
                type: Object,
                default: null
            },
            errors: Object,
            machines: {
                type: Array,
                default: null
            },
            exercice: {
                type: Object,
                default: null
            }
        },
        data(props) {
            let form = useForm({
                distance: null,
                niveau: null,
                temps: null,
                numero_serie: null,
                repetitions: null,
                poids: null,
                machine_id: null,
            });

            if(props.exercice !== null){
                form.distance = props.exercice.distance;
                form.niveau = props.exercice.niveau;
                form.temps = props.exercice.temps;
                form.numero_serie = props.exercice.numero_serie;
                form.repetitions = props.exercice.repetitions;
                form.poids = props.exercice.poids;
                form.machine_id = props.exercice.machine_id;
            }

            //Retourne les données
            return {
                form
            }
        },
        setup(props){
            //Formatage des dates
            moment.locale('fr');
            props.seance.date_debut = moment(new Date(props.seance.date_debut)).format('LLL');
            props.seance.date_fin = moment(new Date(props.seance.date_fin)).format('LLL');
        },
        methods: {
            submit(){
                //Modification
                if(this.exercice){
                    this.form.put(
                        route("exercices.update", {seance: this.seance.id, exercice: this.exercice.id}),{
                            onSuccess: () => this.form.reset(),
                        }, {
                            preserveState: true,
                        }
                    );
                }
                //Création
                else{
                    this.form.post(
                        route("exercices.store", {seance: this.seance.id}),{
                            onSuccess: () => this.form.reset(),
                        }, {
                            preserveState: true,
                        }
                    );
                }
                
            },
            //Récupère le dernier exercice
            async getLastExercice(machine_id){
                //Si une machine est fournie
                if(machine_id){
                    try {
                        //Appel à l'API
                        let res = await fetch(route('exercices.get_last_input', {machine: machine_id}));
                        res = await res.json();

                        //Si il y a un résultats
                        if(res){
                            this.form = res;
                            if(this.form.repetitions)
                                this.form.repetitions++;
                        }
                            
                    }catch (error) {
                        console.log(error);
                    }
                }
            }
        }
    }
</script>

<template>

    <div class="mt-6">
        <h2 class="text-3xl">Séance du {{ seance.date_debut }}</h2>

        <div class="mt-6">
            <h2 v-if="exercice" class='text-xl mt-6'>Modification d'un exercice</h2>
            <h2 v-else class="text-xl">Nouvel exercice</h2>

            <!-- FORMULAIRE -->
            <form @submit.prevent="submit">
                <!-- Numéro de série -->
                <div class="mt-4 flex flex-col gap-2">
                    <label for="numero_serie">Numéro de série</label>
                    <input id="numero_serie" step="1" v-model="form.numero_serie" type="number" placeholder="Numéro de série ..." class="input input-bordered w-full max-w-md" :class="{'input-error': (errors && errors.numero_serie)}"/>
                    <div class="text-error" v-if="errors && errors.numero_serie">{{ errors.numero_serie }}</div>
                </div>

                <!-- Machine -->
                <div class="mt-4 flex flex-col gap-2">
                    <label for="machine_id">Machine</label>
                    <select @change="getLastExercice(form.machine_id)" id="machine_id" v-model="form.machine_id" class="input input-bordered w-full max-w-md" :class="{'input-error': (errors && errors.machine_id)}">
                        <option></option>
                        <option v-for="machine in machines" :value="machine.id">
                            {{ machine.nom }}
                        </option>
                    </select>
                    <div class="text-error" v-if="errors && errors.machine_id">{{ errors.machine_id }}</div>
                </div>

                <!-- Répétitions -->
                <div class="mt-4 flex flex-col gap-2">
                    <label for="repetitions">Répétitions</label>
                    <input id="repetitions" step="0.01" v-model="form.repetitions" type="number" placeholder="Répétitions ..." class="input input-bordered w-full max-w-md" :class="{'input-error': (errors && errors.repetitions)}"/>
                    <div class="text-error" v-if="errors && errors.repetitions">{{ errors.repetitions }}</div>
                </div>

                <!-- Poids -->
                <div class="mt-4 flex flex-col gap-2">
                    <label for="poids">Poids</label>
                    <input id="poids" step="0.01" v-model="form.poids" type="number" placeholder="Poids ..." class="input input-bordered w-full max-w-md" :class="{'input-error': (errors && errors.poids)}"/>
                    <div class="text-error" v-if="errors && errors.poids">{{ errors.poids }}</div>
                </div>

                <!-- Distance -->
                <div class="mt-4 flex flex-col gap-2">
                    <label for="distance">Distance</label>
                    <input id="distance" step="0.01" v-model="form.distance" type="number" placeholder="Distance ..." class="input input-bordered w-full max-w-md" :class="{'input-error': (errors && errors.distance)}"/>
                    <div class="text-error" v-if="errors && errors.distance">{{ errors.distance }}</div>
                </div>

                <!-- Niveau -->
                <div class="mt-4 flex flex-col gap-2">
                    <label for="niveau">Niveau</label>
                    <input id="niveau" step="0.01" v-model="form.niveau" type="number" placeholder="Niveau ..." class="input input-bordered w-full max-w-md" :class="{'input-error': (errors && errors.niveau)}"/>
                    <div class="text-error" v-if="errors && errors.niveau">{{ errors.niveau }}</div>
                </div>

                <!-- Temps -->
                <div class="mt-4 flex flex-col gap-2">
                    <label for="temps">temps</label>
                    <input id="temps" step="0.01" v-model="form.temps" type="number" placeholder="temps ..." class="input input-bordered w-full max-w-md" :class="{'input-error': (errors && errors.temps)}"/>
                    <div class="text-error" v-if="errors && errors.temps">{{ errors.temps }}</div>
                </div>

                <!-- Bouton de validation -->
                <div class="mt-4 flex justify-end">
                    <button class="btn btn-primary" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>

</template>