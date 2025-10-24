<template>
  <AppLayout title="Calendar">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Calendar Evenimente
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Calendar Controls -->
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6 mb-6">
          <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
              <h3 class="text-lg font-medium text-gray-900">
                {{ formatDateTitle(date, view) }}
              </h3>
              <div class="flex space-x-2">
                <button
                  @click="changeDate('prev')"
                  class="px-3 py-1 bg-gray-100 text-gray-700 rounded-md hover:bg-gray-200"
                >
                  <i class="fas fa-chevron-left"></i>
                </button>
                <button
                  @click="goToToday"
                  class="px-3 py-1 bg-blue-600 text-white rounded-md hover:bg-blue-700"
                >
                  Astăzi
                </button>
                <button
                  @click="changeDate('next')"
                  class="px-3 py-1 bg-gray-100 text-gray-700 rounded-md hover:bg-gray-200"
                >
                  <i class="fas fa-chevron-right"></i>
                </button>
              </div>
            </div>
            <div class="flex space-x-2">
              <button
                @click="changeView('month')"
                :class="view === 'month' ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700'"
                class="px-4 py-2 rounded-md hover:bg-blue-700"
              >
                Lună
              </button>
              <button
                @click="changeView('week')"
                :class="view === 'week' ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700'"
                class="px-4 py-2 rounded-md hover:bg-blue-700"
              >
                Săptămână
              </button>
              <button
                @click="changeView('day')"
                :class="view === 'day' ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700'"
                class="px-4 py-2 rounded-md hover:bg-blue-700"
              >
                Zi
              </button>
            </div>
          </div>
        </div>

        <!-- Events List -->
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
          <div v-if="events && events.length" class="divide-y divide-gray-200">
            <div
              v-for="event in events"
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
                    <h3 class="text-lg font-medium text-gray-900">
                      {{ event.title }}
                    </h3>
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
                      <div v-if="event.organizer" class="flex items-center">
                        <i class="fas fa-user mr-1"></i>
                        {{ event.organizer.name }}
                      </div>
                    </div>
                  </div>
                </div>
                <div class="flex items-center space-x-2">
                  <span
                    :class="getEventTypeClass(event.type)"
                    class="px-2 py-1 rounded-full text-xs font-medium"
                  >
                    {{ getEventTypeLabel(event.type) }}
                  </span>
                  <Link
                    :href="route('calendar-events.show', event.id)"
                    class="px-3 py-1 bg-blue-600 text-white rounded-md hover:bg-blue-700 text-sm"
                  >
                    Vezi Detalii
                  </Link>
                </div>
              </div>
            </div>
          </div>
          <div v-else class="text-center py-12">
            <i class="fas fa-calendar text-4xl text-gray-400 mb-4"></i>
            <h3 class="text-lg font-medium text-gray-900 mb-2">Nu există evenimente</h3>
            <p class="text-gray-600 mb-4">Nu există evenimente pentru perioada selectată.</p>
            <Link
              :href="route('calendar-events.create')"
              class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
            >
              <i class="fas fa-plus mr-2"></i>
              Creează Eveniment
            </Link>
          </div>
        </div>

        <!-- Categories Legend -->
        <div v-if="categories && categories.length" class="mt-6">
          <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Categorii</h3>
            <div class="flex flex-wrap gap-4">
              <div
                v-for="category in categories"
                :key="category.id"
                class="flex items-center space-x-2"
              >
                <div
                  class="w-4 h-4 rounded-full"
                  :style="{ backgroundColor: category.color || '#3B82F6' }"
                ></div>
                <span class="text-sm text-gray-700">{{ category.name }}</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import { ref } from 'vue'
import { Link, router } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'

const props = defineProps({
  view: String,
  date: String,
  events: Array,
  categories: Array,
})

const currentDate = ref(new Date(props.date))

const formatDateTitle = (date, view) => {
  const d = new Date(date)
  const options = {
    year: 'numeric',
    month: 'long',
  }
  
  if (view === 'day') {
    return d.toLocaleDateString('ro-RO', { ...options, day: 'numeric' })
  } else if (view === 'week') {
    const startOfWeek = new Date(d)
    startOfWeek.setDate(d.getDate() - d.getDay() + 1)
    const endOfWeek = new Date(startOfWeek)
    endOfWeek.setDate(startOfWeek.getDate() + 6)
    
    return `${startOfWeek.toLocaleDateString('ro-RO', { day: 'numeric', month: 'short' })} - ${endOfWeek.toLocaleDateString('ro-RO', { day: 'numeric', month: 'short', year: 'numeric' })}`
  } else {
    return d.toLocaleDateString('ro-RO', options)
  }
}

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

const changeView = (newView) => {
  router.get(route('calendar.view'), {
    view: newView,
    date: props.date
  })
}

const changeDate = (direction) => {
  const current = new Date(props.date)
  
  if (props.view === 'month') {
    current.setMonth(current.getMonth() + (direction === 'next' ? 1 : -1))
  } else if (props.view === 'week') {
    current.setDate(current.getDate() + (direction === 'next' ? 7 : -7))
  } else if (props.view === 'day') {
    current.setDate(current.getDate() + (direction === 'next' ? 1 : -1))
  }
  
  router.get(route('calendar.view'), {
    view: props.view,
    date: current.toISOString().split('T')[0]
  })
}

const goToToday = () => {
  router.get(route('calendar.view'), {
    view: props.view,
    date: new Date().toISOString().split('T')[0]
  })
}
</script>
