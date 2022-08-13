<script>
    import { onMounted, ref } from 'vue';

    const input = ref(null);

    export default {
        emits: ['update:modelValue'],
        props: {
            modelValue:{},
            placeholder: {
                type: String,
                default: ""
            }
        },
        data() {
            return {
            }
        },
        onMounted(){
            if (input.value.hasAttribute('autofocus')) {
                input.value.focus();
            }
        }
    }
</script>

<template>
    <input :value="modelValue" @input="$emit('update:modelValue', $event.target.value)" ref="input" type="text" :placeholder="placeholder" class="input input-bordered w-full max-w-xs" />
</template>
