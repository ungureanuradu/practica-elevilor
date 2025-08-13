<script setup>
import { Link } from '@inertiajs/vue3'

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
  <!-- NAV BAR -->
  <header class="bg-blue-700 text-white">
    <div class="container mx-auto flex items-center justify-between py-4">
      <h1 class="font-extrabold">PRACTICA ELEVILOR</h1>
      <nav class="flex gap-6">
        <Link href="/">Home</Link>
        <Link href="/members">Members</Link>
        <Link href="/courses">Courses</Link>
        <Link href="/forum">Forum</Link>
        <Link href="/jobs">Jobs</Link>
      </nav>
    </div>
  </header>

  <!-- HERO -->
  <section class="bg-blue-600 text-white py-8 px-3">
    <div class="container mx-auto text-center">
      <h2 class="text-3xl font-extrabold leading-tight">
        PRACTICA ELEVILOR<br>
        O CALE CARE SUCCESUL PROFESIONAL<br>
        <span class="block text-xl mt-4">COD SMIS 317832</span>
      </h2>
    </div>
  </section>

  <!-- NEWS ARTICLE -->
  <main class="py-12"> 
    <div class="container bg-white shadow-lg mx-4 rounded-xl p-8" style="margin: auto;">
      <!-- Back Button -->
   
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
        <div class="text-gray-800 leading-relaxed text-lg space-y-6 w-full">
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
  </main>
</template>

<style scoped>
/* Elimină toate restricțiile de lățime */
.w-full {
  width: 100% !important;
  max-width: none !important;
}

/* Styling pentru conținut */
div p {
  @apply mb-6 leading-relaxed text-lg;
}

div h2 {
  @apply text-2xl font-bold text-gray-900 mt-10 mb-6;
}

div h3 {
  @apply text-xl font-semibold text-gray-900 mt-8 mb-4;
}

div ul, div ol {
  @apply mb-6 ml-6 text-lg;
}

div li {
  @apply mb-3;
}

div blockquote {
  @apply border-l-4 border-blue-500 pl-6 italic text-gray-700 my-6;
}
</style>