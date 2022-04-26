<script setup>
import Panel from "@/Components/Panel";
import {ref} from "vue";
import axios from "axios";
import BtnGreen from "@/Components/Controls/Buttons/BtnGreen";

const query = ref('');
const searching = ref(false);
const results = ref({});

function search() {
    searching.value = true;
    axios.post(route('api.key.search'), {
        query: query.value
    }).then(response => {
        results.value = response.data;
        searching.value = false;
    });
}
</script>

<template>
    <panel>
        <div class="flex flex-row pt-6">
            <input type="text" class="p-3 bg-white disabled:bg-gray-200 disabled:cursor-not-allowed flex-1" v-model="query" :disabled="searching">
            <btn-green :disabled="searching" @click="search">
                Search
            </btn-green>
        </div>

        <div>
            <pre>{{ results }}</pre>
        </div>
    </panel>
</template>
