<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import RepositoryDetails from "@/Widgets/RepositoryDetails";
import KeySearch from "@/Widgets/KeySearch";
</script>

<template>
    <AppLayout title="Dashboard">
        <repository-details/>

        <key-search class="mt-10"/>
    </AppLayout>
</template>
