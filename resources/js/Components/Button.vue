<!-- SCRIPTS -->
<script setup>
    defineProps({
        type: {
            type: String,
            default: 'submit',
        },
    });
</script>

<!-- DOM -->
<template>
    <button :type="type" class="btn">
        <slot />
    </button>
</template>
