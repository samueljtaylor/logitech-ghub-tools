<script setup>
import AppLayout from "@/Layouts/AppLayout";
import CardItem from "@/Pages/Models/Card/Partials/CardItem";

const props = defineProps({
    cards: Array,
});
</script>

<template>
    <app-layout title="Cards">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Cards
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="flex flex-col">
                    <card-item v-for="card in cards" :card="card"/>
                </div>
            </div>
        </div>
    </app-layout>
</template>
