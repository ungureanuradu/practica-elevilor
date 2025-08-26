<template>
    <AppLayout title="Documente">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Documente
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <!-- Search and Filters -->
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6 mb-6">
                    <div class="flex flex-col md:flex-row gap-4">
                        <!-- Search -->
                        <div class="flex-1">
                            <input
                                v-model="filters.search"
                                type="text"
                                placeholder="Caută documente..."
                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                @input="debounceSearch"
                            />
                        </div>

                        <!-- Category Filter -->
                        <div class="w-full md:w-48">
                            <select
                                v-model="filters.category"
                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                @change="applyFilters"
                            >
                                <option value="">Toate categoriile</option>
                                <option v-for="category in categories" :key="category.id" :value="category.id">
                                    {{ category.name }}
                                </option>
                            </select>
                        </div>

                        <!-- Type Filter -->
                        <div class="w-full md:w-48">
                            <select
                                v-model="filters.type"
                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                @change="applyFilters"
                            >
                                <option value="">Toate tipurile</option>
                                <option v-for="type in types" :key="type" :value="type">
                                    {{ getTypeLabel(type) }}
                                </option>
                            </select>
                        </div>

                        <!-- Sort -->
                        <div class="w-full md:w-48">
                            <select
                                v-model="filters.sort"
                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                @change="applyFilters"
                            >
                                <option value="recent">Cele mai recente</option>
                                <option value="popular">Cele mai populare</option>
                                <option value="most_viewed">Cele mai vizualizate</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Upload Button -->
                <div class="mb-6">
                    <Link
                        :href="route('documents.create')"
                        class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150"
                    >
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Încarcă Document
                    </Link>
                </div>

                <!-- Documents Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div
                        v-for="document in documents.data"
                        :key="document.id"
                        class="bg-white overflow-hidden shadow-xl sm:rounded-lg hover:shadow-2xl transition-shadow duration-300"
                    >
                        <!-- Document Header -->
                        <div class="p-6">
                            <div class="flex items-start justify-between mb-4">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center mr-3">
                                        <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-semibold text-gray-900 mb-1">
                                            <Link :href="route('documents.show', document.id)" class="hover:text-blue-600">
                                                {{ document.title }}
                                            </Link>
                                        </h3>
                                        <p class="text-sm text-gray-500">{{ document.category.name }}</p>
                                    </div>
                                </div>
                                <div v-if="document.is_featured" class="bg-yellow-100 text-yellow-800 text-xs px-2 py-1 rounded-full">
                                    Recomandat
                                </div>
                            </div>

                            <!-- Document Description -->
                            <p v-if="document.excerpt" class="text-gray-600 text-sm mb-4 line-clamp-3">
                                {{ document.excerpt }}
                            </p>

                            <!-- Document Tags -->
                            <div v-if="document.tags && document.tags.length" class="mb-4">
                                <div class="flex flex-wrap gap-1">
                                    <span
                                        v-for="tag in document.tags.slice(0, 3)"
                                        :key="tag"
                                        class="bg-gray-100 text-gray-700 text-xs px-2 py-1 rounded"
                                    >
                                        {{ tag }}
                                    </span>
                                    <span v-if="document.tags.length > 3" class="text-gray-500 text-xs px-2 py-1">
                                        +{{ document.tags.length - 3 }}
                                    </span>
                                </div>
                            </div>

                            <!-- Document Meta -->
                            <div class="flex items-center justify-between text-sm text-gray-500 mb-4">
                                <div class="flex items-center space-x-4">
                                    <span>{{ document.type_label }}</span>
                                    <span>{{ document.file_size_formatted }}</span>
                                </div>
                                <div class="flex items-center space-x-4">
                                    <span class="flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                        {{ document.views_count_formatted }}
                                    </span>
                                    <span class="flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                        </svg>
                                        {{ document.downloads_count_formatted }}
                                    </span>
                                </div>
                            </div>

                            <!-- Document Actions -->
                            <div class="flex items-center justify-between">
                                <div class="flex items-center text-sm text-gray-500">
                                    <span>de {{ document.uploader.name }}</span>
                                    <span class="mx-2">•</span>
                                    <span>{{ document.published_formatted }}</span>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <Link
                                        v-if="document.preview_url"
                                        :href="document.preview_url"
                                        class="text-blue-600 hover:text-blue-800 text-sm font-medium"
                                    >
                                        Previzualizare
                                    </Link>
                                    <Link
                                        v-if="document.download_url"
                                        :href="document.download_url"
                                        class="inline-flex items-center px-3 py-1 bg-blue-600 text-white text-sm rounded-md hover:bg-blue-700 transition-colors"
                                    >
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                        </svg>
                                        Descarcă
                                    </Link>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pagination -->
                <div v-if="documents.links && documents.links.length > 3" class="mt-8">
                    <nav class="flex items-center justify-center">
                        <div class="flex space-x-1">
                            <Link
                                v-for="(link, key) in documents.links"
                                :key="key"
                                :href="link.url"
                                v-html="link.label"
                                class="px-3 py-2 text-sm font-medium rounded-md"
                                :class="{
                                    'bg-blue-600 text-white': link.active,
                                    'bg-white text-gray-700 hover:bg-gray-50': !link.active && link.url,
                                    'bg-gray-100 text-gray-400 cursor-not-allowed': !link.url
                                }"
                            />
                        </div>
                    </nav>
                </div>

                <!-- Empty State -->
                <div v-if="documents.data.length === 0" class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">Nu s-au găsit documente</h3>
                    <p class="mt-1 text-sm text-gray-500">
                        Încearcă să modifici filtrele sau să încarci un document nou.
                    </p>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script>
import { defineComponent, ref, onMounted } from 'vue'
import { Link, router } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'

export default defineComponent({
    components: {
        AppLayout,
        Link,
    },
    props: {
        documents: Object,
        categories: Array,
        types: Array,
        filters: Object,
    },
    setup(props) {
        const filters = ref({ ...props.filters })
        let searchTimeout = null

        const debounceSearch = () => {
            clearTimeout(searchTimeout)
            searchTimeout = setTimeout(() => {
                applyFilters()
            }, 300)
        }

        const applyFilters = () => {
            router.get(route('documents.index'), filters.value, {
                preserveState: true,
                preserveScroll: true,
            })
        }

        const getTypeLabel = (type) => {
            const labels = {
                'pdf': 'PDF',
                'doc': 'Word Document',
                'docx': 'Word Document',
                'ppt': 'PowerPoint',
                'pptx': 'PowerPoint',
                'xls': 'Excel',
                'xlsx': 'Excel',
                'txt': 'Text',
                'zip': 'Archive',
                'rar': 'Archive',
                'image': 'Image',
                'video': 'Video',
                'audio': 'Audio',
                'other': 'Other',
            }
            return labels[type] || type
        }

        return {
            filters,
            debounceSearch,
            applyFilters,
            getTypeLabel,
        }
    },
})
</script>

<style scoped>
.line-clamp-3 {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style> 