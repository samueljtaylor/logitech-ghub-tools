<script setup>
import AppLayout from "@/Layouts/AppLayout";
import CardList from "@/Pages/Models/Card/Partials/CardList";
import Panel from "@/Components/Panel";
import BtnGreen from "@/Components/Controls/Buttons/BtnGreen";
import {ref} from 'vue';
import BtnBlue from "@/Components/Controls/Buttons/BtnBlue";
import CollapsePanel from "@/Components/CollapsePanel";

const props = defineProps({
    grouped: Object,
});

const showEmpty = ref(false);
const openAll = ref(false);

</script>

<template>
    <app-layout title="Cards">
        <template #header="header">
            <div class="flex flex-row">
                <h2 :class="header.classes">
                    Cards
                </h2>
                <div class="ml-auto space-x-3">
                    <btn-blue @click="showEmpty = !showEmpty">
                        {{ showEmpty ? 'Hide' : 'Show' }} Empty
                    </btn-blue>

                    <btn-blue @click="openAll = !openAll">
                        {{ openAll ? 'Collapse' : 'Expand' }} All
                    </btn-blue>
                </div>
            </div>
        </template>

        <collapse-panel v-for="(cards, grouping) in grouped" class="my-4" v-show="grouping.length || showEmpty" :title="grouping.length ? grouping : '(empty)'" :open="openAll">
            <template #options>
                <btn-green>Add New</btn-green>
            </template>
            <card-list :cards="cards"/>
        </collapse-panel>
    </app-layout>
</template>
