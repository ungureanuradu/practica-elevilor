<template>
  <FrontendLayout>
    <template #header>
      <div class="flex items-center justify-between">
        <div>
          <nav class="flex" aria-label="Breadcrumb">
            <ol class="flex items-center space-x-4">
              <li>
                <Link :href="route('forum.index')" class="text-gray-400 hover:text-gray-500">
                  Forum
                </Link>
              </li>
              <li>
                <div class="flex items-center">
                  <svg class="flex-shrink-0 h-5 w-5 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                  </svg>
                  <Link :href="route('forum.category', thread.category.slug)" class="ml-4 text-gray-400 hover:text-gray-500">
                    {{ thread.category.name }}
                  </Link>
                </div>
              </li>
              <li>
                <div class="flex items-center">
                  <svg class="flex-shrink-0 h-5 w-5 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                  </svg>
                  <span class="ml-4 text-gray-500">{{ thread.title }}</span>
                </div>
              </li>
            </ol>
          </nav>
          <h1 class="text-2xl font-bold text-gray-900 mt-2">{{ thread.title }}</h1>
        </div>
        <div class="flex space-x-3">
          <Link
            :href="route('forum.category', thread.category.slug)"
            class="bg-gray-600 text-white px-4 py-2 rounded-md hover:bg-gray-700"
          >
            Înapoi la Categorie
          </Link>
        </div>
      </div>
    </template>

    <div class="py-6">
      <!-- Thread Header -->
      <div class="bg-white rounded-lg shadow mb-6">
        <div class="px-6 py-4 border-b border-gray-200">
          <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
              <div class="w-10 h-10 bg-indigo-100 rounded-full flex items-center justify-center">
                <span class="text-indigo-600 font-medium">
                  {{ thread.author.name.charAt(0).toUpperCase() }}
                </span>
              </div>
              <div>
                <div class="text-sm font-medium text-gray-900">{{ thread.author.name }}</div>
                <div class="text-sm text-gray-500">{{ formatDate(thread.created_at) }}</div>
              </div>
            </div>
            <div class="flex items-center space-x-4">
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
              <span class="text-sm text-gray-500">{{ thread.views_count }} vizualizări</span>
            </div>
          </div>
        </div>

        <div class="px-6 py-4">
          <div class="prose max-w-none" v-html="thread.content"></div>
          
          <div v-if="thread.tags && thread.tags.length > 0" class="mt-4">
            <div class="flex flex-wrap gap-2">
              <span
                v-for="tag in thread.tags"
                :key="tag"
                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800"
              >
                {{ tag }}
              </span>
            </div>
          </div>
        </div>
      </div>

      <!-- Posts -->
      <div class="space-y-6">
        <div
          v-for="post in posts.data"
          :key="post.id"
          class="bg-white rounded-lg shadow"
        >
          <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex items-center justify-between">
              <div class="flex items-center space-x-4">
                <div class="w-8 h-8 bg-gray-100 rounded-full flex items-center justify-center">
                  <span class="text-gray-600 font-medium text-sm">
                    {{ post.author.name.charAt(0).toUpperCase() }}
                  </span>
                </div>
                <div>
                  <div class="text-sm font-medium text-gray-900">{{ post.author.name }}</div>
                  <div class="text-sm text-gray-500">{{ formatDate(post.created_at) }}</div>
                </div>
              </div>
              <div class="flex items-center space-x-2">
                <span
                  v-if="post.is_solution"
                  class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800"
                >
                  Soluție
                </span>
                <span
                  v-if="post.is_edited"
                  class="text-xs text-gray-500"
                >
                  Editat
                </span>
              </div>
            </div>
          </div>

          <div class="px-6 py-4">
            <div class="prose max-w-none" v-html="post.content"></div>
          </div>
        </div>
      </div>

      <!-- Pagination -->
      <div v-if="posts.links" class="mt-6">
        <nav class="flex items-center justify-between">
          <div class="flex-1 flex justify-between sm:hidden">
            <Link
              v-if="posts.prev_page_url"
              :href="posts.prev_page_url"
              class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50"
            >
              Anterior
            </Link>
            <Link
              v-if="posts.next_page_url"
              :href="posts.next_page_url"
              class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50"
            >
              Următor
            </Link>
          </div>
          <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
            <div>
              <p class="text-sm text-gray-700">
                Afișând
                <span class="font-medium">{{ posts.from }}</span>
                până la
                <span class="font-medium">{{ posts.to }}</span>
                din
                <span class="font-medium">{{ posts.total }}</span>
                răspunsuri
              </p>
            </div>
            <div>
              <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px">
                <Link
                  v-for="link in posts.links"
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
                  v-for="link in posts.links"
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
  </FrontendLayout>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'
import FrontendLayout from '@/Layouts/FrontendLayout.vue'

const props = defineProps({
  thread: Object,
  posts: Object,
})
console.log(props.posts);
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