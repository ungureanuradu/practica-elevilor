<script setup>
import { Head } from '@inertiajs/vue3'
import Banner from '@/Components/Banner.vue'
import Footer from '@/Components/Footer.vue'

defineProps({
  title: String,
})
</script>

<template>
  <div>
    <Head :title="title" />
    <Banner />

    <!-- IMPORTANT: flex + col ca să stea footerul jos -->
    <div class="min-h-screen bg-gray-100 flex flex-col">
      <!-- Header-ul paginii -->
      <header v-if="$slots.header" class="bg-white shadow">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
          <slot name="header" />
        </div>
      </header>

      <!-- Conținut -->
      <main class="flex-1">
        <slot />
      </main>

      <!-- Footer -->
      <Footer :data="window.footerData" />
    </div>
  </div>
</template>
