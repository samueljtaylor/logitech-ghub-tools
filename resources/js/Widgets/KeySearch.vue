<script setup>
import Panel from "@/Components/Panel";
import {ref} from "vue";
import axios from "axios";
import BtnBlue from "@/Components/Controls/Buttons/BtnBlue";
import {isEmpty} from 'lodash';
import Checkbox from "@/Jetstream/Checkbox";

const query = ref('');
const searching = ref(false);
const results = ref([]);
const strict = ref(false);

function search() {
    let routeName = 'api.key.' + (strict.value ? 'find' : 'search');

    searching.value = true;

    axios.post(route(routeName), {
        query: query.value
    }).then(response => {
        results.value = response.data;
        searching.value = false;
    }).catch(() => {
        results.value = [];
        searching.value = false;
    });
}
</script>

<template>
    <panel>
        <div class="flex flex-row pt-6">
            <input type="text" class="p-3 bg-white disabled:bg-gray-200 disabled:cursor-not-allowed flex-1" v-model="query" :disabled="searching">
            <btn-blue :disabled="searching || query.length === 0" @click="search">
                {{ searching ? 'Searching...' : 'Search' }}
            </btn-blue>
        </div>

        <div class="my-2">
            <checkbox v-model="strict" id="strict-checkbox"/>
            <label for="strict-checkbox" class="pl-2 my-auto">Strict Search</label>
        </div>

        <div class="my-6">
            <pre>{{ isEmpty(results) ? 'No results.' : results }}</pre>
        </div>
    </panel>
</template>
