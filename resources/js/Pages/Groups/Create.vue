<template>
  <AppLayout title="Creează Grup">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Creează Grup Nou
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
          <form @submit.prevent="submit" class="p-6 space-y-6">
            <!-- Basic Information -->
            <div>
              <h3 class="text-lg font-medium text-gray-900 mb-4">
                Informații de Bază
              </h3>
              
              <div class="grid grid-cols-1 gap-6">
                <!-- Group Name -->
                <div>
                  <InputLabel for="name" value="Numele Grupului" />
                  <TextInput
                    id="name"
                    v-model="form.name"
                    type="text"
                    class="mt-1 block w-full"
                    required
                    autofocus
                    placeholder="Ex: Programatori PHP"
                  />
                  <InputError :message="form.errors.name" class="mt-2" />
                </div>

                <!-- Description -->
                <div>
                  <InputLabel for="description" value="Descriere" />
                  <textarea
                    id="description"
                    v-model="form.description"
                    rows="4"
                    class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                    placeholder="Descrie scopul și activitățile grupului..."
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

            <!-- Group Settings -->
            <div>
              <h3 class="text-lg font-medium text-gray-900 mb-4">
                Setări Grup
              </h3>
              
              <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Category -->
                <div>
                  <InputLabel for="category" value="Categorie" />
                  <select
                    id="category"
                    v-model="form.category"
                    class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                    required
                  >
                    <option value="">Selectează o categorie</option>
                    <option
                      v-for="(label, value) in categories"
                      :key="value"
                      :value="value"
                    >
                      {{ label }}
                    </option>
                  </select>
                  <InputError :message="form.errors.category" class="mt-2" />
                </div>

                <!-- Type -->
                <div>
                  <InputLabel for="type" value="Tip Grup" />
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

                <!-- Max Members -->
                <div>
                  <InputLabel for="max_members" value="Număr Maxim de Membri" />
                  <TextInput
                    id="max_members"
                    v-model="form.max_members"
                    type="number"
                    class="mt-1 block w-full"
                    min="1"
                    max="1000"
                    placeholder="Lăsă gol pentru nelimitat"
                  />
                  <p class="text-sm text-gray-500 mt-1">
                    Lăsă gol pentru a permite un număr nelimitat de membri
                  </p>
                  <InputError :message="form.errors.max_members" class="mt-2" />
                </div>

                <!-- Requires Approval -->
                <div>
                  <div class="flex items-center">
                    <input
                      id="requires_approval"
                      v-model="form.requires_approval"
                      type="checkbox"
                      class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
                    />
                    <InputLabel for="requires_approval" value="Necesită Aprobare" class="ml-2" />
                  </div>
                  <p class="text-sm text-gray-500 mt-1">
                    Membrii noi vor trebui aprobați înainte de a adera
                  </p>
                  <InputError :message="form.errors.requires_approval" class="mt-2" />
                </div>
              </div>
            </div>

            <!-- Tags -->
            <div>
              <h3 class="text-lg font-medium text-gray-900 mb-4">
                Etichete (Tags)
              </h3>
              
              <div>
                <InputLabel for="tags" value="Etichete" />
                <div class="mt-1">
                  <div class="flex flex-wrap gap-2 mb-2">
                    <span
                      v-for="(tag, index) in form.tags"
                      :key="index"
                      class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800"
                    >
                      {{ tag }}
                      <button
                        type="button"
                        @click="removeTag(index)"
                        class="ml-2 text-blue-600 hover:text-blue-800"
                      >
                        <i class="fas fa-times"></i>
                      </button>
                    </span>
                  </div>
                  <div class="flex gap-2">
                    <TextInput
                      v-model="newTag"
                      type="text"
                      class="flex-1"
                      placeholder="Adaugă o etichetă..."
                      @keydown.enter.prevent="addTag"
                    />
                    <button
                      type="button"
                      @click="addTag"
                      class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700"
                    >
                      Adaugă
                    </button>
                  </div>
                </div>
                <InputError :message="form.errors.tags" class="mt-2" />
              </div>
            </div>

            <!-- Images -->
            <div>
              <h3 class="text-lg font-medium text-gray-900 mb-4">
                Imagini
              </h3>
              
              <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Avatar -->
                <div>
                  <InputLabel for="avatar" value="Avatar Grup" />
                  <input
                    id="avatar"
                    ref="avatarInput"
                    type="file"
                    @change="handleAvatarChange"
                    accept="image/*"
                    class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                  />
                  <p class="text-sm text-gray-500 mt-1">
                    Imagine pătrată, recomandat 200x200px
                  </p>
                  <InputError :message="form.errors.avatar" class="mt-2" />
                </div>

                <!-- Cover Image -->
                <div>
                  <InputLabel for="cover_image" value="Imagine de Copertă" />
                  <input
                    id="cover_image"
                    ref="coverInput"
                    type="file"
                    @change="handleCoverChange"
                    accept="image/*"
                    class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                  />
                  <p class="text-sm text-gray-500 mt-1">
                    Imagine de fundal, recomandat 1200x400px
                  </p>
                  <InputError :message="form.errors.cover_image" class="mt-2" />
                </div>
              </div>
            </div>

            <!-- Submit Buttons -->
            <div class="flex items-center justify-end gap-4 pt-6 border-t border-gray-200">
              <Link
                :href="route('groups.index')"
                class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
              >
                Anulează
              </Link>
              <PrimaryButton
                :class="{ 'opacity-25': form.processing }"
                :disabled="form.processing"
              >
                <i class="fas fa-save mr-2"></i>
                Creează Grupul
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
    categories: Object,
    types: Object,
  },
  data() {
    return {
      newTag: '',
    }
  },
  setup() {
    const form = useForm({
      name: '',
      description: '',
      excerpt: '',
      category: '',
      type: '',
      tags: [],
      max_members: '',
      requires_approval: false,
      avatar: null,
      cover_image: null,
    })

    return { form }
  },
  methods: {
    submit() {
      this.form.post(route('groups.store'), {
        onSuccess: () => {
          // Form will be reset automatically
        },
      })
    },
    addTag() {
      if (this.newTag.trim() && !this.form.tags.includes(this.newTag.trim())) {
        this.form.tags.push(this.newTag.trim())
        this.newTag = ''
      }
    },
    removeTag(index) {
      this.form.tags.splice(index, 1)
    },
    handleAvatarChange(event) {
      this.form.avatar = event.target.files[0]
    },
    handleCoverChange(event) {
      this.form.cover_image = event.target.files[0]
    },
  },
})
</script> 