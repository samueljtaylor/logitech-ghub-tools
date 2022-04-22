<script setup>
import {ref} from "vue";

const props = defineProps({
    card: Object
})

const open = ref(false);
</script>

<template>
    <div class="my-3 bg-white w-full flex flex-col">
        <div class="p-6 cursor-pointer" @click="open = !open">
            {{ open ? '-' : '+' }} {{ card.name }}
        </div>
        <div v-if="open" class="flex flex-col">
            <div class="p-6">
                <pre>{{ card }}</pre>
            </div>
            <a class="p-3 text-white text-center bg-blue-500 hover:bg-blue-400" :href="route('card.show', card)">
                Edit
            </a>
        </div>
    </div>
</template>
