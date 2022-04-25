<script setup>
const props = defineProps({
    color: {type: String, default: 'white'},
    padding: {type: String, default: '6'}
});
</script>

<template>
    <div class="flex flex-col shadow-md" :class="'bg-' + color">
        <div v-if="$slots.header" class="w-full border-b border-gray-200 text-lg py-3" :class="'px-' + padding">
            <slot name="header"/>
        </div>
        <div :class="'px-' + padding" class="w-full">
            <slot/>
        </div>
        <slot name="footer"/>
    </div>
</template>
