<script setup>
import { Head } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';

defineProps({
    policy: String,
});
</script>

<template>
    <AppLayout title="Privacy Policy">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Politica de Confidențialitate
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                    <div class="prose max-w-none content-styling" v-html="policy" />
                </div>
            </div>
        </div>
    </AppLayout>
</template>
