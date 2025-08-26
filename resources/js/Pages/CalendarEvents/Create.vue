<template>
  <AppLayout title="Creează Eveniment">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Creează Eveniment Nou
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
          <form @submit.prevent="submit" class="p-6 space-y-6">
            <!-- Basic Information -->
            <div>
              <h3 class="text-lg font-medium text-gray-900 mb-4">
                Informații de Bază
              </h3>
              
              <div class="grid grid-cols-1 gap-6">
                <!-- Event Title -->
                <div>
                  <InputLabel for="title" value="Titlul Evenimentului" />
                  <TextInput
                    id="title"
                    v-model="form.title"
                    type="text"
                    class="mt-1 block w-full"
                    required
                    autofocus
                    placeholder="Ex: Workshop Laravel pentru Începători"
                  />
                  <InputError :message="form.errors.title" class="mt-2" />
                </div>

                <!-- Description -->
                <div>
                  <InputLabel for="description" value="Descriere" />
                  <textarea
                    id="description"
                    v-model="form.description"
                    rows="4"
                    class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                    placeholder="Descrie evenimentul în detaliu..."
                  ></textarea>
                  <InputError :message="form.errors.description" class="mt-2" />
                </div>

                <!-- Excerpt -->
                <div>
                  <InputLabel for="excerpt" value="Scurtă Descriere" />
                  <TextInput
                    id="excerpt"
                    v-model="form.excerpt"
                    type="text"
                    class="mt-1 block w-full"
                    placeholder="O scurtă descriere pentru afișare în listă"
                  />
                  <InputError :message="form.errors.excerpt" class="mt-2" />
                </div>
              </div>
            </div>

            <!-- Event Details -->
            <div>
              <h3 class="text-lg font-medium text-gray-900 mb-4">
                Detalii Eveniment
              </h3>
              
              <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Category -->
                <div>
                  <InputLabel for="category_id" value="Categorie" />
                  <select
                    id="category_id"
                    v-model="form.category_id"
                    class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                    required
                  >
                    <option value="">Selectează o categorie</option>
                    <option
                      v-for="category in categories"
                      :key="category.id"
                      :value="category.id"
                    >
                      {{ category.name }}
                    </option>
                  </select>
                  <InputError :message="form.errors.category_id" class="mt-2" />
                </div>

                <!-- Event Type -->
                <div>
                  <InputLabel for="type" value="Tip Eveniment" />
                  <select
                    id="type"
                    v-model="form.type"
                    class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                    required
                  >
                    <option value="">Selectează tipul</option>
                    <option
                      v-for="(label, value) in types"
                      :key="value"
                      :value="value"
                    >
                      {{ label }}
                    </option>
                  </select>
                  <InputError :message="form.errors.type" class="mt-2" />
                </div>

                <!-- Location -->
                <div>
                  <InputLabel for="location" value="Locație" />
                  <TextInput
                    id="location"
                    v-model="form.location"
                    type="text"
                    class="mt-1 block w-full"
                    placeholder="Ex: Sala 101, Liceul Tehnologic"
                  />
                  <InputError :message="form.errors.location" class="mt-2" />
                </div>

                <!-- URL -->
                <div>
                  <InputLabel for="url" value="URL (pentru evenimente online)" />
                  <TextInput
                    id="url"
                    v-model="form.url"
                    type="url"
                    class="mt-1 block w-full"
                    placeholder="https://meet.google.com/..."
                  />
                  <InputError :message="form.errors.url" class="mt-2" />
                </div>
              </div>
            </div>

            <!-- Date and Time -->
            <div>
              <h3 class="text-lg font-medium text-gray-900 mb-4">
                Data și Ora
              </h3>
              
              <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Start Date -->
                <div>
                  <InputLabel for="start_date" value="Data de Început" />
                  <TextInput
                    id="start_date"
                    v-model="form.start_date"
                    type="datetime-local"
                    class="mt-1 block w-full"
                    required
                  />
                  <InputError :message="form.errors.start_date" class="mt-2" />
                </div>

                <!-- End Date -->
                <div>
                  <InputLabel for="end_date" value="Data de Sfârșit" />
                  <TextInput
                    id="end_date"
                    v-model="form.end_date"
                    type="datetime-local"
                    class="mt-1 block w-full"
                    required
                  />
                  <InputError :message="form.errors.end_date" class="mt-2" />
                </div>
              </div>
            </div>

            <!-- Event Settings -->
            <div>
              <h3 class="text-lg font-medium text-gray-900 mb-4">
                Setări Eveniment
              </h3>
              
              <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Access Level -->
                <div>
                  <InputLabel for="access_level" value="Nivel de Acces" />
                  <select
                    id="access_level"
                    v-model="form.access_level"
                    class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                    required
                  >
                    <option value="public">Public</option>
                    <option value="students">Studenți</option>
                    <option value="teachers">Profesori</option>
                    <option value="authenticated">Autentificați</option>
                  </select>
                  <InputError :message="form.errors.access_level" class="mt-2" />
                </div>

                <!-- Status -->
                <div>
                  <InputLabel for="status" value="Status" />
                  <select
                    id="status"
                    v-model="form.status"
                    class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                    required
                  >
                    <option value="draft">Ciornă</option>
                    <option value="published">Publicat</option>
                  </select>
                  <InputError :message="form.errors.status" class="mt-2" />
                </div>

                <!-- Featured -->
                <div>
                  <div class="flex items-center">
                    <input
                      id="is_featured"
                      v-model="form.is_featured"
                      type="checkbox"
                      class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
                    />
                    <InputLabel for="is_featured" value="Eveniment Recomandat" class="ml-2" />
                  </div>
                  <p class="text-sm text-gray-500 mt-1">
                    Evenimentele recomandate apar în evidență
                  </p>
                  <InputError :message="form.errors.is_featured" class="mt-2" />
                </div>

                <!-- Requires Registration -->
                <div>
                  <div class="flex items-center">
                    <input
                      id="requires_registration"
                      v-model="form.requires_registration"
                      type="checkbox"
                      class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
                    />
                    <InputLabel for="requires_registration" value="Necesită Înregistrare" class="ml-2" />
                  </div>
                  <p class="text-sm text-gray-500 mt-1">
                    Participanții trebuie să se înregistreze
                  </p>
                  <InputError :message="form.errors.requires_registration" class="mt-2" />
                </div>
              </div>

              <!-- Max Participants -->
              <div v-if="form.requires_registration" class="mt-4">
                <InputLabel for="max_participants" value="Număr Maxim de Participanți" />
                <TextInput
                  id="max_participants"
                  v-model="form.max_participants"
                  type="number"
                  class="mt-1 block w-full"
                  min="1"
                  max="1000"
                  placeholder="Lăsă gol pentru nelimitat"
                />
                <p class="text-sm text-gray-500 mt-1">
                  Lăsă gol pentru a permite un număr nelimitat de participanți
                </p>
                <InputError :message="form.errors.max_participants" class="mt-2" />
              </div>
            </div>

            <!-- Additional Information -->
            <div>
              <h3 class="text-lg font-medium text-gray-900 mb-4">
                Informații Suplimentare
              </h3>
              
              <div class="grid grid-cols-1 gap-6">
                <!-- Application Instructions -->
                <div v-if="form.requires_registration">
                  <InputLabel for="application_instructions" value="Instrucțiuni de Înregistrare" />
                  <textarea
                    id="application_instructions"
                    v-model="form.application_instructions"
                    rows="3"
                    class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                    placeholder="Instrucțiuni pentru participanți..."
                  ></textarea>
                  <InputError :message="form.errors.application_instructions" class="mt-2" />
                </div>

                <!-- Reminders -->
                <div>
                  <InputLabel for="reminders" value="Reminder-uri" />
                  <div class="mt-2 space-y-2">
                    <div class="flex items-center">
                      <input
                        id="reminder_1_day"
                        v-model="form.reminders"
                        type="checkbox"
                        value="1_day"
                        class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
                      />
                      <label for="reminder_1_day" class="ml-2 text-sm text-gray-700">
                        Reminder cu 1 zi înainte
                      </label>
                    </div>
                    <div class="flex items-center">
                      <input
                        id="reminder_1_hour"
                        v-model="form.reminders"
                        type="checkbox"
                        value="1_hour"
                        class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
                      />
                      <label for="reminder_1_hour" class="ml-2 text-sm text-gray-700">
                        Reminder cu 1 oră înainte
                      </label>
                    </div>
                    <div class="flex items-center">
                      <input
                        id="reminder_15_min"
                        v-model="form.reminders"
                        type="checkbox"
                        value="15_min"
                        class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
                      />
                      <label for="reminder_15_min" class="ml-2 text-sm text-gray-700">
                        Reminder cu 15 minute înainte
                      </label>
                    </div>
                  </div>
                  <InputError :message="form.errors.reminders" class="mt-2" />
                </div>
              </div>
            </div>

            <!-- Submit Buttons -->
            <div class="flex items-center justify-end gap-4 pt-6 border-t border-gray-200">
              <Link
                :href="route('calendar.index')"
                class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
              >
                Anulează
              </Link>
              <PrimaryButton
                :class="{ 'opacity-25': form.processing }"
                :disabled="form.processing"
              >
                <i class="fas fa-save mr-2"></i>
                Creează Evenimentul
              </PrimaryButton>
            </div>
          </form>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script>
import { defineComponent } from 'vue'
import { useForm, Link } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'
import InputError from '@/Components/InputError.vue'
import InputLabel from '@/Components/InputLabel.vue'
import PrimaryButton from '@/Components/PrimaryButton.vue'
import TextInput from '@/Components/TextInput.vue'

export default defineComponent({
  components: {
    AppLayout,
    InputError,
    InputLabel,
    PrimaryButton,
    TextInput,
    Link,
  },
  props: {
    categories: Array,
    types: Object,
  },
  setup() {
    const form = useForm({
      title: '',
      description: '',
      excerpt: '',
      category_id: '',
      type: '',
      location: '',
      url: '',
      start_date: '',
      end_date: '',
      access_level: 'public',
      status: 'draft',
      is_featured: false,
      requires_registration: false,
      max_participants: '',
      application_instructions: '',
      reminders: [],
    })

    return { form }
  },
  methods: {
    submit() {
      this.form.post(route('calendar-events.store'), {
        onSuccess: () => {
          // Form will be reset automatically
        },
      })
    },
  },
})
</script> 