<script setup>
import axios from 'axios';
import {ref, onMounted, computed} from "vue";
import BtnBlue from "@/Components/Controls/Buttons/BtnBlue";
import BtnRed from "@/Components/Controls/Buttons/BtnRed";

const status = ref({});
const loading = ref(false);
const reloading = ref(false);
const saving = ref(false);
const disabled = computed(() => loading.value || reloading.value || saving.value || !status.value?.hasChanged);

function reload() {
    reloading.value = true;
    axios.post(route('api.repository.reload')).then(res => {
        load();
        reloading.value = false;
    });
}

function save() {
    saving.value = true;
    axios.post(route('api.repository.save')).then(res => {
        reload();
        saving.value = false;
    });
}

function load() {
    loading.value = true;
    axios.get(route('api.repository.status')).then(res => {
        status.value = res.data;
        loading.value = false;
    });
}

onMounted(() => load());
</script>

<template>
    <div class="flex flex-col w-full p-6 bg-white shadow-md">
        <div class="my-3">
            Last Updated: {{ loading ? 'Loading...' : status?.lastUpdated?.diffForHumans }}
        </div>
        <div class="my-3">
            Has Changed: {{ loading ? 'Loading...' : status?.hasChanged }}
        </div>
        <div class="my-3">
            <btn-red @click="reload" :disabled="disabled">
                {{ reloading ? 'Reloading...' : 'Reload from Database' }}
            </btn-red>

            <btn-blue class="ml-3" :disabled="disabled" @click="save">
                {{ saving ? 'Saving...' : 'Save to Database' }}
            </btn-blue>
        </div>
    </div>
</template>
