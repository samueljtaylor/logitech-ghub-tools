<script setup>
import axios from 'axios';
import {ref, onMounted} from "vue";

const lastUpdated = ref({
    loading: false,
    value: null
});

const hasChanged = ref({
    loading: false,
    value: null
});

const reloading = ref(false);

function reload() {
    reloading.value = true;
    setLoadingValues();

    axios.get(route('api.repository.reload')).then(res => {
        load();
        reloading.value = false;
    });
}

function setLoadingValues() {
    lastUpdated.value = {
        loading: true,
        value: null,
    };

    hasChanged.value = {
        loading: true,
        value: null,
    };
}

function load() {
    setLoadingValues();
    axios.get(route('api.repository.lastUpdated') + '?format=diffForHumans').then(res => {
        lastUpdated.value = {
            loading: false,
            value: res.data
        };
    });

    axios.get(route('api.repository.hasChanged')).then(res => {
        hasChanged.value = {
            loading: false,
            value: res.data
        };
    });
}

onMounted(() => load());
</script>

<template>
    <div class="flex flex-col w-full p-6 bg-white shadow-md">
        <div class="my-3">
            Last Updated: {{ lastUpdated.loading ? 'Loading...' : lastUpdated.value }}
        </div>
        <div class="my-3">
            Has Changed: {{ hasChanged.loading ? 'Loading...' : hasChanged.value }}
        </div>
        <div class="my-3">
            <button class="p-3 text-white bg-red-500 hover:bg-red-300 disabled:bg-red-200 disabled:cursor-not-allowed" @click="reload" :disabled="reloading">
                {{ reloading ? 'Reloading...' : 'Reload from Database' }}
            </button>
        </div>
    </div>
</template>
