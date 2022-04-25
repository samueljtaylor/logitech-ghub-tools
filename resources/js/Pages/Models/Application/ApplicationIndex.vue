<script setup>
import AppLayout from "@/Layouts/AppLayout";

const props = defineProps({
    applications: Object|Array
});
</script>

<template>
    <app-layout title="Applications">
        <pre>{{ applications }}</pre>
    </app-layout>
</template>
