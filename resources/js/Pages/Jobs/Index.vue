<template>
    <AppLayout title="Joburi">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Joburi
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <!-- Statistics -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
                    <div class="bg-white rounded-lg shadow p-6">
                        <div class="text-2xl font-bold text-blue-600">{{ stats?.total || 0 }}</div>
                        <div class="text-sm text-gray-600">Total Joburi</div>
                    </div>
                    <div class="bg-white rounded-lg shadow p-6">
                        <div class="text-2xl font-bold text-green-600">{{ stats?.internships || 0 }}</div>
                        <div class="text-sm text-gray-600">Internship-uri</div>
                    </div>
                    <div class="bg-white rounded-lg shadow p-6">
                        <div class="text-2xl font-bold text-purple-600">{{ stats?.full_time || 0 }}</div>
                        <div class="text-sm text-gray-600">Full-time</div>
                    </div>
                    <div class="bg-white rounded-lg shadow p-6">
                        <div class="text-2xl font-bold text-orange-600">{{ stats?.remote || 0 }}</div>
                        <div class="text-sm text-gray-600">Remote</div>
                    </div>
                </div>

                <!-- Search and Filters -->
                <div class="bg-white rounded-lg shadow mb-8">
                    <div class="p-6">
                        <form @submit.prevent="submitSearch" class="space-y-4">
                            <!-- Search Bar -->
                            <div class="flex gap-4">
                                <div class="flex-1">
                                    <input
                                        v-model="searchForm.search"
                                        type="text"
                                        placeholder="Caută joburi..."
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                    />
                                </div>
                                <button
                                    type="submit"
                                    class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:ring-2 focus:ring-blue-500"
                                >
                                    Caută
                                </button>
                            </div>

                            <!-- Filters -->
                            <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                                <!-- Status -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                                    <select
                                        v-model="searchForm.status"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                                    >
                                        <option value="active">Active</option>
                                        <option value="all">Toate</option>
                                    </select>
                                </div>

                                <!-- Type -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Tip</label>
                                    <select
                                        v-model="searchForm.type"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                                    >
                                        <option value="all">Toate</option>
                                        <option value="full-time">Full-time</option>
                                        <option value="part-time">Part-time</option>
                                        <option value="internship">Internship</option>
                                        <option value="contract">Contract</option>
                                    </select>
                                </div>

                                <!-- Level -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Nivel</label>
                                    <select
                                        v-model="searchForm.level"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                                    >
                                        <option value="all">Toate</option>
                                        <option value="entry">Entry Level</option>
                                        <option value="junior">Junior</option>
                                        <option value="mid">Mid Level</option>
                                        <option value="senior">Senior</option>
                                    </select>
                                </div>

                                <!-- Location -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Locație</label>
                                    <input
                                        v-model="searchForm.location"
                                        type="text"
                                        placeholder="Oraș..."
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                                    />
                                </div>

                                <!-- Work Type -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Tip Muncă</label>
                                    <select
                                        v-model="searchForm.work_type"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                                    >
                                        <option value="all">Toate</option>
                                        <option value="remote">Remote</option>
                                        <option value="hybrid">Hybrid</option>
                                        <option value="onsite">On-site</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Sort and Clear -->
                            <div class="flex justify-between items-center">
                                <div class="flex items-center gap-4">
                                    <label class="text-sm font-medium text-gray-700">Sortează:</label>
                                    <select
                                        v-model="searchForm.sort"
                                        class="px-3 py-1 border border-gray-300 rounded focus:ring-2 focus:ring-blue-500"
                                    >
                                        <option value="published_at">Data publicării</option>
                                        <option value="title">Titlu</option>
                                        <option value="created_at">Data creării</option>
                                        <option value="salary_min">Salariu</option>
                                    </select>
                                    <button
                                        type="button"
                                        @click="searchForm.order = searchForm.order === 'asc' ? 'desc' : 'asc'"
                                        class="px-2 py-1 text-gray-600 hover:text-gray-800"
                                    >
                                        {{ searchForm.order === 'asc' ? '↑' : '↓' }}
                                    </button>
                                </div>
                                <button
                                    type="button"
                                    @click="clearFilters"
                                    class="px-4 py-2 text-gray-600 hover:text-gray-800"
                                >
                                    Șterge filtrele
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Jobs List -->
                <div class="space-y-4">
                    <div v-if="!jobs?.data || jobs.data.length === 0" class="text-center py-12">
                        <div class="text-gray-500 text-lg">Nu s-au găsit joburi care să corespundă criteriilor.</div>
                    </div>

                    <div v-else class="space-y-4">
                        <div
                            v-for="job in jobs.data"
                            :key="job.id"
                            class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition-shadow"
                        >
                            <div class="flex justify-between items-start">
                                <div class="flex-1">
                                    <h3 class="text-xl font-semibold text-gray-900 mb-2">
                                        <Link :href="`/jobs/${job.slug || job.id}`" class="hover:text-blue-600">
                                            {{ job.title }}
                                        </Link>
                                    </h3>
                                    <div class="flex items-center gap-4 text-sm text-gray-600 mb-3">
                                        <span class="flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                            </svg>
                                            {{ job.company?.name || 'Companie' }}
                                        </span>
                                        <span class="flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            </svg>
                                            {{ job.location }}
                                        </span>
                                        <span class="flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            {{ job.type }}
                                        </span>
                                    </div>
                                    <p class="text-gray-700 mb-4 line-clamp-2">{{ job.description }}</p>
                                    <div class="flex flex-wrap gap-2">
                                        <span
                                            v-for="skill in job.skills_required?.slice(0, 3)"
                                            :key="skill"
                                            class="px-2 py-1 bg-blue-100 text-blue-800 text-xs rounded-full"
                                        >
                                            {{ skill }}
                                        </span>
                                        <span v-if="job.skills_required?.length > 3" class="px-2 py-1 bg-gray-100 text-gray-600 text-xs rounded-full">
                                            +{{ job.skills_required.length - 3 }} mai multe
                                        </span>
                                    </div>
                                </div>
                                <div class="ml-4 text-right">
                                    <div class="text-lg font-semibold text-green-600">
                                        {{ job.salary_min ? `${job.salary_min} - ${job.salary_max} ${job.salary_currency}` : 'Salariu negociabil' }}
                                    </div>
                                    <div class="text-sm text-gray-500 mt-1">
                                        Publicat {{ new Date(job.published_at).toLocaleDateString('ro-RO') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pagination -->
                <div v-if="jobs?.data && jobs.data.length > 0" class="mt-8">
                    <div class="flex justify-center">
                        <nav class="flex items-center space-x-2">
                            <Link
                                v-for="link in jobs.links"
                                :key="link.label"
                                :href="link.url"
                                :class="[
                                    'px-3 py-2 text-sm rounded-lg',
                                    link.active
                                        ? 'bg-blue-600 text-white'
                                        : link.url
                                        ? 'bg-white text-gray-700 hover:bg-gray-50 border'
                                        : 'bg-gray-100 text-gray-400 cursor-not-allowed'
                                ]"
                                v-html="link.label"
                            />
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template> 

<script>
import { defineComponent } from 'vue'
import { Link, router } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'

export default defineComponent({
  components: {
    AppLayout,
    Link,
  },
  props: {
    jobs: Object,
    filters: Object,
    stats: Object,
  },
  data() {
    return {
      searchForm: {
        search: this.filters?.search || '',
        status: this.filters?.status || 'active',
        type: this.filters?.type || 'all',
        level: this.filters?.level || 'all',
        location: this.filters?.location || '',
        work_type: this.filters?.work_type || 'all',
        sort: this.filters?.sort || 'published_at',
        order: this.filters?.order || 'desc',
      }
    }
  },
  methods: {
    submitSearch() {
      router.get(route('jobs.index'), this.searchForm, {
        preserveState: true,
        preserveScroll: true,
      })
    },
    clearFilters() {
      this.searchForm = {
        search: '',
        status: 'active',
        type: 'all',
        level: 'all',
        location: '',
        work_type: 'all',
        sort: 'published_at',
        order: 'desc',
      }
      router.get(route('jobs.index'), this.searchForm, {
        preserveState: true,
        preserveScroll: true,
      })
    }
  }
})
</script>