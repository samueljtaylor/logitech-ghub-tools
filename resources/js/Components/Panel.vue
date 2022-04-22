<script setup>
const props = defineProps({
    color: {type: String, default: 'white'},
    padding: {type: String, default: '6'}
});
</script>

<template>
    <div class="flex shadow-md" :class="'bg-' + color">
        <div :class="'p-' + padding">
            <div v-if="$slots.header" class="border-b border-gray-200 text-lg">
                <slot name="header"/>
            </div>
            <slot/>
        </div>
        <slot name="footer"/>
    </div>
</template>
