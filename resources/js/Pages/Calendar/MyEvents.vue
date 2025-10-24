<template>
  <AppLayout title="Evenimentele Mele">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Evenimentele Mele
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Header Actions -->
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6 mb-6">
          <div class="flex items-center justify-between">
            <div>
              <h3 class="text-lg font-medium text-gray-900">Evenimentele Organizate de Tine</h3>
              <p class="text-sm text-gray-600 mt-1">
                Gestionează și urmărește evenimentele pe care le-ai creat
              </p>
            </div>
            <Link
              :href="route('calendar-events.create')"
              class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
            >
              <i class="fas fa-plus mr-2"></i>
              Creează Eveniment Nou
            </Link>
          </div>
        </div>

        <!-- Events List -->
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
          <div v-if="events.data && events.data.length" class="divide-y divide-gray-200">
            <div
              v-for="event in events.data"
              :key="event.id"
              class="p-6 hover:bg-gray-50"
            >
              <div class="flex items-start justify-between">
                <div class="flex items-start space-x-4">
                  <div class="flex-shrink-0">
                    <div 
                      class="w-4 h-4 rounded-full mt-1"
                      :style="{ backgroundColor: event.category?.color || '#3B82F6' }"
                    ></div>
                  </div>
                  <div class="flex-1">
                    <div class="flex items-center space-x-3">
                      <h3 class="text-lg font-medium text-gray-900">
                        {{ event.title }}
                      </h3>
                      <span
                        :class="getStatusClass(event.status)"
                        class="px-2 py-1 rounded-full text-xs font-medium"
                      >
                        {{ getStatusLabel(event.status) }}
                      </span>
                    </div>
                    <p v-if="event.excerpt" class="text-sm text-gray-600 mt-1">
                      {{ event.excerpt }}
                    </p>
                    <div class="flex items-center space-x-4 mt-2 text-sm text-gray-500">
                      <div class="flex items-center">
                        <i class="fas fa-calendar-alt mr-1"></i>
                        {{ formatEventDate(event.start_date, event.end_date) }}
                      </div>
                      <div v-if="event.location" class="flex items-center">
                        <i class="fas fa-map-marker-alt mr-1"></i>
                        {{ event.location }}
                      </div>
                      <div class="flex items-center">
                        <i class="fas fa-users mr-1"></i>
                        {{ event.registered_participants || 0 }} participanți
                      </div>
                    </div>
                    <div class="mt-2">
                      <span
                        :class="getEventTypeClass(event.type)"
                        class="px-2 py-1 rounded-full text-xs font-medium mr-2"
                      >
                        {{ getEventTypeLabel(event.type) }}
                      </span>
                      <span v-if="event.is_featured" class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs font-medium">
                        Featured
                      </span>
                    </div>
                  </div>
                </div>
                <div class="flex items-center space-x-2">
                  <Link
                    :href="route('calendar-events.show', event.id)"
                    class="px-3 py-1 bg-blue-600 text-white rounded-md hover:bg-blue-700 text-sm"
                  >
                    Vezi
                  </Link>
                  <Link
                    :href="route('calendar-events.edit', event.id)"
                    class="px-3 py-1 bg-green-600 text-white rounded-md hover:bg-green-700 text-sm"
                  >
                    Editează
                  </Link>
                  <button
                    @click="deleteEvent(event.id)"
                    class="px-3 py-1 bg-red-600 text-white rounded-md hover:bg-red-700 text-sm"
                  >
                    Șterge
                  </button>
                </div>
              </div>
            </div>
          </div>
          <div v-else class="text-center py-12">
            <i class="fas fa-calendar-plus text-4xl text-gray-400 mb-4"></i>
            <h3 class="text-lg font-medium text-gray-900 mb-2">Nu ai creat niciun eveniment</h3>
            <p class="text-gray-600 mb-4">Începe să creezi evenimente pentru a le vedea aici.</p>
            <Link
              :href="route('calendar-events.create')"
              class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
            >
              <i class="fas fa-plus mr-2"></i>
              Creează Primul Eveniment
            </Link>
          </div>
        </div>

        <!-- Pagination -->
        <div v-if="events.data && events.data.length" class="mt-6">
          <nav class="flex items-center justify-between">
            <div class="text-sm text-gray-700">
              Afișând {{ events.from }} - {{ events.to }} din {{ events.total }} evenimente
            </div>
            <div class="flex space-x-2">
              <Link
                v-if="events.prev_page_url"
                :href="events.prev_page_url"
                class="px-3 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50"
              >
                Anterior
              </Link>
              <Link
                v-if="events.next_page_url"
                :href="events.next_page_url"
                class="px-3 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50"
              >
                Următorul
              </Link>
            </div>
          </nav>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import { Link, router } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'

const props = defineProps({
  events: Object,
})

const formatEventDate = (startDate, endDate) => {
  const start = new Date(startDate)
  const end = new Date(endDate)
  
  if (start.toDateString() === end.toDateString()) {
    return start.toLocaleDateString('ro-RO', {
      day: 'numeric',
      month: 'long',
      year: 'numeric',
      hour: '2-digit',
      minute: '2-digit'
    })
  } else {
    return `${start.toLocaleDateString('ro-RO', { day: 'numeric', month: 'short' })} - ${end.toLocaleDateString('ro-RO', { day: 'numeric', month: 'short', year: 'numeric' })}`
  }
}

const getStatusClass = (status) => {
  const classes = {
    draft: 'bg-gray-100 text-gray-800',
    published: 'bg-green-100 text-green-800',
    archived: 'bg-red-100 text-red-800',
  }
  return classes[status] || 'bg-gray-100 text-gray-800'
}

const getStatusLabel = (status) => {
  const labels = {
    draft: 'Ciornă',
    published: 'Publicat',
    archived: 'Arhivat',
  }
  return labels[status] || status
}

const getEventTypeClass = (type) => {
  const classes = {
    single: 'bg-blue-100 text-blue-800',
    recurring: 'bg-green-100 text-green-800',
    'all-day': 'bg-purple-100 text-purple-800',
  }
  return classes[type] || 'bg-gray-100 text-gray-800'
}

const getEventTypeLabel = (type) => {
  const labels = {
    single: 'Eveniment Unic',
    recurring: 'Recurent',
    'all-day': 'Toată Ziua',
  }
  return labels[type] || type
}

const deleteEvent = (eventId) => {
  if (confirm('Ești sigur că vrei să ștergi acest eveniment?')) {
    router.delete(route('calendar-events.destroy', eventId), {
      preserveState: true,
      preserveScroll: true,
    })
  }
}
</script>
