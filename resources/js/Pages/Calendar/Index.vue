<template>
  <AppLayout title="Calendar">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Calendar Evenimente
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Header Section -->
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6 mb-6">
          <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
              <h3 class="text-lg font-medium text-gray-900">Evenimente și Activitate</h3>
              <p class="text-sm text-gray-600 mt-1">
                Descoperă evenimente educaționale, workshop-uri și activități
              </p>
            </div>
            <div class="flex gap-3">
              <Link
                v-if="$page.props.auth.user"
                :href="route('calendar-events.create')"
                class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
              >
                <i class="fas fa-plus mr-2"></i>
                Creează Eveniment
              </Link>
              <Link
                :href="route('calendar.view')"
                class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
              >
                <i class="fas fa-calendar-alt mr-2"></i>
                Vezi Calendar
              </Link>
              <Link
                v-if="$page.props.auth.user"
                :href="route('calendar.my-events')"
                class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
              >
                <i class="fas fa-user mr-2"></i>
                Evenimentele Mele
              </Link>
            </div>
          </div>
        </div>

        <!-- Featured Events -->
        <div v-if="featuredEvents.length > 0" class="mb-6">
          <h3 class="text-lg font-medium text-gray-900 mb-4">Evenimente Recomandate</h3>
          <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <div
              v-for="event in featuredEvents"
              :key="event.id"
              class="bg-white overflow-hidden shadow-xl sm:rounded-lg hover:shadow-2xl transition-shadow duration-300 border-l-4 border-blue-500"
            >
              <div class="p-6">
                <div class="flex items-start justify-between mb-3">
                  <div class="flex-1">
                    <h4 class="text-lg font-semibold text-gray-900 mb-2">{{ event.title }}</h4>
                    <p class="text-sm text-gray-600 mb-3 line-clamp-2">{{ event.excerpt || event.description }}</p>
                  </div>
                  <span
                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"
                    :style="{ backgroundColor: event.category.color + '20', color: event.category.color }"
                  >
                    {{ event.category.name }}
                  </span>
                </div>
                
                <div class="space-y-2 text-sm text-gray-600 mb-4">
                  <div class="flex items-center">
                    <i class="fas fa-calendar mr-2 text-blue-500"></i>
                    <span>{{ formatDate(event.start_date) }}</span>
                  </div>
                  <div class="flex items-center">
                    <i class="fas fa-clock mr-2 text-blue-500"></i>
                    <span>{{ formatTime(event.start_date) }} - {{ formatTime(event.end_date) }}</span>
                  </div>
                  <div v-if="event.location" class="flex items-center">
                    <i class="fas fa-map-marker-alt mr-2 text-blue-500"></i>
                    <span>{{ event.location }}</span>
                  </div>
                </div>
                
                <Link
                  :href="route('calendar-events.show', event.id)"
                  class="inline-flex items-center px-3 py-1.5 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                >
                  Vezi Detalii
                </Link>
              </div>
            </div>
          </div>
        </div>

        <!-- This Week Events -->
        <div v-if="thisWeekEvents.length > 0" class="mb-6">
          <h3 class="text-lg font-medium text-gray-900 mb-4">Evenimente Această Săptămână</h3>
          <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <div class="divide-y divide-gray-200">
              <div
                v-for="event in thisWeekEvents"
                :key="event.id"
                class="p-6 hover:bg-gray-50 transition-colors duration-150"
              >
                <div class="flex items-center justify-between">
                  <div class="flex items-center gap-4">
                    <div
                      class="w-12 h-12 rounded-lg flex items-center justify-center text-white text-sm font-bold"
                      :style="{ backgroundColor: event.category.color }"
                    >
                      {{ formatDay(event.start_date) }}
                    </div>
                    <div>
                      <h4 class="font-medium text-gray-900">{{ event.title }}</h4>
                      <p class="text-sm text-gray-600">{{ formatTime(event.start_date) }} - {{ formatTime(event.end_date) }}</p>
                      <p v-if="event.location" class="text-sm text-gray-500">{{ event.location }}</p>
                    </div>
                  </div>
                  <div class="flex items-center gap-3">
                    <span
                      class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"
                      :style="{ backgroundColor: event.category.color + '20', color: event.category.color }"
                    >
                      {{ event.category.name }}
                    </span>
                    <Link
                      :href="route('calendar-events.show', event.id)"
                      class="text-blue-600 hover:text-blue-800 text-sm font-medium"
                    >
                      Vezi Detalii
                    </Link>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Filters Section -->
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6 mb-6">
          <form @submit.prevent="applyFilters" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
              <!-- Search -->
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                  Caută
                </label>
                <input
                  v-model="localFilters.search"
                  type="text"
                  placeholder="Caută evenimente..."
                  class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                />
              </div>

              <!-- Category Filter -->
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                  Categorie
                </label>
                <select
                  v-model="localFilters.category"
                  class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                >
                  <option value="">Toate categoriile</option>
                  <option
                    v-for="category in categories"
                    :key="category.id"
                    :value="category.id"
                  >
                    {{ category.name }}
                  </option>
                </select>
              </div>

              <!-- Type Filter -->
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                  Tip
                </label>
                <select
                  v-model="localFilters.type"
                  class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                >
                  <option value="">Toate tipurile</option>
                  <option
                    v-for="(label, value) in types"
                    :key="value"
                    :value="value"
                  >
                    {{ label }}
                  </option>
                </select>
              </div>

              <!-- Period Filter -->
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                  Perioada
                </label>
                <select
                  v-model="localFilters.period"
                  class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                >
                  <option value="">Toate perioadele</option>
                  <option
                    v-for="(label, value) in periods"
                    :key="value"
                    :value="value"
                  >
                    {{ label }}
                  </option>
                </select>
              </div>

              <!-- Sort -->
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                  Sortează
                </label>
                <select
                  v-model="localFilters.sort_by"
                  class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                >
                  <option value="start_date">Data</option>
                  <option value="title">Titlu</option>
                  <option value="category">Categorie</option>
                  <option value="organizer">Organizator</option>
                </select>
              </div>
            </div>

            <div class="flex justify-between items-center">
              <button
                type="submit"
                class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
              >
                <i class="fas fa-search mr-2"></i>
                Filtrează
              </button>
              <button
                type="button"
                @click="clearFilters"
                class="text-sm text-gray-600 hover:text-gray-800"
              >
                Resetează filtrele
              </button>
            </div>
          </form>
        </div>

        <!-- Events List -->
        <div class="space-y-4">
          <div
            v-for="event in events.data"
            :key="event.id"
            class="bg-white overflow-hidden shadow-xl sm:rounded-lg hover:shadow-2xl transition-shadow duration-300"
          >
            <div class="p-6">
              <div class="flex items-start justify-between">
                <div class="flex-1">
                  <div class="flex items-center gap-3 mb-3">
                    <h3 class="text-xl font-semibold text-gray-900">{{ event.title }}</h3>
                    <span
                      v-if="event.is_featured"
                      class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800"
                    >
                      <i class="fas fa-star mr-1"></i>
                      Recomandat
                    </span>
                  </div>
                  
                  <p class="text-gray-600 mb-4 line-clamp-2">{{ event.excerpt || event.description }}</p>
                  
                  <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm text-gray-600 mb-4">
                    <div class="flex items-center">
                      <i class="fas fa-calendar mr-2 text-blue-500"></i>
                      <span>{{ formatDate(event.start_date) }}</span>
                    </div>
                    <div class="flex items-center">
                      <i class="fas fa-clock mr-2 text-blue-500"></i>
                      <span>{{ formatTime(event.start_date) }} - {{ formatTime(event.end_date) }}</span>
                    </div>
                    <div v-if="event.location" class="flex items-center">
                      <i class="fas fa-map-marker-alt mr-2 text-blue-500"></i>
                      <span>{{ event.location }}</span>
                    </div>
                  </div>
                  
                  <div class="flex items-center gap-4">
                    <span
                      class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium"
                      :style="{ backgroundColor: event.category.color + '20', color: event.category.color }"
                    >
                      {{ event.category.name }}
                    </span>
                    <span class="text-sm text-gray-500">
                      Organizat de {{ event.organizer.name }}
                    </span>
                    <span v-if="event.requires_registration" class="text-sm text-orange-600">
                      <i class="fas fa-user-plus mr-1"></i>
                      Necesită înregistrare
                    </span>
                  </div>
                </div>
                
                <div class="flex flex-col items-end gap-3">
                  <Link
                    :href="route('calendar-events.show', event.id)"
                    class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                  >
                    Vezi Detalii
                  </Link>
                  
                  <div v-if="event.requires_registration" class="text-center">
                    <div class="text-sm text-gray-500">
                      {{ event.registered_participants }}/{{ event.max_participants || '∞' }}
                    </div>
                    <div class="text-xs text-gray-400">participanți</div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Pagination -->
        <div v-if="events.links && events.links.length > 3" class="mt-8">
          <nav class="flex items-center justify-between">
            <div class="flex-1 flex justify-between sm:hidden">
              <Link
                v-if="events.prev_page_url"
                :href="events.prev_page_url"
                class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50"
              >
                Anterior
              </Link>
              <Link
                v-if="events.next_page_url"
                :href="events.next_page_url"
                class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50"
              >
                Următor
              </Link>
            </div>
            <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
              <div>
                <p class="text-sm text-gray-700">
                  Afișând
                  <span class="font-medium">{{ events.from }}</span>
                  până la
                  <span class="font-medium">{{ events.to }}</span>
                  din
                  <span class="font-medium">{{ events.total }}</span>
                  rezultate
                </p>
              </div>
              <div>
                <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px">
                  <Link
                    v-for="(link, key) in events.links"
                    :key="key"
                    :href="link.url"
                    class="relative inline-flex items-center px-4 py-2 border text-sm font-medium"
                    :class="{
                      'bg-indigo-50 border-indigo-500 text-indigo-600': link.active,
                      'bg-white border-gray-300 text-gray-500 hover:bg-gray-50': !link.active && link.url,
                      'bg-white border-gray-300 text-gray-300 cursor-not-allowed': !link.url
                    }"
                    v-html="link.label"
                  ></Link>
                </nav>
              </div>
            </div>
          </nav>
        </div>

        <!-- Empty State -->
        <div
          v-if="events.data.length === 0"
          class="text-center py-12"
        >
          <i class="fas fa-calendar-times text-4xl text-gray-400 mb-4"></i>
          <h3 class="text-lg font-medium text-gray-900 mb-2">
            Nu s-au găsit evenimente
          </h3>
          <p class="text-gray-600 mb-4">
            Încearcă să modifici filtrele sau să creezi un eveniment nou.
          </p>
          <Link
            v-if="$page.props.auth.user"
            :href="route('calendar-events.create')"
            class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
          >
            <i class="fas fa-plus mr-2"></i>
            Creează Eveniment
          </Link>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script>
import { defineComponent } from 'vue'
import { Link } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'

export default defineComponent({
  components: {
    AppLayout,
    Link,
  },
  props: {
    events: Object,
    featuredEvents: Array,
    thisWeekEvents: Array,
    categories: Array,
    filters: Object,
    types: Object,
    periods: Object,
  },
  data() {
    return {
      localFilters: { ...this.filters }
    }
  },
  methods: {
    formatDate(date) {
      return new Date(date).toLocaleDateString('ro-RO', {
        year: 'numeric',
        month: 'long',
        day: 'numeric'
      })
    },
    formatTime(date) {
      return new Date(date).toLocaleTimeString('ro-RO', {
        hour: '2-digit',
        minute: '2-digit'
      })
    },
    formatDay(date) {
      return new Date(date).getDate()
    },
    applyFilters() {
      this.$inertia.get(route('calendar.index'), this.localFilters, {
        preserveState: true,
        preserveScroll: true,
      })
    },
    clearFilters() {
      this.localFilters = {
        search: '',
        category: '',
        type: '',
        period: '',
        sort_by: 'start_date',
        sort_order: 'asc'
      }
      this.applyFilters()
    }
  }
})
</script>

<style scoped>
.line-clamp-2 {
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}
</style> 