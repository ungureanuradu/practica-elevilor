<template>
  <AppLayout title="Aplicațiile Mele">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Aplicațiile Mele
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
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
                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                      <i class="fas fa-briefcase text-blue-600"></i>
                    </div>
                  </div>
                  <div>
                    <h3 class="text-lg font-medium text-gray-900">
                      {{ application.job.title }}
                    </h3>
                    <p class="text-sm text-gray-600">{{ application.job.company.name }}</p>
                    <p class="text-sm text-gray-500">
                      Aplicat pe: {{ formatDate(application.created_at) }}
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
                      :href="route('jobs.show', application.job.id)"
                      class="px-3 py-1 bg-blue-600 text-white rounded-md hover:bg-blue-700 text-sm"
                    >
                      Vezi Job
                    </Link>
                    <button
                      v-if="application.status === 'pending'"
                      @click="withdrawApplication(application.id)"
                      class="px-3 py-1 bg-red-600 text-white rounded-md hover:bg-red-700 text-sm"
                    >
                      Retrage Aplicația
                    </button>
                  </div>
                </div>
              </div>
              <div class="mt-4">
                <div v-if="application.cover_letter" class="text-sm text-gray-600">
                  <strong>Scrisoare de intenție:</strong>
                  <p class="mt-1">{{ application.cover_letter.substring(0, 200) }}{{ application.cover_letter.length > 200 ? '...' : '' }}</p>
                </div>
                <div v-if="application.notes" class="text-sm text-gray-600 mt-2">
                  <strong>Note:</strong>
                  <p class="mt-1">{{ application.notes }}</p>
                </div>
                <div v-if="application.feedback" class="text-sm text-gray-600 mt-2">
                  <strong>Feedback:</strong>
                  <p class="mt-1">{{ application.feedback }}</p>
                </div>
              </div>
            </div>
          </div>
          <div v-else class="text-center py-12">
            <i class="fas fa-inbox text-4xl text-gray-400 mb-4"></i>
            <h3 class="text-lg font-medium text-gray-900 mb-2">Nu ai aplicat la niciun job</h3>
            <p class="text-gray-600 mb-4">Începe să aplici la joburi pentru a vedea aplicațiile tale aici.</p>
            <Link
              :href="route('jobs.index')"
              class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
            >
              <i class="fas fa-search mr-2"></i>
              Caută Joburi
            </Link>
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
import { Link, router } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'

const props = defineProps({
  applications: Object,
})

const getStatusClass = (status) => {
  const classes = {
    pending: 'bg-yellow-100 text-yellow-800',
    reviewed: 'bg-blue-100 text-blue-800',
    shortlisted: 'bg-green-100 text-green-800',
    rejected: 'bg-red-100 text-red-800',
    hired: 'bg-purple-100 text-purple-800',
    withdrawn: 'bg-gray-100 text-gray-800',
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
    withdrawn: 'Retras',
  }
  return labels[status] || status
}

const withdrawApplication = (applicationId) => {
  if (confirm('Ești sigur că vrei să retragi această aplicație?')) {
    router.delete(route('applications.withdraw', applicationId), {
      preserveState: true,
      preserveScroll: true,
    })
  }
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
