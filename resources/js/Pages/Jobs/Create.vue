<template>
  <AppLayout title="Creează Job Nou">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Creează Job Nou
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-8">
          <form @submit.prevent="submitForm">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <!-- Job Title -->
              <div class="md:col-span-2">
                <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                  Titlul Jobului *
                </label>
                <input
                  id="title"
                  v-model="form.title"
                  type="text"
                  required
                  class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                  placeholder="ex: Dezvoltator Frontend React"
                />
                <div v-if="errors.title" class="text-red-600 text-sm mt-1">{{ errors.title }}</div>
              </div>

              <!-- Job Type -->
              <div>
                <label for="type" class="block text-sm font-medium text-gray-700 mb-2">
                  Tipul Jobului *
                </label>
                <select
                  id="type"
                  v-model="form.type"
                  required
                  class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                >
                  <option value="">Selectează tipul</option>
                  <option value="full-time">Full-time</option>
                  <option value="part-time">Part-time</option>
                  <option value="internship">Internship</option>
                  <option value="mentorship">Mentorship</option>
                  <option value="freelance">Freelance</option>
                </select>
                <div v-if="errors.type" class="text-red-600 text-sm mt-1">{{ errors.type }}</div>
              </div>

              <!-- Experience Level -->
              <div>
                <label for="level" class="block text-sm font-medium text-gray-700 mb-2">
                  Nivelul de Experiență *
                </label>
                <select
                  id="level"
                  v-model="form.level"
                  required
                  class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                >
                  <option value="">Selectează nivelul</option>
                  <option value="entry">Entry Level</option>
                  <option value="junior">Junior</option>
                  <option value="mid">Mid Level</option>
                  <option value="senior">Senior</option>
                </select>
                <div v-if="errors.level" class="text-red-600 text-sm mt-1">{{ errors.level }}</div>
              </div>

              <!-- Location -->
              <div>
                <label for="location" class="block text-sm font-medium text-gray-700 mb-2">
                  Locația
                </label>
                <input
                  id="location"
                  v-model="form.location"
                  type="text"
                  class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                  placeholder="ex: București, România"
                />
                <div v-if="errors.location" class="text-red-600 text-sm mt-1">{{ errors.location }}</div>
              </div>

              <!-- Remote Options -->
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                  Opțiuni de Lucru
                </label>
                <div class="space-y-2">
                  <label class="flex items-center">
                    <input
                      v-model="form.remote_ok"
                      type="checkbox"
                      class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                    />
                    <span class="ml-2 text-sm text-gray-700">Remote OK</span>
                  </label>
                  <label class="flex items-center">
                    <input
                      v-model="form.hybrid_ok"
                      type="checkbox"
                      class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                    />
                    <span class="ml-2 text-sm text-gray-700">Hybrid OK</span>
                  </label>
                </div>
              </div>

              <!-- Salary Range -->
              <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                  Salariul
                </label>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                  <div>
                    <label for="salary_min" class="block text-sm text-gray-600 mb-1">Salariu minim</label>
                    <input
                      id="salary_min"
                      v-model="form.salary_min"
                      type="number"
                      min="0"
                      class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                      placeholder="3000"
                    />
                  </div>
                  <div>
                    <label for="salary_max" class="block text-sm text-gray-600 mb-1">Salariu maxim</label>
                    <input
                      id="salary_max"
                      v-model="form.salary_max"
                      type="number"
                      min="0"
                      class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                      placeholder="5000"
                    />
                  </div>
                  <div>
                    <label for="salary_currency" class="block text-sm text-gray-600 mb-1">Moneda</label>
                    <select
                      id="salary_currency"
                      v-model="form.salary_currency"
                      class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                    >
                      <option value="RON">RON</option>
                      <option value="EUR">EUR</option>
                      <option value="USD">USD</option>
                    </select>
                  </div>
                </div>
                <div class="mt-2">
                  <label class="flex items-center">
                    <input
                      v-model="form.salary_negotiable"
                      type="checkbox"
                      class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                    />
                    <span class="ml-2 text-sm text-gray-700">Salariu negociabil</span>
                  </label>
                </div>
              </div>

              <!-- Job Description -->
              <div class="md:col-span-2">
                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                  Descrierea Jobului *
                </label>
                <textarea
                  id="description"
                  v-model="form.description"
                  required
                  rows="6"
                  class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                  placeholder="Descrie responsabilitățile și activitățile pentru acest job..."
                ></textarea>
                <div v-if="errors.description" class="text-red-600 text-sm mt-1">{{ errors.description }}</div>
              </div>

              <!-- Requirements -->
              <div class="md:col-span-2">
                <label for="requirements" class="block text-sm font-medium text-gray-700 mb-2">
                  Cerințe
                </label>
                <textarea
                  id="requirements"
                  v-model="form.requirements"
                  rows="4"
                  class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                  placeholder="Listează cerințele pentru acest job..."
                ></textarea>
                <div v-if="errors.requirements" class="text-red-600 text-sm mt-1">{{ errors.requirements }}</div>
              </div>

              <!-- Benefits -->
              <div class="md:col-span-2">
                <label for="benefits" class="block text-sm font-medium text-gray-700 mb-2">
                  Beneficii
                </label>
                <textarea
                  id="benefits"
                  v-model="form.benefits"
                  rows="4"
                  class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                  placeholder="Descrie beneficiile oferite..."
                ></textarea>
                <div v-if="errors.benefits" class="text-red-600 text-sm mt-1">{{ errors.benefits }}</div>
              </div>

              <!-- Positions Available -->
              <div>
                <label for="positions_available" class="block text-sm font-medium text-gray-700 mb-2">
                  Numărul de Poziții *
                </label>
                <input
                  id="positions_available"
                  v-model="form.positions_available"
                  type="number"
                  min="1"
                  required
                  class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                  placeholder="1"
                />
                <div v-if="errors.positions_available" class="text-red-600 text-sm mt-1">{{ errors.positions_available }}</div>
              </div>

              <!-- Application Deadline -->
              <div>
                <label for="application_deadline" class="block text-sm font-medium text-gray-700 mb-2">
                  Termenul Limită de Aplicare
                </label>
                <input
                  id="application_deadline"
                  v-model="form.application_deadline"
                  type="date"
                  class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                />
                <div v-if="errors.application_deadline" class="text-red-600 text-sm mt-1">{{ errors.application_deadline }}</div>
              </div>

              <!-- Contact Information -->
              <div class="md:col-span-2">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Informații de Contact</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                  <div>
                    <label for="contact_email" class="block text-sm font-medium text-gray-700 mb-2">
                      Email de Contact
                    </label>
                    <input
                      id="contact_email"
                      v-model="form.contact_email"
                      type="email"
                      class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                      placeholder="hr@companie.ro"
                    />
                    <div v-if="errors.contact_email" class="text-red-600 text-sm mt-1">{{ errors.contact_email }}</div>
                  </div>
                  <div>
                    <label for="contact_phone" class="block text-sm font-medium text-gray-700 mb-2">
                      Telefon de Contact
                    </label>
                    <input
                      id="contact_phone"
                      v-model="form.contact_phone"
                      type="tel"
                      class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                      placeholder="+40 123 456 789"
                    />
                    <div v-if="errors.contact_phone" class="text-red-600 text-sm mt-1">{{ errors.contact_phone }}</div>
                  </div>
                </div>
              </div>

              <!-- Application Instructions -->
              <div class="md:col-span-2">
                <label for="application_instructions" class="block text-sm font-medium text-gray-700 mb-2">
                  Instrucțiuni pentru Aplicare
                </label>
                <textarea
                  id="application_instructions"
                  v-model="form.application_instructions"
                  rows="3"
                  class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                  placeholder="Instrucțiuni speciale pentru candidați..."
                ></textarea>
                <div v-if="errors.application_instructions" class="text-red-600 text-sm mt-1">{{ errors.application_instructions }}</div>
              </div>
            </div>

            <!-- Submit Buttons -->
            <div class="flex justify-end space-x-4 mt-8">
              <Link
                :href="route('company.jobs.index')"
                class="px-6 py-2 border border-gray-300 rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
              >
                Anulează
              </Link>
              <button
                type="submit"
                :disabled="processing"
                class="px-6 py-2 bg-indigo-600 border border-transparent rounded-md text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-50"
              >
                {{ processing ? 'Se creează...' : 'Creează Job' }}
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import { ref } from 'vue'
import { Link, useForm } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'

const form = useForm({
  title: '',
  description: '',
  requirements: '',
  benefits: '',
  type: '',
  level: '',
  location: '',
  remote_ok: false,
  hybrid_ok: false,
  salary_min: null,
  salary_max: null,
  salary_currency: 'RON',
  salary_negotiable: false,
  positions_available: 1,
  application_deadline: null,
  contact_email: '',
  contact_phone: '',
  application_instructions: '',
})

const submitForm = () => {
  form.post(route('company.jobs.store'))
}

defineProps({
  errors: Object,
})
</script>
