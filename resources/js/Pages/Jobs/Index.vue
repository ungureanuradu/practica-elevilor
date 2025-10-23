<template>
    <FrontendLayout title="Joburi">
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <!-- Statistics -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
                    <div class="bg-white rounded-lg shadow p-6">
                        <div class="text-2xl font-bold text-blue-600">{{ stats?.total || 0 }}</div>
                        <div class="text-sm text-gray-600">Total Joburi</div>
                    </div>
                    <div class="bg-white rounded-lg shadow p-6">
                        <div class="text-2xl font-bold text-green-600">{{ stats?.active || 0 }}</div>
                        <div class="text-sm text-gray-600">Active</div>
                    </div>
                    <div class="bg-white rounded-lg shadow p-6">
                        <div class="text-2xl font-bold text-orange-600">{{ stats?.internship || 0 }}</div>
                        <div class="text-sm text-gray-600">Internship</div>
                    </div>
                    <div class="bg-white rounded-lg shadow p-6">
                        <div class="text-2xl font-bold text-purple-600">{{ stats?.mentorship || 0 }}</div>
                        <div class="text-sm text-gray-600">Mentorship</div>
                    </div>
                </div>

                <!-- Search and Filters -->
                <div class="bg-white rounded-lg shadow p-6 mb-8">
                    <form @submit.prevent="submitSearch" class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                            <!-- Search -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Caută</label>
                                <input
                                    v-model="searchForm.search"
                                    type="text"
                                    class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                    placeholder="Titlu job, companie, locație..."
                                />
                            </div>

                            <!-- Status -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                                <select
                                    v-model="searchForm.status"
                                    class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                >
                                    <option value="all">Toate</option>
                                    <option value="active">Active</option>
                                    <option value="closed">Închise</option>
                                    <option value="draft">Ciornă</option>
                                </select>
                            </div>

                            <!-- Type -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Tip</label>
                                <select
                                    v-model="searchForm.type"
                                    class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                >
                                    <option value="all">Toate</option>
                                    <option value="full-time">Full-time</option>
                                    <option value="part-time">Part-time</option>
                                    <option value="internship">Internship</option>
                                    <option value="mentorship">Mentorship</option>
                                </select>
                            </div>

                            <!-- Level -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Nivel</label>
                                <select
                                    v-model="searchForm.level"
                                    class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                >
                                    <option value="all">Toate</option>
                                    <option value="entry">Entry Level</option>
                                    <option value="junior">Junior</option>
                                    <option value="mid">Mid Level</option>
                                    <option value="senior">Senior</option>
                                    <option value="lead">Lead</option>
                                </select>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <!-- Location -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Locație</label>
                                <input
                                    v-model="searchForm.location"
                                    type="text"
                                    class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                    placeholder="Oraș, regiune..."
                                />
                            </div>

                            <!-- Work Type -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Tip Muncă</label>
                                <select
                                    v-model="searchForm.work_type"
                                    class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                >
                                    <option value="all">Toate</option>
                                    <option value="remote">Remote</option>
                                    <option value="hybrid">Hybrid</option>
                                    <option value="onsite">On-site</option>
                                </select>
                            </div>

                            <!-- Sort -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Sortare</label>
                                <select
                                    v-model="searchForm.sort"
                                    class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                >
                                    <option value="published_at">Data publicării</option>
                                    <option value="title">Titlu</option>
                                    <option value="salary_min">Salariu minim</option>
                                    <option value="created_at">Data creării</option>
                                </select>
                            </div>
                        </div>

                        <div class="flex justify-between items-center">
                            <button
                                type="submit"
                                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md transition duration-200"
                            >
                                Caută
                            </button>
                            <button
                                type="button"
                                @click="clearFilters"
                                class="text-gray-600 hover:text-gray-800 px-4 py-2 rounded-md transition duration-200"
                            >
                                Resetează filtrele
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Jobs List -->
                <div v-if="!jobs?.data || jobs.data.length === 0" class="text-center py-12">
                    <div class="text-gray-500 text-lg">Nu s-au găsit joburi</div>
                    <div class="text-gray-400 text-sm mt-2">Încearcă să modifici filtrele de căutare</div>
                </div>

                <div v-else class="space-y-4">
                    <div
                        v-for="job in jobs.data"
                        :key="job.id"
                        class="bg-white rounded-lg shadow hover:shadow-md transition duration-200"
                    >
                        <div class="p-6">
                            <div class="flex justify-between items-start">
                                <div class="flex-1">
                                    <div class="flex items-center space-x-2 mb-2">
                                        <h3 class="text-xl font-semibold text-gray-900">
                                            <Link :href="route('jobs.show', job.id)" class="hover:text-blue-600">
                                                {{ job.title }}
                                            </Link>
                                        </h3>
                                        <span
                                            :class="{
                                                'bg-green-100 text-green-800': job.status === 'active',
                                                'bg-red-100 text-red-800': job.status === 'closed',
                                                'bg-gray-100 text-gray-800': job.status === 'draft'
                                            }"
                                            class="px-2 py-1 text-xs font-medium rounded-full"
                                        >
                                            {{ getStatusLabel(job.status) }}
                                        </span>
                                    </div>

                                    <div class="flex items-center space-x-4 text-sm text-gray-600 mb-3">
                                        <span class="flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a1 1 0 110 2h-3a1 1 0 01-1-1v-2a1 1 0 00-1-1H9a1 1 0 00-1 1v2a1 1 0 01-1 1H4a1 1 0 110-2V4zm3 1h2v2H7V5zm2 4H7v2h2V9zm2-4h2v2h-2V5zm2 4h-2v2h2V9z" clip-rule="evenodd" />
                                            </svg>
                                            {{ job.company?.name || 'Companie necunoscută' }}
                                        </span>
                                        <span class="flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                                            </svg>
                                            {{ job.location }}
                                        </span>
                                        <span class="flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                                            </svg>
                                            {{ formatDate(job.published_at) }}
                                        </span>
                                    </div>

                                    <p class="text-gray-700 mb-4 line-clamp-2">{{ job.description }}</p>

                                    <div class="flex flex-wrap gap-2 mb-4">
                                        <span
                                            v-for="skill in job.skills_required?.slice(0, 3)"
                                            :key="skill"
                                            class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded"
                                        >
                                            {{ skill }}
                                        </span>
                                        <span v-if="job.skills_required?.length > 3" class="text-gray-500 text-xs">
                                            +{{ job.skills_required.length - 3 }} mai multe
                                        </span>
                                    </div>

                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center space-x-4 text-sm">
                                            <span class="text-gray-600">
                                                {{ getTypeLabel(job.type) }}
                                            </span>
                                            <span class="text-gray-600">
                                                {{ getLevelLabel(job.level) }}
                                            </span>
                                            <span v-if="job.salary_min && job.salary_max" class="text-green-600 font-medium">
                                                {{ formatSalary(job.salary_min, job.salary_max, job.salary_currency) }}
                                            </span>
                                        </div>
                                        <Link
                                            :href="route('jobs.show', job.id)"
                                            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium transition duration-200"
                                        >
                                            Vezi detalii
                                        </Link>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pagination -->
                <div v-if="jobs?.data && jobs.data.length > 0" class="mt-8">
                    <div class="flex items-center justify-between">
                        <div class="text-sm text-gray-700">
                            Afișând {{ jobs.from || 0 }} - {{ jobs.to || 0 }} din {{ jobs.total || 0 }} joburi
                        </div>
                        <div class="flex space-x-2">
                            <Link
                                v-if="jobs.prev_page_url"
                                :href="jobs.prev_page_url"
                                class="px-3 py-2 text-sm border border-gray-300 rounded-md hover:bg-gray-50"
                            >
                                Anterior
                            </Link>
                            <span
                                v-for="page in getPageNumbers()"
                                :key="page"
                                :class="{
                                    'bg-blue-600 text-white': page === jobs.current_page,
                                    'bg-white text-gray-700 hover:bg-gray-50': page !== jobs.current_page
                                }"
                                class="px-3 py-2 text-sm border border-gray-300 rounded-md cursor-pointer"
                                @click="goToPage(page)"
                            >
                                {{ page }}
                            </span>
                            <Link
                                v-if="jobs.next_page_url"
                                :href="jobs.next_page_url"
                                class="px-3 py-2 text-sm border border-gray-300 rounded-md hover:bg-gray-50"
                            >
                                Următor
                            </Link>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </FrontendLayout>
