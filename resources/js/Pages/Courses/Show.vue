<script setup>
import { ref } from 'vue'
import { Head, Link, router } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'
import PrimaryButton from '@/Components/PrimaryButton.vue'
import SecondaryButton from '@/Components/SecondaryButton.vue'

const props = defineProps({
  course: Object,
  canEdit: Boolean,
  canAccess: Boolean,
})

const activeChapter = ref(null)
const activeModule = ref(null)

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

const moduleTypeIcons = {
  text: '📝',
  video: '🎥',
  file: '📄',
  quiz: '❓',
  assignment: '📋'
}

const publishCourse = () => {
  router.post(route('courses.publish', props.course.id))
}

const unpublishCourse = () => {
  router.post(route('courses.unpublish', props.course.id))
}

const deleteCourse = () => {
  if (confirm('Ești sigur că vrei să ștergi acest curs?')) {
    router.delete(route('courses.destroy', props.course.id))
  }
}
</script>

<template>
  <Head :title="course.title" />

  <AppLayout>
    <template #header>
      <div class="flex items-center justify-between">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          {{ course.title }}
        </h2>
        
        <div v-if="canEdit" class="flex items-center gap-2">
          <Link
            :href="route('courses.edit', course.id)"
            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors"
          >
            Editează
          </Link>
          
          <SecondaryButton
            v-if="course.status === 'draft'"
            @click="publishCourse"
            class="bg-green-600 hover:bg-green-700 text-white"
          >
            Publică
          </SecondaryButton>
          
          <SecondaryButton
            v-else-if="course.status === 'published'"
            @click="unpublishCourse"
            class="bg-yellow-600 hover:bg-yellow-700 text-white"
          >
            Retrage din publicare
          </SecondaryButton>
          
          <SecondaryButton
            @click="deleteCourse"
            class="bg-red-600 hover:bg-red-700 text-white"
          >
            Șterge
          </SecondaryButton>
        </div>
      </div>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Course Header -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden mb-8">
          <div class="aspect-video bg-gray-100 relative">
            <img
              v-if="course.thumbnail"
              :src="course.thumbnail"
              :alt="course.title"
              class="w-full h-full object-cover"
            >
            <div v-else class="w-full h-full flex items-center justify-center">
              <svg class="w-24 h-24 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
              </svg>
            </div>
          </div>

          <div class="p-8">
            <div class="flex items-center gap-4 mb-4">
              <span
                :class="{
                  'bg-green-100 text-green-800': course.status === 'published',
                  'bg-yellow-100 text-yellow-800': course.status === 'draft',
                  'bg-gray-100 text-gray-800': course.status === 'archived'
                }"
                class="px-3 py-1 text-sm font-medium rounded-full"
              >
                {{ statusLabels[course.status] }}
              </span>
              
              <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                {{ levelLabels[course.level] }}
              </span>
              
              <span
                :class="{
                  'bg-green-100 text-green-800': course.is_free,
                  'bg-blue-100 text-blue-800': !course.is_free
                }"
                class="px-3 py-1 text-sm font-medium rounded-full"
              >
                {{ course.formatted_price }}
              </span>
            </div>

            <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ course.title }}</h1>
            
            <p v-if="course.excerpt" class="text-lg text-gray-600 mb-6">
              {{ course.excerpt }}
            </p>

            <!-- Instructor -->
            <div class="flex items-center mb-6">
              <img
                :src="course.instructor.profile_photo_url"
                :alt="course.instructor.name"
                class="w-12 h-12 rounded-full"
              >
              <div class="ml-4">
                <p class="text-lg font-medium text-gray-900">
                  {{ course.instructor.display_name }}
                </p>
                <p class="text-sm text-gray-500">
                  {{ course.instructor.role_label }}
                </p>
              </div>
            </div>

            <!-- Stats -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
              <div class="text-center">
                <p class="text-2xl font-bold text-gray-900">{{ course.total_modules }}</p>
                <p class="text-sm text-gray-500">Module</p>
              </div>
              <div class="text-center">
                <p class="text-2xl font-bold text-gray-900">{{ course.duration_hours }}</p>
                <p class="text-sm text-gray-500">Ore</p>
              </div>
              <div class="text-center">
                <p class="text-2xl font-bold text-gray-900">{{ course.chapters?.length || 0 }}</p>
                <p class="text-sm text-gray-500">Capitole</p>
              </div>
              <div class="text-center">
                <p class="text-2xl font-bold text-gray-900">{{ course.max_students || '∞' }}</p>
                <p class="text-sm text-gray-500">Studenți max</p>
              </div>
            </div>

            <!-- Tags -->
            <div v-if="course.tags && course.tags.length > 0" class="flex flex-wrap gap-2 mb-6">
              <span
                v-for="tag in course.tags"
                :key="tag"
                class="px-3 py-1 bg-gray-100 text-gray-800 text-sm rounded-full"
              >
                {{ tag }}
              </span>
            </div>

            <!-- Description -->
            <div class="prose max-w-none">
              <div v-html="course.description"></div>
            </div>
          </div>
        </div>

        <!-- Course Content -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
          <!-- Chapters Sidebar -->
          <div class="lg:col-span-1">
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 sticky top-4">
              <h3 class="text-lg font-semibold text-gray-900 mb-4">Conținut curs</h3>
              
              <div v-if="course.chapters && course.chapters.length > 0" class="space-y-2">
                <div
                  v-for="chapter in course.chapters"
                  :key="chapter.id"
                  class="border border-gray-200 rounded-lg"
                >
                  <button
                    @click="activeChapter = activeChapter === chapter.id ? null : chapter.id"
                    class="w-full p-4 text-left hover:bg-gray-50 transition-colors"
                  >
                    <div class="flex items-center justify-between">
                      <div>
                        <h4 class="font-medium text-gray-900">{{ chapter.title }}</h4>
                        <p class="text-sm text-gray-500 mt-1">
                          {{ chapter.module_count }} module • {{ chapter.total_duration }} min
                        </p>
                      </div>
                      <svg
                        :class="{ 'rotate-180': activeChapter === chapter.id }"
                        class="w-5 h-5 text-gray-400 transition-transform"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                      >
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                      </svg>
                    </div>
                  </button>
                  
                  <!-- Modules -->
                  <div v-if="activeChapter === chapter.id && chapter.modules" class="border-t border-gray-200">
                    <div
                      v-for="module in chapter.modules"
                      :key="module.id"
                      class="p-3 hover:bg-gray-50 cursor-pointer"
                      @click="activeModule = module.id"
                    >
                      <div class="flex items-center gap-3">
                        <span class="text-lg">{{ moduleTypeIcons[module.type] }}</span>
                        <div class="flex-1">
                          <p class="text-sm font-medium text-gray-900">{{ module.title }}</p>
                          <p class="text-xs text-gray-500">{{ module.formatted_duration }}</p>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              
              <div v-else class="text-center py-8 text-gray-500">
                <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                </svg>
                <p>Nu există conținut încă</p>
              </div>
            </div>
          </div>

          <!-- Main Content -->
          <div class="lg:col-span-2">
            <!-- Requirements -->
            <div v-if="course.requirements && course.requirements.length > 0" class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
              <h3 class="text-lg font-semibold text-gray-900 mb-4">Cerințe</h3>
              <ul class="space-y-2">
                <li
                  v-for="requirement in course.requirements"
                  :key="requirement"
                  class="flex items-start gap-3"
                >
                  <svg class="w-5 h-5 text-green-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                  </svg>
                  <span class="text-gray-700">{{ requirement }}</span>
                </li>
              </ul>
            </div>

            <!-- Learning Outcomes -->
            <div v-if="course.learning_outcomes && course.learning_outcomes.length > 0" class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
              <h3 class="text-lg font-semibold text-gray-900 mb-4">Ce vei învăța</h3>
              <ul class="space-y-2">
                <li
                  v-for="outcome in course.learning_outcomes"
                  :key="outcome"
                  class="flex items-start gap-3"
                >
                  <svg class="w-5 h-5 text-blue-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                  </svg>
                  <span class="text-gray-700">{{ outcome }}</span>
                </li>
              </ul>
            </div>

            <!-- Module Content -->
            <div v-if="activeModule" class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
              <div v-if="course.chapters">
                <div v-for="chapter in course.chapters" :key="chapter.id">
                  <div v-for="module in chapter.modules" :key="module.id">
                    <div v-if="module.id === activeModule" class="space-y-4">
                      <div class="flex items-center gap-3 mb-4">
                        <span class="text-2xl">{{ moduleTypeIcons[module.type] }}</span>
                        <div>
                          <h3 class="text-xl font-semibold text-gray-900">{{ module.title }}</h3>
                          <p class="text-sm text-gray-500">{{ module.formatted_duration }}</p>
                        </div>
                      </div>

                      <!-- Module content based on type -->
                      <div v-if="module.type === 'text'" class="prose max-w-none">
                        <div v-html="module.content"></div>
                      </div>

                      <div v-else-if="module.type === 'video'" class="space-y-4">
                        <div class="aspect-video bg-gray-100 rounded-lg flex items-center justify-center">
                          <div class="text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h1m4 0h1m-6 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <p class="text-gray-500">Video: {{ module.video_url }}</p>
                          </div>
                        </div>
                        <div class="prose max-w-none">
                          <div v-html="module.content"></div>
                        </div>
                      </div>

                      <div v-else-if="module.type === 'file'" class="space-y-4">
                        <div class="border border-gray-200 rounded-lg p-4">
                          <div class="flex items-center gap-3">
                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <div>
                              <p class="font-medium text-gray-900">{{ module.title }}</p>
                              <p class="text-sm text-gray-500">Fișier atașat</p>
                            </div>
                            <a
                              v-if="module.file_url"
                              :href="module.file_url"
                              target="_blank"
                              class="ml-auto bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors"
                            >
                              Descarcă
                            </a>
                          </div>
                        </div>
                        <div class="prose max-w-none">
                          <div v-html="module.content"></div>
                        </div>
                      </div>

                      <div v-else class="text-center py-12 text-gray-500">
                        <p>Tip de modul: {{ module.type }}</p>
                        <p class="text-sm mt-2">Conținutul va fi afișat aici</p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- No module selected -->
            <div v-else class="bg-white rounded-lg shadow-sm border border-gray-200 p-12 text-center">
              <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
              </svg>
              <h3 class="text-lg font-medium text-gray-900 mb-2">Selectează un modul</h3>
              <p class="text-gray-500">Alege un modul din lista din dreapta pentru a începe să înveți</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AppLayout>
</template> 