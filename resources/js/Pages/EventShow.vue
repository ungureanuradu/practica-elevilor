<script setup>
import { Link } from '@inertiajs/vue3'

defineProps({ 
  event: Object
})

// Funcție pentru formatarea datei
const formatDate = (date) => {
  if (!date) return 'Data necunoscută'
  
  if (typeof date === 'string' && date.includes('.')) {
    return date
  }
  
  return new Date(date).toLocaleDateString('ro-RO', {
    year: 'numeric',
    month: 'long', 
    day: 'numeric'
  })
}

const formatDateTime = (date) => {
  if (!date) return 'Data necunoscută'
  
  return new Date(date).toLocaleString('ro-RO', {
    year: 'numeric',
    month: 'long',
    day: 'numeric',
    hour: '2-digit',
    minute: '2-digit'
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

  <!-- EVENT DETAILS -->
  <main class="py-12">
    <div class="container bg-white shadow-lg mx-4 rounded-xl p-8" style="margin: auto;">
      <!-- Back Button -->
      <Link href="/" class="inline-flex items-center gap-2 text-blue-600 hover:text-blue-800 mb-6 transition-colors">
        ← Înapoi la pagina principală
      </Link>

      <!-- Event Header -->
      <header class="mb-8 border-b pb-6">
        <div class="flex items-start justify-between flex-wrap gap-4">
          <div class="flex-1">
            <h1 class="text-3xl font-bold text-gray-900 mb-4 leading-tight">
              {{ event.data.title }}
            </h1>
            
            <div class="flex flex-wrap items-center gap-6 text-sm text-gray-600">
              <span class="flex items-center gap-2">
                📅 {{ event.data.start }}
              </span>
              <span v-if="event.data.end" class="flex items-center gap-2">
                🕐 până la {{ event.data.end }}
              </span>
              <span v-if="event.data.location" class="flex items-center gap-2">
                📍 {{ event.data.location }}
              </span>
              <span v-if="event.data.organizer" class="flex items-center gap-2">
                👤 {{ event.data.organizer }}
              </span>
            </div>
          </div>

          <!-- Event Type Badge (if you add it later) -->
          <div class="shrink-0">
            <span class="inline-block bg-blue-100 text-blue-800 text-sm font-medium px-3 py-1 rounded-full">
              Eveniment
            </span>
          </div>
        </div>
      </header>

      <!-- Event Content -->
      <div class="w-full">
        <!-- Event Description -->
        <div v-if="event.data.description" class="prose prose-lg max-w-none">
          <div class="text-gray-800 leading-relaxed text-lg space-y-6">
            <div v-html="event.data.description"></div>
          </div>
        </div>
        
        <!-- Fallback if no description -->
        <div v-else class="text-gray-600 italic">
          Detalii despre eveniment vor fi adăugate în curând.
        </div>

        <!-- Event Info Card -->
        <div class="mt-8 bg-blue-50 rounded-lg p-6 border-l-4 border-blue-500">
          <h3 class="text-lg font-semibold text-gray-900 mb-4">Informații eveniment</h3>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
            <div>
              <span class="font-medium text-gray-700">Data început:</span>
              <span class="text-gray-600">{{ event.data.start }}</span>
            </div>
            <div v-if="event.data.end">
              <span class="font-medium text-gray-700">Data sfârșit:</span>
              <span class="text-gray-600">{{ event.data.end }}</span>
            </div>
            <div v-if="event.data.location">
              <span class="font-medium text-gray-700">Locația:</span>
              <span class="text-gray-600">{{ event.data.location }}</span>
            </div>
            <div v-if="event.data.organizer">
              <span class="font-medium text-gray-700">Organizator:</span>
              <span class="text-gray-600">{{ event.data.organizer }}</span>
            </div>
          </div>
        </div>
      </div>

      <!-- Back Button -->
      
    </div>
  </main>
</template>

<style scoped>
.w-full {
  width: 100% !important;
  max-width: none !important;
}

div p {
  @apply mb-6 leading-relaxed text-lg;
}

div h2 {
  @apply text-2xl font-bold text-gray-900 mt-10 mb-6;
}

div h3 {
  @apply text-xl font-semibold text-gray-900 mt-8 mb-4;
}
</style>