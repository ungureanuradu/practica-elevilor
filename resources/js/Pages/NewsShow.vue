<script setup>
import { Link, Head } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'

defineProps({ 
  news: Object
})

// Funcție pentru formatarea datei
const formatDate = (date) => {
  if (!date) return 'Data necunoscută'
  
  // Dacă data e deja formatată (ex: "19.06.2025")
  if (typeof date === 'string' && date.includes('.')) {
    return date
  }
  
  // Altfel formatează din timestamp
  return new Date(date).toLocaleDateString('ro-RO', {
    year: 'numeric',
    month: 'long', 
    day: 'numeric'
  })
}
</script>

<template>
  <AppLayout :title="news.data.title">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ news.data.title }}
      </h2>
    </template>

    <!-- HERO -->
    <section class="bg-blue-600 text-white py-8 px-3 mb-8">
      <div class="max-w-7xl mx-auto text-center">
        <h2 class="text-3xl font-extrabold leading-tight">
          PRACTICA ELEVILOR<br>
          O CALE CARE SUCCESUL PROFESIONAL<br>
          <span class="block text-xl mt-4">COD SMIS 317832</span>
        </h2>
      </div>
    </section>

    <!-- NEWS ARTICLE -->
    <main class="py-12"> 
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white shadow-lg rounded-xl p-8">
          <!-- Article Header -->
          <header class="mb-8 border-b pb-6">
            <h1 class="text-3xl font-bold text-gray-900 mb-4 leading-tight">
              {{ news.data.title }}
            </h1>
            
            <div class="flex items-center gap-6 text-sm text-gray-600">
              <span v-if="news.data.published_at">📅 {{ formatDate(news.data.published_at) }}</span>
              <span v-else-if="news.data.created_at">📅 {{ formatDate(news.data.created_at) }}</span>
              <span v-else>📅 {{ new Date().toLocaleDateString('ro-RO') }}</span>
              
              <span v-if="news.data.author">👤 {{ news.data.author }}</span>
              <span v-else-if="news.data.user">👤 {{ news.data.user.name || 'Administrator' }}</span>
              <span v-else>👤 Administrator</span>
            </div>
          </header>

          <!-- Article Content -->
          <div class="w-full">
            <!-- Excerpt -->
            <div v-if="news.data.excerpt && news.data.excerpt !== news.data.body" class="text-xl text-gray-700 mb-8 font-medium leading-relaxed bg-blue-50 p-6 rounded-lg border-l-4 border-blue-500">
              {{ news.data.excerpt }}
            </div>

            <!-- Main content -->
            <div class="text-gray-800 leading-relaxed text-lg space-y-6 w-full content-styling">
              <div v-if="news.data.body" v-html="news.data.body"></div>
              <div v-else-if="news.data.content" v-html="news.data.content"></div>
              <div v-else class="whitespace-pre-line">{{ news.data.excerpt }}</div>
            </div>
          </div>

          <!-- Back Button -->
          <footer class="mt-12 pt-6 border-t">
            <Link href="/" class="inline-flex items-center gap-2 bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition-colors">
              ← Înapoi la știri
            </Link>
          </footer>
        </div>
      </div>
    </main>
  </AppLayout>
</template>