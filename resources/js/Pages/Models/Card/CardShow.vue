<script setup>
import AppLayout from "@/Layouts/AppLayout";
import Panel from "@/Components/Panel";
import {computed, reactive, ref, toRef} from 'vue';
import {usePage} from '@inertiajs/inertia-vue3'
import {Vue3JsonEditor} from 'vue3-json-editor'
import TwButton from "@/Components/Controls/TwButton";
import axios from 'axios';

const editorOptions = {
    expandedOnStart: true,
    mode: 'tree',
    lang: 'en'
};

const card = toRef(usePage().props.value, 'card');

const original = usePage().props.value.card;

const hasChanged = computed(() => card.value !== original);

const saving = ref(false);

function jsonChange(updatedJson) {
    card.value = updatedJson;
}

function save() {
    saving.value = true;

}

</script>

<template>
    <app-layout title="Card Details">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Card Details
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="flex flex-col">
                    <panel class="flex flex-col" padding="0">
                        <vue3-json-editor v-model="card" v-bind="editorOptions" @json-change="jsonChange"></vue3-json-editor>
                        <template #footer>
                            <div class="justify-items-center p-6">
                                <tw-button :disabled="!hasChanged">
                                    Update
                                </tw-button>
                            </div>
                        </template>
                    </panel>
                </div>
            </div>
        </div>
    </app-layout>
</template>
