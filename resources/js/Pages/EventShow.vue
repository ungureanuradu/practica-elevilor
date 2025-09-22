<script setup>
import { Link, Head } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'

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
  <AppLayout :title="event.data.title">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ event.data.title }}
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

    <!-- EVENT DETAILS -->
    <main class="py-12">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white shadow-lg rounded-xl p-8">
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

              <!-- Event Type Badge -->
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
            <div v-if="event.data.description" class="prose prose-lg max-w-none content-styling">
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
          <footer class="mt-12 pt-6 border-t">
            <Link href="/" class="inline-flex items-center gap-2 bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition-colors">
              ← Înapoi la evenimente
            </Link>
          </footer>
        </div>
      </div>
    </main>
  </AppLayout>
</template>