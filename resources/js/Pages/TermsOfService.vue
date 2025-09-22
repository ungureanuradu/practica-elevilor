<script setup>
import { Head } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';

defineProps({
    terms: String,
});
</script>

<template>
    <AppLayout title="Terms of Service">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Termeni și Condiții
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                    <div class="content-styling" v-html="terms" />
                </div>
            </div>
        </div>
    </AppLayout>
</template>
