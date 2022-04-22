<script setup>
const props = defineProps({
    color: {type: String, default: 'blue'},
    textColor: {type: String, default: 'white'},
    disabled: Boolean
});


</script>

<template>
    <button class="p-3 disabled:bg-gray-400 disabled:cursor-not-allowed" :class="'bg-' + color + '-500 hover:bg-' + color + '-400 text-' + textColor" :disabled="disabled">
        <slot/>
    </button>
</template>

