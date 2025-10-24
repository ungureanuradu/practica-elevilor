<template>
  <AppLayout title="Aplicații Primite">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Aplicații Primite
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Filters -->
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6 mb-6">
          <h3 class="text-lg font-medium text-gray-900 mb-4">Filtrează Aplicațiile</h3>
          <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
              <select
                v-model="localFilters.status"
                class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
              >
                <option value="">Toate</option>
                <option value="pending">În așteptare</option>
                <option value="reviewed">Revizuit</option>
                <option value="shortlisted">Scurtlistat</option>
                <option value="rejected">Respins</option>
                <option value="hired">Angajat</option>
              </select>
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">Job</label>
              <select
                v-model="localFilters.job_id"
                class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
              >
                <option value="">Toate joburile</option>
                <option v-for="job in jobs" :key="job.id" :value="job.id">
                  {{ job.title }}
                </option>
              </select>
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">Caută</label>
              <input
                v-model="localFilters.search"
                type="text"
                placeholder="Nume candidat..."
                class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
              />
            </div>
            <div class="flex items-end">
              <button
                @click="applyFilters"
                class="w-full px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500"
              >
                Aplică Filtrele
              </button>
            </div>
          </div>
        </div>

        <!-- Applications List -->
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
          <div v-if="applications.data && applications.data.length" class="divide-y divide-gray-200">
            <div
              v-for="application in applications.data"
              :key="application.id"
              class="p-6 hover:bg-gray-50"
            >
              <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                  <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-indigo-100 rounded-full flex items-center justify-center">
                      <i class="fas fa-user text-indigo-600"></i>
                    </div>
                  </div>
                  <div>
                    <h3 class="text-lg font-medium text-gray-900">
                      {{ application.applicant.name }}
                    </h3>
                    <p class="text-sm text-gray-600">{{ application.applicant.email }}</p>
                    <p class="text-sm text-gray-500">
                      Aplicat pentru: <span class="font-medium">{{ application.job.title }}</span>
                    </p>
                  </div>
                </div>
                <div class="flex items-center space-x-4">
                  <span
                    :class="getStatusClass(application.status)"
                    class="px-3 py-1 rounded-full text-sm font-medium"
                  >
                    {{ getStatusLabel(application.status) }}
                  </span>
                  <div class="flex space-x-2">
                    <Link
                      :href="route('applications.show', application.id)"
                      class="px-3 py-1 bg-blue-600 text-white rounded-md hover:bg-blue-700 text-sm"
                    >
                      Vezi Detalii
                    </Link>
                    <button
                      @click="updateStatus(application.id, 'shortlisted')"
                      v-if="application.status === 'pending'"
                      class="px-3 py-1 bg-green-600 text-white rounded-md hover:bg-green-700 text-sm"
                    >
                      Scurtlistează
                    </button>
                    <button
                      @click="updateStatus(application.id, 'rejected')"
                      v-if="application.status === 'pending'"
                      class="px-3 py-1 bg-red-600 text-white rounded-md hover:bg-red-700 text-sm"
                    >
                      Respinge
                    </button>
                  </div>
                </div>
              </div>
              <div class="mt-4">
                <p class="text-sm text-gray-600">
                  <strong>Data aplicării:</strong> {{ formatDate(application.created_at) }}
                </p>
                <p v-if="application.cover_letter" class="text-sm text-gray-600 mt-2">
                  <strong>Scrisoare de intenție:</strong> {{ application.cover_letter.substring(0, 100) }}...
                </p>
              </div>
            </div>
          </div>
          <div v-else class="text-center py-12">
            <i class="fas fa-inbox text-4xl text-gray-400 mb-4"></i>
            <h3 class="text-lg font-medium text-gray-900 mb-2">Nu există aplicații</h3>
            <p class="text-gray-600">Nu ai primit încă aplicații pentru joburile tale.</p>
          </div>
        </div>

        <!-- Pagination -->
        <div v-if="applications.data && applications.data.length" class="mt-6">
          <nav class="flex items-center justify-between">
            <div class="text-sm text-gray-700">
              Afișând {{ applications.from }} - {{ applications.to }} din {{ applications.total }} aplicații
            </div>
            <div class="flex space-x-2">
              <Link
                v-if="applications.prev_page_url"
                :href="applications.prev_page_url"
                class="px-3 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50"
              >
                Anterior
              </Link>
              <Link
                v-if="applications.next_page_url"
                :href="applications.next_page_url"
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
import { ref } from 'vue'
import { Link, router } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'

const props = defineProps({
  applications: Object,
  jobs: Array,
  filters: Object,
})

const localFilters = ref({
  status: props.filters.status || '',
  job_id: props.filters.job_id || '',
  search: props.filters.search || '',
})

const applyFilters = () => {
  router.get(route('applications.received'), localFilters.value, {
    preserveState: true,
    preserveScroll: true,
  })
}

const updateStatus = (applicationId, status) => {
  router.put(route('applications.update', applicationId), {
    status: status
  }, {
    preserveState: true,
    preserveScroll: true,
  })
}

const getStatusClass = (status) => {
  const classes = {
    pending: 'bg-yellow-100 text-yellow-800',
    reviewed: 'bg-blue-100 text-blue-800',
    shortlisted: 'bg-green-100 text-green-800',
    rejected: 'bg-red-100 text-red-800',
    hired: 'bg-purple-100 text-purple-800',
  }
  return classes[status] || 'bg-gray-100 text-gray-800'
}

const getStatusLabel = (status) => {
  const labels = {
    pending: 'În așteptare',
    reviewed: 'Revizuit',
    shortlisted: 'Scurtlistat',
    rejected: 'Respins',
    hired: 'Angajat',
  }
  return labels[status] || status
}

const formatDate = (date) => {
  return new Date(date).toLocaleDateString('ro-RO', {
    year: 'numeric',
    month: 'long',
    day: 'numeric',
    hour: '2-digit',
    minute: '2-digit'
  })
}
</script>
