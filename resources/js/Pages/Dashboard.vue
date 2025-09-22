<script setup>
import { Head } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'
import Banner from '@/Components/Banner.vue'
import Footer from '@/Components/Footer.vue'

defineProps({
  title: String,
})
</script>

<template>
  <AppLayout :title="title">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Dashboard
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
          <div class="text-center">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Bun venit!</h3>
            <p class="text-gray-600">
              Aceasta este pagina principală a aplicației. Navighează prin meniul de sus pentru a accesa diferite secțiuni.
            </p>
          </div>
        </div>
      </div>
    </div>
  </AppLayout>
</template>
