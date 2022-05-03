<script setup>
import BtnBlue from "@/Components/Controls/Buttons/BtnBlue";
import BtnRed from "@/Components/Controls/Buttons/BtnRed";
import {ref} from "vue";

const props = defineProps({
    card: Object
})

const deleting = ref(false);
</script>

<template>
    <div class="my-3">
        <div class="flex flex-row cursor-pointer" @click="open = !open">
            <div class="w-1/3">
                {{ card.name }}
            </div>
            <div class="w-1/3 text-center text-sm text-gray-400">
                {{ card?.macro?.actionName }}
            </div>
            <a class="ml-auto" :href="route('card.show', card)">
                <btn-blue>Details</btn-blue>
            </a>
            <btn-red class="ml-2" @click="deleting = true; $refs.deleteForm.submit()" :disabled="deleting">
                {{ deleting ? 'Deleting...' : 'Delete' }}
            </btn-red>
        </div>
        <form method="post" :action="route('card.destroy', card)" ref="deleteForm">
            <input type="hidden" name="_method" value="delete"/>
            <input type="hidden" name="_token" :value="$page.props.csrf"/>
        </form>
    </div>
</template>
