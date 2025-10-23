<template>
    <FrontendLayout title="Forum">
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <!-- Forum Stats -->
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6 mb-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="text-center">
                            <div class="text-3xl font-bold text-blue-600">{{ stats.total_threads }}</div>
                            <div class="text-sm text-gray-600">Thread-uri</div>
                        </div>
                        <div class="text-center">
                            <div class="text-3xl font-bold text-green-600">{{ stats.total_posts }}</div>
                            <div class="text-sm text-gray-600">Post-uri</div>
                        </div>
                        <div class="text-center">
                            <div class="text-3xl font-bold text-purple-600">{{ stats.total_categories }}</div>
                            <div class="text-sm text-gray-600">Categorii</div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-4 mb-6">
                    <Link
                        :href="route('forum-threads.create')"
                        class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150"
                    >
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Thread Nou
                    </Link>
                    
                    <Link
                        v-if="$page.props.auth.user"
                        :href="route('forum.my-activity')"
                        class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150"
                    >
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        Activitatea Mea
                    </Link>

                    <Link
                        :href="route('forum.search')"
                        class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150"
                    >
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        Caută
                    </Link>
                </div>

                <!-- Categories -->
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg mb-8">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900">Categorii</h3>
                    </div>
                    <div class="divide-y divide-gray-200">
                        <div
                            v-for="category in categories"
                            :key="category.id"
                            class="p-6 hover:bg-gray-50 transition-colors"
                        >
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <div class="w-12 h-12 rounded-lg flex items-center justify-center mr-4" :style="{ backgroundColor: category.color + '20' }">
                                        <i :class="category.icon" :style="{ color: category.color }"></i>
                                    </div>
                                    <div>
                                        <h4 class="text-lg font-semibold text-gray-900">
                                            <Link :href="route('forum.category', category.slug)" class="hover:text-blue-600">
                                                {{ category.name }}
                                            </Link>
                                        </h4>
                                        <p v-if="category.description" class="text-sm text-gray-600 mt-1">
                                            {{ category.description }}
                                        </p>
                                        <div class="flex items-center space-x-4 mt-2 text-sm text-gray-500">
                                            <span>{{ category.threads_count }} thread-uri</span>
                                            <span>{{ category.posts_count }} post-uri</span>
                                            <span v-if="category.last_activity_at" class="text-xs">
                                                Ultima activitate: {{ category.last_activity_formatted }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="text-sm text-gray-500">
                                        {{ category.access_level_label }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Threads -->
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg mb-8">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900">Thread-uri Recente</h3>
                    </div>
                    <div class="divide-y divide-gray-200">
                        <div
                            v-for="thread in recentThreads"
                            :key="thread.id"
                            class="p-6 hover:bg-gray-50 transition-colors"
                        >
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <div class="flex items-center space-x-2 mb-2">
                                        <h4 class="text-lg font-semibold text-gray-900">
                                            <Link :href="route('forum-threads.show', thread.id)" class="hover:text-blue-600">
                                                {{ thread.title }}
                                            </Link>
                                        </h4>
                                        <span
                                            v-if="thread.is_solved"
                                            class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded-full"
                                        >
                                            Rezolvat
                                        </span>
                                        <span
                                            v-if="thread.is_featured"
                                            class="bg-yellow-100 text-yellow-800 text-xs px-2 py-1 rounded-full"
                                        >
                                            Recomandat
                                        </span>
                                    </div>
                                    <div class="flex items-center space-x-4 text-sm text-gray-500">
                                        <span>de {{ thread.author.name }}</span>
                                        <span>în {{ thread.category.name }}</span>
                                        <span>{{ thread.created_at }}</span>
                                        <span>{{ thread.replies_count }} răspunsuri</span>
                                        <span>{{ thread.views_count }} vizualizări</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Popular Threads -->
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900">Thread-uri Populare</h3>
                    </div>
                    <div class="divide-y divide-gray-200">
                        <div
                            v-for="thread in popularThreads"
                            :key="thread.id"
                            class="p-6 hover:bg-gray-50 transition-colors"
                        >
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <div class="flex items-center space-x-2 mb-2">
                                        <h4 class="text-lg font-semibold text-gray-900">
                                            <Link :href="route('forum-threads.show', thread.id)" class="hover:text-blue-600">
                                                {{ thread.title }}
                                            </Link>
                                        </h4>
                                        <span
                                            v-if="thread.is_solved"
                                            class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded-full"
                                        >
                                            Rezolvat
                                        </span>
                                    </div>
                                    <div class="flex items-center space-x-4 text-sm text-gray-500">
                                        <span>de {{ thread.author.name }}</span>
                                        <span>în {{ thread.category.name }}</span>
                                        <span>{{ thread.created_at }}</span>
                                        <span>{{ thread.replies_count }} răspunsuri</span>
                                        <span class="font-semibold text-blue-600">{{ thread.views_count }} vizualizări</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </FrontendLayout>
</template>

<script>
import { defineComponent } from 'vue'
import { Link } from '@inertiajs/vue3'
import FrontendLayout from '@/Layouts/FrontendLayout.vue'

export default defineComponent({
    components: {
        FrontendLayout,
        Link,
    },
    props: {
        categories: Array,
        recentThreads: Array,
        popularThreads: Array,
        stats: Object,
    },
})
</script> 