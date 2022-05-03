<script setup>
import AppLayout from "@/Layouts/AppLayout";
import Panel from "@/Components/Panel";
import {computed, ref, toRef} from 'vue';
import {usePage} from '@inertiajs/inertia-vue3'
import {Vue3JsonEditor} from 'vue3-json-editor'
import BtnBlue from "@/Components/Controls/Buttons/BtnBlue";
import BtnRed from "@/Components/Controls/Buttons/BtnRed";

const editorOptions = {
    expandedOnStart: true,
    mode: 'tree',
    lang: 'en'
};

const card = toRef(usePage().props.value, 'card');

const original = usePage().props.value.card;

const json = computed(() => JSON.stringify(card.value));

const status = ref({
    changed: false,
});

function jsonChange(updatedJson) {
    card.value = updatedJson;
    resetStatus();
    status.value.changed = true;
}

function resetStatus() {
    status.value = {
        changed: false,
    };
}

function reset() {
    card.value = original;
    resetStatus();
}
</script>

<template>
    <app-layout title="New Card">
        <panel padding="0">
            <vue3-json-editor v-model="card" v-bind="editorOptions" @json-change="jsonChange"/>
            <template #footer>
                <div class="flex flex-row">
                    <btn-blue class="w-1/2 text-center py-4" :disabled="!status.changed" @click="$refs.form.submit()">
                        Save
                    </btn-blue>
                    <btn-red class="w-1/2 text-center py-4" :disabled="!status.changed" @click="reset">
                        Reset
                    </btn-red>
                </div>
            </template>
        </panel>
    </app-layout>

    <form method="post" :action="route('card.store')" ref="form">
        <input type="hidden" name="card" v-model="json"/>
        <input type="hidden" name="_method" value="post"/>
        <input type="hidden" name="_token" :value="$page.props.csrf"/>
    </form>
</template>
