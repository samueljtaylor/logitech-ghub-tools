<script setup>
import BtnBlue from "@/Components/Controls/Buttons/BtnBlue";

const props = defineProps({
    card: Object
})

</script>

<template>
    <div class="my-3">
        <div class="flex flex-row cursor-pointer" @click="open = !open">
            <div class="w-1/3">
                {{ card.name }}
            </div>
            <div class="w-1/3 text-center text-sm text-gray-400">
                {{ card?.macro?.actionName }}
            </div>
            <a class="ml-auto" :href="route('card.show', card)">
                <btn-blue>Details</btn-blue>
            </a>
        </div>
    </div>
</template>
