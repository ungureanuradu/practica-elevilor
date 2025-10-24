<template>
  <FrontendLayout>
    <template #header>
      <div class="flex items-center justify-between">
        <div>
          <h1 class="text-2xl font-bold text-gray-900">{{ category.name }}</h1>
          <p class="text-gray-600 mt-1">{{ category.description }}</p>
        </div>
        <div class="flex space-x-3">
          <Link
            :href="route('forum.index')"
            class="bg-gray-600 text-white px-4 py-2 rounded-md hover:bg-gray-700"
          >
            Înapoi la Forum
          </Link>
        </div>
      </div>
    </template>

    <div class="py-6">
      <!-- Threads List -->
      <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200">
          <h2 class="text-lg font-medium text-gray-900">Thread-uri</h2>
        </div>

        <div v-if="threads.data.length === 0" class="p-6 text-center text-gray-500">
          Nu există thread-uri în această categorie.
        </div>

        <div v-else class="divide-y divide-gray-200">
          <div
            v-for="thread in threads.data"
            :key="thread.id"
            class="p-6 hover:bg-gray-50"
          >
            <div class="flex items-start space-x-4">
              <div class="flex-shrink-0">
                <div class="w-10 h-10 bg-indigo-100 rounded-full flex items-center justify-center">
                  <span class="text-indigo-600 font-medium">
                    {{ thread.author.name.charAt(0).toUpperCase() }}
                  </span>
                </div>
              </div>

              <div class="flex-1 min-w-0">
                <div class="flex items-center space-x-2 mb-2">
                  <Link
                    :href="route('forum-threads.show', thread.id)"
                    class="text-lg font-medium text-gray-900 hover:text-indigo-600"
                  >
                    {{ thread.title }}
                  </Link>
                  
                  <span
                    v-if="thread.type === 'sticky'"
                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800"
                  >
                    Lipit
                  </span>
                  
                  <span
                    v-if="thread.is_solved"
                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800"
                  >
                    Rezolvat
                  </span>
                </div>

                <div class="flex items-center space-x-4 text-sm text-gray-500">
                  <span>de {{ thread.author.name }}</span>
                  <span>{{ formatDate(thread.created_at) }}</span>
                  <span>{{ thread.views_count }} vizualizări</span>
                  <span>{{ thread.replies_count }} răspunsuri</span>
                </div>

                <div v-if="thread.tags && thread.tags.length > 0" class="mt-2">
                  <div class="flex flex-wrap gap-1">
                    <span
                      v-for="tag in thread.tags"
                      :key="tag"
                      class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800"
                    >
                      {{ tag }}
                    </span>
                  </div>
                </div>
              </div>

              <div class="flex-shrink-0 text-right">
                <div v-if="thread.last_post" class="text-sm text-gray-500">
                  <div>Ultimul răspuns</div>
                  <div>{{ formatDate(thread.last_post.created_at) }}</div>
                  <div>de {{ thread.last_post.author.name }}</div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Pagination -->
        <div v-if="threads.links" class="px-6 py-4 border-t border-gray-200">
          <nav class="flex items-center justify-between">
            <div class="flex-1 flex justify-between sm:hidden">
              <Link
                v-if="threads.prev_page_url"
                :href="threads.prev_page_url"
                class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50"
              >
                Anterior
              </Link>
              <Link
                v-if="threads.next_page_url"
                :href="threads.next_page_url"
                class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50"
              >
                Următor
              </Link>
            </div>
            <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
              <div>
                <p class="text-sm text-gray-700">
                  Afișând
                  <span class="font-medium">{{ threads.from }}</span>
                  până la
                  <span class="font-medium">{{ threads.to }}</span>
                  din
                  <span class="font-medium">{{ threads.total }}</span>
                  rezultate
                </p>
              </div>
              <div>
                <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px">
                  <Link
                    v-for="link in threads.links"
                    v-if="link && link.url"
                    :key="link.label"
                    :href="link.url"
                    v-html="link.label"
                    :class="[
                      'relative inline-flex items-center px-4 py-2 border text-sm font-medium',
                      link.active
                        ? 'z-10 bg-indigo-50 border-indigo-500 text-indigo-600'
                        : 'bg-white border-gray-300 text-gray-500 hover:bg-gray-50'
                    ]"
                  />
                  <span
                    v-for="link in threads.links"
                    v-if="link && !link.url"
                    :key="link.label"
                    v-html="link.label"
                    class="relative inline-flex items-center px-4 py-2 border text-sm font-medium bg-gray-100 border-gray-300 text-gray-400 cursor-not-allowed"
                  />
                </nav>
              </div>
            </div>
          </nav>
        </div>
      </div>
    </div>
  </FrontendLayout>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'
import FrontendLayout from '@/Layouts/FrontendLayout.vue'

const props = defineProps({
  category: Object,
  threads: Object,
})

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