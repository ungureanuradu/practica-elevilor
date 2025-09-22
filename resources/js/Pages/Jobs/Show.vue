<template>
    <AppLayout :title="job.title">
        <template #header>
            <div class="flex items-center justify-between">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ job.title }}
                </h2>
                <div class="flex space-x-2">
                    <Link
                        v-if="canEdit"
                        :href="route('teacher.jobs.edit', job.id)"
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
                    >
                        Editează
                    </Link>
                    <Link
                        :href="route('jobs.index')"
                        class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded"
                    >
                        Înapoi la Joburi
                    </Link>
                </div>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <!-- Job Header -->
                    <div class="p-6 border-b border-gray-200">
                        <div class="flex items-start justify-between">
                            <div>
                                <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ job.title }}</h1>
                                <div class="flex items-center space-x-4 text-gray-600">
                                    <span class="flex items-center">
                                        <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                        </svg>
                                        {{ job.company?.name || job.company?.company_name }}
                                    </span>
                                    <span class="flex items-center">
                                        <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                        {{ job.location }}
                                    </span>
                                    <span class="flex items-center">
                                        <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        {{ job.type_label }}
                                    </span>
                                </div>
                            </div>
                            <div class="text-right">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium"
                                      :class="{
                                          'bg-green-100 text-green-800': job.status === 'active',
                                          'bg-yellow-100 text-yellow-800': job.status === 'paused',
                                          'bg-red-100 text-red-800': job.status === 'closed'
                                      }">
                                    {{ job.status_label }}
                                </span>
                                <div class="mt-2 text-lg font-semibold text-gray-900">
                                    {{ job.formatted_salary }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Job Details -->
                    <div class="p-6">
                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                            <!-- Main Content -->
                            <div class="lg:col-span-2 space-y-8">
                                <!-- Description -->
                                <div>
                                    <h3 class="text-xl font-semibold text-gray-900 mb-4">Descriere</h3>
                                    <div class="prose max-w-none">
                                        <p class="text-gray-700 leading-relaxed">{{ job.description }}</p>
                                    </div>
                                </div>

                                <!-- Requirements -->
                                <div v-if="job.requirements">
                                    <h3 class="text-xl font-semibold text-gray-900 mb-4">Cerințe</h3>
                                    <div class="prose max-w-none">
                                        <p class="text-gray-700 leading-relaxed">{{ job.requirements }}</p>
                                    </div>
                                </div>

                                <!-- Benefits -->
                                <div v-if="job.benefits">
                                    <h3 class="text-xl font-semibold text-gray-900 mb-4">Beneficii</h3>
                                    <div class="prose max-w-none">
                                        <p class="text-gray-700 leading-relaxed">{{ job.benefits }}</p>
                                    </div>
                                </div>

                                <!-- Skills Required -->
                                <div v-if="job.skills_required && job.skills_required.length">
                                    <h3 class="text-xl font-semibold text-gray-900 mb-4">Competențe Necesare</h3>
                                    <div class="flex flex-wrap gap-2">
                                        <span
                                            v-for="skill in job.skills_required"
                                            :key="skill"
                                            class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800"
                                        >
                                            {{ skill }}
                                        </span>
                                    </div>
                                </div>

                                <!-- Skills Preferred -->
                                <div v-if="job.skills_preferred && job.skills_preferred.length">
                                    <h3 class="text-xl font-semibold text-gray-900 mb-4">Competențe Preferate</h3>
                                    <div class="flex flex-wrap gap-2">
                                        <span
                                            v-for="skill in job.skills_preferred"
                                            :key="skill"
                                            class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800"
                                        >
                                            {{ skill }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <!-- Sidebar -->
                            <div class="space-y-6">
                                <!-- Job Info -->
                                <div class="bg-gray-50 rounded-lg p-6">
                                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Informații Job</h3>
                                    <div class="space-y-3">
                                        <div>
                                            <span class="text-sm font-medium text-gray-500">Tip:</span>
                                            <span class="ml-2 text-gray-900">{{ job.type_label }}</span>
                                        </div>
                                        <div>
                                            <span class="text-sm font-medium text-gray-500">Nivel:</span>
                                            <span class="ml-2 text-gray-900">{{ job.level_label }}</span>
                                        </div>
                                        <div>
                                            <span class="text-sm font-medium text-gray-500">Locație:</span>
                                            <span class="ml-2 text-gray-900">{{ job.location }}</span>
                                        </div>
                                        <div v-if="job.remote_ok">
                                            <span class="text-sm font-medium text-gray-500">Remote:</span>
                                            <span class="ml-2 text-green-600">Da</span>
                                        </div>
                                        <div v-if="job.hybrid_ok">
                                            <span class="text-sm font-medium text-gray-500">Hibrid:</span>
                                            <span class="ml-2 text-green-600">Da</span>
                                        </div>
                                        <div v-if="job.positions_available">
                                            <span class="text-sm font-medium text-gray-500">Poziții disponibile:</span>
                                            <span class="ml-2 text-gray-900">{{ job.positions_available }}</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Application Info -->
                                <div class="bg-gray-50 rounded-lg p-6">
                                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Informații Aplicare</h3>
                                    <div class="space-y-3">
                                        <div v-if="job.application_deadline">
                                            <span class="text-sm font-medium text-gray-500">Termen limită:</span>
                                            <span class="ml-2 text-gray-900">{{ formatDate(job.application_deadline) }}</span>
                                        </div>
                                        <div v-if="job.start_date">
                                            <span class="text-sm font-medium text-gray-500">Data începerii:</span>
                                            <span class="ml-2 text-gray-900">{{ formatDate(job.start_date) }}</span>
                                        </div>
                                        <div>
                                            <span class="text-sm font-medium text-gray-500">CV necesar:</span>
                                            <span class="ml-2" :class="job.cv_required ? 'text-red-600' : 'text-green-600'">
                                                {{ job.cv_required ? 'Da' : 'Nu' }}
                                            </span>
                                        </div>
                                        <div>
                                            <span class="text-sm font-medium text-gray-500">Scrisoare de intenție:</span>
                                            <span class="ml-2" :class="job.cover_letter_required ? 'text-red-600' : 'text-green-600'">
                                                {{ job.cover_letter_required ? 'Da' : 'Nu' }}
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Contact Info -->
                                <div class="bg-gray-50 rounded-lg p-6">
                                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Contact</h3>
                                    <div class="space-y-3">
                                        <div v-if="job.contact_email">
                                            <span class="text-sm font-medium text-gray-500">Email:</span>
                                            <a :href="`mailto:${job.contact_email}`" class="ml-2 text-blue-600 hover:text-blue-800">
                                                {{ job.contact_email }}
                                            </a>
                                        </div>
                                        <div v-if="job.contact_phone">
                                            <span class="text-sm font-medium text-gray-500">Telefon:</span>
                                            <a :href="`tel:${job.contact_phone}`" class="ml-2 text-blue-600 hover:text-blue-800">
                                                {{ job.contact_phone }}
                                            </a>
                                        </div>
                                        <div v-if="job.application_url">
                                            <span class="text-sm font-medium text-gray-500">Link aplicare:</span>
                                            <a :href="job.application_url" target="_blank" class="ml-2 text-blue-600 hover:text-blue-800">
                                                Aplică aici
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                <!-- Application Instructions -->
                                <div v-if="job.application_instructions" class="bg-gray-50 rounded-lg p-6">
                                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Instrucțiuni Aplicare</h3>
                                    <div class="prose max-w-none">
                                        <p class="text-gray-700 leading-relaxed">{{ job.application_instructions }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'

const props = defineProps({
    job: {
        type: Object,
        required: true
    },
    canEdit: {
        type: Boolean,
        default: false
    }
})

const formatDate = (date) => {
    return new Date(date).toLocaleDateString('ro-RO', {
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    })
}
</script> 