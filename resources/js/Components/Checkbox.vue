<script>
    import { computed } from 'vue';

    export default {
        emits: ['update:checked'],
        props: {
            label: {
                type: String,
                default: ""
            },
            checked: {
                type: [Array, Boolean],
                default: false,
            },
            value: {
                default: null,
            },
        },
        data() {
            return {
                titleClass: 'title'
            }
        },
        computed: {
            proxyChecked: {
                get() {
                    return this.checked;
                },

                set(val) {
                    this.$emit("update:checked", val);
                },
            }
        }
    }
</script>

<template>
    <div class="form-control">
        <label class="label cursor-pointer">
            <input :value="value" v-model="proxyChecked" type="checkbox" class="checkbox" />
            <span class="label-text ml-2">
                {{ label }}
            </span> 
        </label>
    </div>
</template>
