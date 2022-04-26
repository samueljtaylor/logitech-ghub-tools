<script setup>
import {ref, onMounted, watch} from "vue";
import Panel from "@/Components/Panel";

const props = defineProps({
    open: {type: Boolean, default: false},
    color: {type: String, default: 'white'},
    padding: {type: String, default: '6'},
    title: {type: String, required: true},
});

const isOpen = ref(false);

function toggle() {
    isOpen.value = !isOpen.value;
}

watch(props, (newProps) => {
    isOpen.value = (!!newProps.open);
});

onMounted(() => {
    if(props.open) {
        isOpen.value = true;
    }
})
</script>

<template>
    <panel :color="color" :padding="padding">
        <template #header>
            <div class="flex flex-row">
                <div class="cursor-pointer my-auto text-xl w-4/5 mr-auto" @click="toggle">
                    {{ isOpen ? '-' : '+' }} {{ title }}
                </div>
                <div class="" v-if="$slots.options">
                    <slot name="options"/>
                </div>
            </div>
        </template>
        <div v-show="isOpen">
            <slot/>
        </div>

        <template #footer>
            <slot name="footer"/>
        </template>
    </panel>
</template>
