<script setup>
import { ref, computed } from 'vue'
import { Link, router } from '@inertiajs/vue3'
import { Head } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'

const props = defineProps({
  courses: Object,
  filters: Object,
  stats: Object,
})

const search = ref(props.filters.search || '')
const status = ref(props.filters.status || 'published')
const level = ref(props.filters.level || 'all')
const price = ref(props.filters.price || 'all')
const sort = ref(props.filters.sort || 'created_at')
const order = ref(props.filters.order || 'desc')

const updateFilters = () => {
  router.get('/courses', {
    search: search.value,
    status: status.value,
    level: level.value,
    price: price.value,
    sort: sort.value,
    order: order.value,
  }, {
    preserveState: true,
    replace: true,
  })
}

const clearFilters = () => {
  search.value = ''
  status.value = 'published'
  level.value = 'all'
  price.value = 'all'
  sort.value = 'created_at'
  order.value = 'desc'
  updateFilters()
}

const levelLabels = {
  beginner: 'Începător',
  intermediate: 'Intermediar',
  advanced: 'Avansat'
}

const statusLabels = {
  published: 'Publicat',
  draft: 'Ciornă',
  archived: 'Arhivat'
}
</script>

<template>
  <Head title="Cursuri" />

  <AppLayout>
    <template #header>
      <div class="flex items-center justify-between">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          Cursuri
        </h2>
        <Link
          v-if="$page.props.auth.user"
          :href="route('courses.create')"
          class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors"
        >
          + Creează curs
        </Link>
      </div>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Stats -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
          <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
              <div class="p-2 bg-blue-100 rounded-lg">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                </svg>
              </div>
              <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Total cursuri</p>
                <p class="text-2xl font-semibold text-gray-900">{{ stats.total }}</p>
              </div>
            </div>
          </div>

          <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
              <div class="p-2 bg-green-100 rounded-lg">
                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                </svg>
              </div>
              <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Gratuite</p>
                <p class="text-2xl font-semibold text-gray-900">{{ stats.free }}</p>
              </div>
            </div>
          </div>

          <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
              <div class="p-2 bg-purple-100 rounded-lg">
                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
              </div>
              <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Plătite</p>
                <p class="text-2xl font-semibold text-gray-900">{{ stats.paid }}</p>
              </div>
            </div>
          </div>
        </div>

        <!-- Filters -->
        <div class="bg-white rounded-lg shadow mb-8">
          <div class="p-6 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Filtre</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
              <!-- Search -->
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Caută</label>
                <input
                  v-model="search"
                  type="text"
                  placeholder="Titlu, descriere..."
                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                  @input="updateFilters"
                >
              </div>

              <!-- Status -->
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                <select
                  v-model="status"
                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                  @change="updateFilters"
                >
                  <option value="all">Toate</option>
                  <option value="published">Publicate</option>
                  <option value="draft">Ciorne</option>
                  <option value="archived">Arhivate</option>
                </select>
              </div>

              <!-- Level -->
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Nivel</label>
                <select
                  v-model="level"
                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                  @change="updateFilters"
                >
                  <option value="all">Toate</option>
                  <option value="beginner">Începător</option>
                  <option value="intermediate">Intermediar</option>
                  <option value="advanced">Avansat</option>
                </select>
              </div>

              <!-- Price -->
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Preț</label>
                <select
                  v-model="price"
                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                  @change="updateFilters"
                >
                  <option value="all">Toate</option>
                  <option value="free">Gratuite</option>
                  <option value="paid">Plătite</option>
                </select>
              </div>
            </div>

            <div class="flex items-center justify-between mt-4">
              <button
                @click="clearFilters"
                class="text-sm text-gray-600 hover:text-gray-800 underline"
              >
                Șterge filtrele
              </button>

              <!-- Sort -->
              <div class="flex items-center space-x-2">
                <label class="text-sm text-gray-700">Sortează:</label>
                <select
                  v-model="sort"
                  class="px-3 py-1 border border-gray-300 rounded text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                  @change="updateFilters"
                >
                  <option value="created_at">Data creării</option>
                  <option value="title">Titlu</option>
                  <option value="published_at">Data publicării</option>
                  <option value="price">Preț</option>
                </select>
                <button
                  @click="order = order === 'asc' ? 'desc' : 'asc'; updateFilters()"
                  class="p-1 hover:bg-gray-100 rounded"
                  :title="order === 'asc' ? 'Crescător' : 'Descrescător'"
                >
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path v-if="order === 'asc'" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                    <path v-else stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                  </svg>
                </button>
              </div>
            </div>
          </div>
        </div>

        <!-- Courses Grid -->
        <div v-if="courses.data.length > 0" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
          <div
            v-for="course in courses.data"
            :key="course.id"
            class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition-shadow"
          >
            <!-- Thumbnail -->
            <div class="aspect-video bg-gray-100 relative">
              <img
                v-if="course.thumbnail"
                :src="course.thumbnail"
                :alt="course.title"
                class="w-full h-full object-cover"
              >
              <div v-else class="w-full h-full flex items-center justify-center">
                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                </svg>
              </div>
              
              <!-- Status badge -->
              <div class="absolute top-2 right-2">
                <span
                  :class="{
                    'bg-green-100 text-green-800': course.status === 'published',
                    'bg-yellow-100 text-yellow-800': course.status === 'draft',
                    'bg-gray-100 text-gray-800': course.status === 'archived'
                  }"
                  class="px-2 py-1 text-xs font-medium rounded-full"
                >
                  {{ statusLabels[course.status] }}
                </span>
              </div>

              <!-- Price badge -->
              <div class="absolute top-2 left-2">
                <span
                  :class="{
                    'bg-green-100 text-green-800': course.is_free,
                    'bg-blue-100 text-blue-800': !course.is_free
                  }"
                  class="px-2 py-1 text-xs font-medium rounded-full"
                >
                  {{ course.formatted_price }}
                </span>
              </div>
            </div>

            <!-- Content -->
            <div class="p-6">
              <div class="flex items-center justify-between mb-2">
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                  {{ levelLabels[course.level] }}
                </span>
                <span class="text-sm text-gray-500">
                  {{ course.total_modules }} module
                </span>
              </div>

              <h3 class="text-lg font-semibold text-gray-900 mb-2 line-clamp-2">
                {{ course.title }}
              </h3>

              <p v-if="course.excerpt" class="text-gray-600 text-sm mb-4 line-clamp-3">
                {{ course.excerpt }}
              </p>

              <!-- Instructor -->
              <div class="flex items-center mb-4">
                <img
                  :src="course.instructor.profile_photo_url"
                  :alt="course.instructor.name"
                  class="w-8 h-8 rounded-full"
                >
                <div class="ml-3">
                  <p class="text-sm font-medium text-gray-900">
                    {{ course.instructor.display_name }}
                  </p>
                  <p class="text-xs text-gray-500">
                    {{ course.instructor.role_label }}
                  </p>
                </div>
              </div>

              <!-- Stats -->
              <div class="flex items-center justify-between text-sm text-gray-500 mb-4">
                <span>{{ course.duration_hours }} ore</span>
                <span>{{ course.total_modules }} module</span>
              </div>

              <!-- Action -->
              <Link
                :href="route('courses.show', course.slug)"
                class="w-full bg-blue-600 hover:bg-blue-700 text-white text-center py-2 px-4 rounded-lg text-sm font-medium transition-colors"
              >
                Vezi cursul
              </Link>
            </div>
          </div>
        </div>

        <!-- Empty state -->
        <div v-else class="text-center py-12">
          <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
          </svg>
          <h3 class="mt-2 text-sm font-medium text-gray-900">Nu s-au găsit cursuri</h3>
          <p class="mt-1 text-sm text-gray-500">
            Încearcă să modifici filtrele sau să creezi un curs nou.
          </p>
        </div>

        <!-- Pagination -->
        <div v-if="courses.data.length > 0" class="mt-8">
          <!-- Add pagination component here if needed -->
        </div>
      </div>
    </div>
  </AppLayout>
</template> 