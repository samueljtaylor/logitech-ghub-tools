<script setup>
import AppLayout from "@/Layouts/AppLayout";
import Panel from "@/Components/Panel";
import {computed, reactive, ref, toRef} from 'vue';
import {usePage} from '@inertiajs/inertia-vue3'
import {Vue3JsonEditor} from 'vue3-json-editor'
import axios from 'axios';
import BtnBlue from "@/Components/Controls/Buttons/BtnBlue";
import BtnRed from "@/Components/Controls/Buttons/BtnRed";

const editorOptions = {
    expandedOnStart: true,
    mode: 'tree',
    lang: 'en'
};

const card = toRef(usePage().props.value, 'card');

const original = usePage().props.value.card;

const status = ref({
    saving: false,
    saved: false,
    changed: false,
});

function jsonChange(updatedJson) {
    card.value = updatedJson;
    resetStatus();
    status.value.changed = true;
}

function save() {
    status.value.saving = true;
    axios.put(route('api.card.update', card.value), card.value).then(response => {
        resetStatus();
        status.value.saved = true;
    });
}

function resetStatus() {
    status.value = {
        saving: false,
        saved: false,
        changed: false,
    };
}

function reset() {
    card.value = original;
    resetStatus();
}
</script>

<template>
    <app-layout title="Card Details">
        <panel padding="0">
            <vue3-json-editor v-model="card" v-bind="editorOptions" @json-change="jsonChange"/>
            <template #footer>
                <div class="flex flex-row">
                    <btn-blue class="w-1/2 text-center py-4" :disabled="!status.changed || status.saving" @click="save">
                        {{ status.saving ? 'Saving...' : (status.saved ? 'Saved' : 'Save') }}
                    </btn-blue>
                    <btn-red class="w-1/2 text-center py-4" :disabled="!status.changed || status.saving" @click="reset">
                        Reset
                    </btn-red>
                </div>
            </template>
        </panel>
    </app-layout>
</template>
