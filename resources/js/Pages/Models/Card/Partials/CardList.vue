<script setup>
import CardItem from "@/Pages/Models/Card/Partials/CardItem";

const props = defineProps({
    cards: Array,
});
</script>

<template>
    <div class="flex flex-col">
        <card-item v-for="card in cards" :card="card"/>
    </div>
</template>
