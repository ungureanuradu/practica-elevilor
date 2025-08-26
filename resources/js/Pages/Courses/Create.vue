<script setup>
import { ref } from 'vue'
import { Head, useForm } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'
import InputError from '@/Components/InputError.vue'
import InputLabel from '@/Components/InputLabel.vue'
import TextInput from '@/Components/TextInput.vue'
import PrimaryButton from '@/Components/PrimaryButton.vue'

const form = useForm({
  title: '',
  description: '',
  excerpt: '',
  level: 'beginner',
  duration_hours: 0,
  max_students: null,
  price: 0,
  is_free: true,
  tags: [],
  requirements: [],
  learning_outcomes: [],
  thumbnail: null,
})

const levels = [
  { value: 'beginner', label: 'Începător' },
  { value: 'intermediate', label: 'Intermediar' },
  { value: 'advanced', label: 'Avansat' },
]

const handleSubmit = () => {
  form.post(route('courses.store'), {
    onSuccess: () => {
      form.reset()
    },
  })
}

const handleFileChange = (event) => {
  form.thumbnail = event.target.files[0]
}
</script>

<template>
  <Head title="Creează curs" />

  <AppLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Creează curs nou
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
          <form @submit.prevent="handleSubmit" class="p-6">
            <!-- Basic Information -->
            <div class="mb-8">
              <h3 class="text-lg font-medium text-gray-900 mb-4">Informații de bază</h3>
              
              <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Title -->
                <div class="md:col-span-2">
                  <InputLabel for="title" value="Titlu curs" />
                  <TextInput
                    id="title"
                    v-model="form.title"
                    type="text"
                    class="mt-1 block w-full"
                    required
                  />
                  <InputError :message="form.errors.title" class="mt-2" />
                </div>

                <!-- Description -->
                <div class="md:col-span-2">
                  <InputLabel for="description" value="Descriere" />
                  <textarea
                    id="description"
                    v-model="form.description"
                    rows="4"
                    class="mt-1 block w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm"
                    required
                  ></textarea>
                  <InputError :message="form.errors.description" class="mt-2" />
                </div>

                <!-- Excerpt -->
                <div class="md:col-span-2">
                  <InputLabel for="excerpt" value="Rezumat (opțional)" />
                  <textarea
                    id="excerpt"
                    v-model="form.excerpt"
                    rows="3"
                    class="mt-1 block w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm"
                    placeholder="Un scurt rezumat al cursului..."
                  ></textarea>
                  <InputError :message="form.errors.excerpt" class="mt-2" />
                </div>

                <!-- Level -->
                <div>
                  <InputLabel for="level" value="Nivel" />
                  <select
                    id="level"
                    v-model="form.level"
                    class="mt-1 block w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm"
                  >
                    <option v-for="level in levels" :key="level.value" :value="level.value">
                      {{ level.label }}
                    </option>
                  </select>
                  <InputError :message="form.errors.level" class="mt-2" />
                </div>

                <!-- Duration -->
                <div>
                  <InputLabel for="duration_hours" value="Durată (ore)" />
                  <TextInput
                    id="duration_hours"
                    v-model="form.duration_hours"
                    type="number"
                    min="0"
                    class="mt-1 block w-full"
                  />
                  <InputError :message="form.errors.duration_hours" class="mt-2" />
                </div>

                <!-- Max Students -->
                <div>
                  <InputLabel for="max_students" value="Număr maxim studenți (opțional)" />
                  <TextInput
                    id="max_students"
                    v-model="form.max_students"
                    type="number"
                    min="1"
                    class="mt-1 block w-full"
                  />
                  <InputError :message="form.errors.max_students" class="mt-2" />
                </div>

                <!-- Thumbnail -->
                <div>
                  <InputLabel for="thumbnail" value="Imagine curs (opțional)" />
                  <input
                    id="thumbnail"
                    type="file"
                    accept="image/*"
                    @change="handleFileChange"
                    class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                  />
                  <InputError :message="form.errors.thumbnail" class="mt-2" />
                </div>
              </div>
            </div>

            <!-- Pricing -->
            <div class="mb-8">
              <h3 class="text-lg font-medium text-gray-900 mb-4">Preț</h3>
              
              <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Is Free -->
                <div class="flex items-center">
                  <input
                    id="is_free"
                    v-model="form.is_free"
                    type="checkbox"
                    class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                  >
                  <InputLabel for="is_free" value="Curs gratuit" class="ml-2" />
                </div>

                <!-- Price -->
                <div v-if="!form.is_free">
                  <InputLabel for="price" value="Preț (RON)" />
                  <TextInput
                    id="price"
                    v-model="form.price"
                    type="number"
                    min="0"
                    step="0.01"
                    class="mt-1 block w-full"
                  />
                  <InputError :message="form.errors.price" class="mt-2" />
                </div>
              </div>
            </div>

            <!-- Tags -->
            <div class="mb-8">
              <h3 class="text-lg font-medium text-gray-900 mb-4">Tag-uri (opțional)</h3>
              <div class="flex flex-wrap gap-2">
                <span
                  v-for="tag in ['PHP', 'Laravel', 'Vue.js', 'JavaScript', 'CSS', 'HTML', 'Database', 'API']"
                  :key="tag"
                  @click="form.tags.includes(tag) ? form.tags = form.tags.filter(t => t !== tag) : form.tags.push(tag)"
                  :class="{
                    'bg-blue-100 text-blue-800': form.tags.includes(tag),
                    'bg-gray-100 text-gray-800': !form.tags.includes(tag)
                  }"
                  class="px-3 py-1 rounded-full text-sm cursor-pointer hover:opacity-80 transition-opacity"
                >
                  {{ tag }}
                </span>
              </div>
              <InputError :message="form.errors.tags" class="mt-2" />
            </div>

            <!-- Requirements -->
            <div class="mb-8">
              <h3 class="text-lg font-medium text-gray-900 mb-4">Cerințe (opțional)</h3>
              <div class="space-y-2">
                <div
                  v-for="(requirement, index) in form.requirements"
                  :key="index"
                  class="flex items-center gap-2"
                >
                  <TextInput
                    v-model="form.requirements[index]"
                    type="text"
                    class="flex-1"
                    placeholder="Ex: Cunoștințe de bază în HTML"
                  >
                    <button
                      type="button"
                      @click="form.requirements.splice(index, 1)"
                      class="text-red-600 hover:text-red-800"
                    >
                      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                      </svg>
                    </button>
                  </TextInput>
                </div>
                <button
                  type="button"
                  @click="form.requirements.push('')"
                  class="text-blue-600 hover:text-blue-800 text-sm"
                >
                  + Adaugă cerință
                </button>
              </div>
              <InputError :message="form.errors.requirements" class="mt-2" />
            </div>

            <!-- Learning Outcomes -->
            <div class="mb-8">
              <h3 class="text-lg font-medium text-gray-900 mb-4">Rezultate învățare (opțional)</h3>
              <div class="space-y-2">
                <div
                  v-for="(outcome, index) in form.learning_outcomes"
                  :key="index"
                  class="flex items-center gap-2"
                >
                  <TextInput
                    v-model="form.learning_outcomes[index]"
                    type="text"
                    class="flex-1"
                    placeholder="Ex: Vei învăța să construiești aplicații web moderne"
                  >
                    <button
                      type="button"
                      @click="form.learning_outcomes.splice(index, 1)"
                      class="text-red-600 hover:text-red-800"
                    >
                      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                      </svg>
                    </button>
                  </TextInput>
                </div>
                <button
                  type="button"
                  @click="form.learning_outcomes.push('')"
                  class="text-blue-600 hover:text-blue-800 text-sm"
                >
                  + Adaugă rezultat
                </button>
              </div>
              <InputError :message="form.errors.learning_outcomes" class="mt-2" />
            </div>

            <!-- Submit -->
            <div class="flex items-center justify-end gap-4">
              <Link
                :href="route('courses.index')"
                class="text-gray-600 hover:text-gray-800"
              >
                Anulează
              </Link>
              <PrimaryButton
                :class="{ 'opacity-25': form.processing }"
                :disabled="form.processing"
              >
                Creează curs
              </PrimaryButton>
            </div>
          </form>
        </div>
      </div>
    </div>
  </AppLayout>
</template> 