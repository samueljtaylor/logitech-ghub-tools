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

const hasChanged = computed(() => card.value !== original && !status.value.saved);

const status = ref({
    saving: false,
    saved: false,
});

function jsonChange(updatedJson) {
    card.value = updatedJson;
    status.value.saved = false;
}

function save() {
    status.value.saving = true;
    axios.put(route('api.card.update', card.value), card.value).then(response => {
        status.value.saving = false;
        status.value.saved = true;
    });
}

function reset() {
    card.value = original;
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
                                <tw-button :disabled="!hasChanged || status.saving" @click="save" class="mx-3">
                                    {{ status.saving ? 'Saving...' : 'Save' + (status.saved ? 'd' : '') }}
                                </tw-button>

                                <tw-button :disabled="!hasChanged || status.saving" @click="reset" color="red" class="mx-3">
                                    Reset
                                </tw-button>
                            </div>
                        </template>
                    </panel>
                </div>
            </div>
        </div>
    </app-layout>
</template>
