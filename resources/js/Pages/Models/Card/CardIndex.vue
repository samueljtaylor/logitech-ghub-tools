<script setup>
import AppLayout from "@/Layouts/AppLayout";
import CardList from "@/Pages/Models/Card/Partials/CardList";
import Panel from "@/Components/Panel";
import BtnGreen from "@/Components/Controls/Buttons/BtnGreen";
import {ref} from 'vue';
import BtnBlue from "@/Components/Controls/Buttons/BtnBlue";

const props = defineProps({
    grouped: Object,
});

const showEmpty = ref(false);
</script>

<template>
    <app-layout title="Cards">
        <template #header="header">
            <div class="flex flex-row">
                <h2 :class="header.classes">
                    Cards
                </h2>
                <div class="ml-auto">
                    <btn-blue @click="showEmpty = !showEmpty">
                        {{ showEmpty ? 'Hide' : 'Show' }} Empty
                    </btn-blue>
                </div>
            </div>
        </template>

        <panel v-for="(cards, grouping) in grouped" class="my-4" v-show="grouping.length || showEmpty">
            <template #header>
                <div class="flex flex-row">
                    <div class="text-xl my-auto">{{ grouping.length ? grouping : '(empty)' }}</div>
                    <div class="ml-auto">
                        <btn-green>Add New</btn-green>
                    </div>
                </div>
            </template>

            <card-list :cards="cards"/>
        </panel>
    </app-layout>
</template>