</template>

<script>
import { defineComponent } from 'vue'
import { Link, router } from '@inertiajs/vue3'
import FrontendLayout from '@/Layouts/FrontendLayout.vue'

export default defineComponent({
    components: {
        FrontendLayout,
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
            },
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
        },
        getStatusLabel(status) {
            const labels = {
                active: 'Activ',
                closed: 'Închis',
                draft: 'Ciornă'
            }
            return labels[status] || status
        },
        getTypeLabel(type) {
            const labels = {
                'full-time': 'Full-time',
                'part-time': 'Part-time',
                internship: 'Internship',
                mentorship: 'Mentorship'
            }
            return labels[type] || type
        },
        getLevelLabel(level) {
            const labels = {
                entry: 'Entry Level',
                junior: 'Junior',
                mid: 'Mid Level',
                senior: 'Senior',
                lead: 'Lead'
            }
            return labels[level] || level
        },
        formatDate(dateString) {
            if (!dateString) return ''
            const date = new Date(dateString)
            return date.toLocaleDateString('ro-RO', {
                year: 'numeric',
                month: 'short',
                day: 'numeric'
            })
        },
        formatSalary(min, max, currency) {
            if (!min || !max) return ''
            const formatNumber = (num) => {
                return new Intl.NumberFormat('ro-RO').format(parseInt(num))
            }
            return `${formatNumber(min)} - ${formatNumber(max)} ${currency}`
        },
        getPageNumbers() {
            if (!this.jobs) return []
            const current = this.jobs.current_page
            const last = this.jobs.last_page
            const delta = 2
            const range = []
            const rangeWithDots = []

            for (let i = Math.max(2, current - delta); i <= Math.min(last - 1, current + delta); i++) {
                range.push(i)
            }

            if (current - delta > 2) {
                rangeWithDots.push(1, '...')
            } else {
                rangeWithDots.push(1)
            }

            rangeWithDots.push(...range)

            if (current + delta < last - 1) {
                rangeWithDots.push('...', last)
            } else {
                rangeWithDots.push(last)
            }

            return rangeWithDots
        },
        goToPage(page) {
            if (page === '...' || page === this.jobs.current_page) return
            
            const url = new URL(this.jobs.first_page_url)
            url.searchParams.set('page', page)
            
            // Preserve current filters
            Object.keys(this.searchForm).forEach(key => {
                if (this.searchForm[key] && this.searchForm[key] !== 'all') {
                    url.searchParams.set(key, this.searchForm[key])
                }
            })
            
            router.visit(url.toString())
        }
    }
})
</script>