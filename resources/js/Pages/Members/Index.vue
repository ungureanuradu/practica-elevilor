<template>
  <AppLayout title="Membri">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Membri
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Header Section -->
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6 mb-6">
          <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
              <h3 class="text-lg font-medium text-gray-900">Comunitatea Noastră</h3>
              <p class="text-sm text-gray-600 mt-1">
                Descoperă și conectează-te cu alți membri ai comunității
              </p>
            </div>
            <div class="flex gap-3">
              <Link
                v-if="$page.props.auth.user"
                :href="route('profile.show')"
                class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
              >
                <i class="fas fa-user-edit mr-2"></i>
                Editează Profilul
              </Link>
            </div>
          </div>
        </div>

        <!-- Stats Section -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
          <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
            <div class="flex items-center">
              <div class="flex-shrink-0">
                <i class="fas fa-users text-2xl text-blue-500"></i>
              </div>
              <div class="ml-4">
                <p class="text-sm font-medium text-gray-500">Total Membri</p>
                <p class="text-2xl font-semibold text-gray-900">{{ stats.total || 0 }}</p>
              </div>
            </div>
          </div>

          <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
            <div class="flex items-center">
              <div class="flex-shrink-0">
                <i class="fas fa-graduation-cap text-2xl text-green-500"></i>
              </div>
              <div class="ml-4">
                <p class="text-sm font-medium text-gray-500">Studenți</p>
                <p class="text-2xl font-semibold text-gray-900">{{ stats.students || 0 }}</p>
              </div>
            </div>
          </div>

          <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
            <div class="flex items-center">
              <div class="flex-shrink-0">
                <i class="fas fa-chalkboard-teacher text-2xl text-purple-500"></i>
              </div>
              <div class="ml-4">
                <p class="text-sm font-medium text-gray-500">Profesori</p>
                <p class="text-2xl font-semibold text-gray-900">{{ stats.teachers || 0 }}</p>
              </div>
            </div>
          </div>

          <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
            <div class="flex items-center">
              <div class="flex-shrink-0">
                <i class="fas fa-building text-2xl text-orange-500"></i>
              </div>
              <div class="ml-4">
                <p class="text-sm font-medium text-gray-500">Companii</p>
                <p class="text-2xl font-semibold text-gray-900">{{ stats.companies || 0 }}</p>
              </div>
            </div>
          </div>
        </div>

        <!-- Filters Section -->
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6 mb-6">
          <form @submit.prevent="applyFilters" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
              <!-- Search -->
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                  Caută
                </label>
                <input
                  v-model="filters.search"
                  type="text"
                  placeholder="Caută membri..."
                  class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                />
              </div>

              <!-- Role Filter -->
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                  Rol
                </label>
                <select
                  v-model="filters.role"
                  class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                >
                  <option value="">Toate rolurile</option>
                  <option value="student">Studenți</option>
                  <option value="teacher">Profesori</option>
                  <option value="company">Companii</option>
                </select>
              </div>

              <!-- Department Filter (for teachers) -->
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                  Departament
                </label>
                <select
                  v-model="filters.department"
                  class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                >
                  <option value="">Toate departamentele</option>
                  <option value="Informatică">Informatică</option>
                  <option value="Matematică">Matematică</option>
                  <option value="Fizică">Fizică</option>
                  <option value="Chimie">Chimie</option>
                  <option value="Biologie">Biologie</option>
                  <option value="Istorie">Istorie</option>
                  <option value="Geografie">Geografie</option>
                  <option value="Limbi Străine">Limbi Străine</option>
                  <option value="Română">Română</option>
                </select>
              </div>

              <!-- Sort -->
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                  Sortează
                </label>
                <select
                  v-model="filters.sort_by"
                  class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                >
                  <option value="name">Nume</option>
                  <option value="created_at">Data înscrierii</option>
                  <option value="role">Rol</option>
                </select>
              </div>
            </div>

            <div class="flex justify-between items-center">
              <button
                type="submit"
                class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
              >
                <i class="fas fa-search mr-2"></i>
                Filtrează
              </button>
              <button
                type="button"
                @click="clearFilters"
                class="text-sm text-gray-600 hover:text-gray-800"
              >
                Resetează filtrele
              </button>
            </div>
          </form>
        </div>

        <!-- Members Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
          <div
            v-for="member in members.data"
            :key="member.id"
            class="bg-white overflow-hidden shadow-xl sm:rounded-lg hover:shadow-2xl transition-shadow duration-300"
          >
            <!-- Member Header -->
            <div class="relative h-32 bg-gradient-to-r from-blue-500 to-purple-600">
              <div class="absolute inset-0 bg-black bg-opacity-20"></div>
              
              <!-- Profile Photo -->
              <div class="absolute -bottom-8 left-6">
                <div class="w-16 h-16 rounded-full bg-white border-4 border-white shadow-lg overflow-hidden">
                  <img
                    v-if="member.profile_photo_url"
                    :src="member.profile_photo_url"
                    :alt="member.name"
                    class="w-full h-full object-cover"
                  />
                  <div
                    v-else
                    class="w-full h-full bg-gradient-to-br from-blue-400 to-purple-500 flex items-center justify-center text-white font-bold text-lg"
                  >
                    {{ member.name.charAt(0).toUpperCase() }}
                  </div>
                </div>
              </div>

              <!-- Role Badge -->
              <div class="absolute top-3 right-3">
                <span
                  class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"
                  :class="{
                    'bg-green-100 text-green-800': member.role === 'student',
                    'bg-purple-100 text-purple-800': member.role === 'teacher',
                    'bg-orange-100 text-orange-800': member.role === 'company'
                  }"
                >
                  {{ member.role_label }}
                </span>
              </div>
            </div>

            <!-- Member Content -->
            <div class="pt-10 pb-4 px-6">
              <div class="flex items-start justify-between mb-3">
                <div class="flex-1">
                  <h3 class="text-lg font-semibold text-gray-900 line-clamp-1">
                    {{ member.display_name }}
                  </h3>
                  <p class="text-sm text-gray-600">{{ member.email }}</p>
                </div>
              </div>

              <!-- Member Details -->
              <div class="space-y-2 text-sm text-gray-600 mb-4">
                <div v-if="member.department" class="flex items-center">
                  <i class="fas fa-university mr-2 text-blue-500"></i>
                  <span>{{ member.department }}</span>
                </div>
                <div v-if="member.school" class="flex items-center">
                  <i class="fas fa-graduation-cap mr-2 text-green-500"></i>
                  <span>{{ member.school }}</span>
                </div>
                <div v-if="member.company_name" class="flex items-center">
                  <i class="fas fa-building mr-2 text-orange-500"></i>
                  <span>{{ member.company_name }}</span>
                </div>
                <div v-if="member.location" class="flex items-center">
                  <i class="fas fa-map-marker-alt mr-2 text-red-500"></i>
                  <span>{{ member.location }}</span>
                </div>
              </div>

              <!-- Skills/Tags -->
              <div v-if="member.skills && member.skills.length" class="mb-4">
                <div class="flex flex-wrap gap-1">
                  <span
                    v-for="skill in member.skills.slice(0, 3)"
                    :key="skill"
                    class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800"
                  >
                    {{ skill }}
                  </span>
                  <span
                    v-if="member.skills.length > 3"
                    class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-600"
                  >
                    +{{ member.skills.length - 3 }}
                  </span>
                </div>
              </div>

              <!-- Specializations (for teachers) -->
              <div v-if="member.specializations && member.specializations.length" class="mb-4">
                <div class="flex flex-wrap gap-1">
                  <span
                    v-for="spec in member.specializations.slice(0, 3)"
                    :key="spec"
                    class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-800"
                  >
                    {{ spec }}
                  </span>
                  <span
                    v-if="member.specializations.length > 3"
                    class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-600"
                  >
                    +{{ member.specializations.length - 3 }}
                  </span>
                </div>
              </div>

              <!-- Member Actions -->
              <div class="flex items-center justify-between">
                <div class="flex items-center text-xs text-gray-500">
                  <i class="fas fa-clock mr-1"></i>
                  <span>Membru din {{ formatDate(member.created_at) }}</span>
                </div>

                <div class="flex gap-2">
                  <button
                    v-if="member.is_available_for_contact && member.id !== $page.props.auth.user?.id"
                    @click="contactMember(member)"
                    class="inline-flex items-center px-3 py-1.5 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                  >
                    <i class="fas fa-envelope mr-1"></i>
                    Contactează
                  </button>
                  
                  <Link
                    :href="route('profile.show', member.id)"
                    class="inline-flex items-center px-3 py-1.5 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                  >
                    Vezi Profilul
                  </Link>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Pagination -->
        <div v-if="members.links && members.links.length > 3" class="mt-8">
          <nav class="flex items-center justify-between">
            <div class="flex-1 flex justify-between sm:hidden">
              <Link
                v-if="members.prev_page_url"
                :href="members.prev_page_url"
                class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50"
              >
                Anterior
              </Link>
              <Link
                v-if="members.next_page_url"
                :href="members.next_page_url"
                class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50"
              >
                Următor
              </Link>
            </div>
            <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
              <div>
                <p class="text-sm text-gray-700">
                  Afișând
                  <span class="font-medium">{{ members.from }}</span>
                  până la
                  <span class="font-medium">{{ members.to }}</span>
                  din
                  <span class="font-medium">{{ members.total }}</span>
                  rezultate
                </p>
              </div>
              <div>
                <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px">
                  <Link
                    v-for="(link, key) in members.links"
                    :key="key"
                    :href="link.url"
                    class="relative inline-flex items-center px-4 py-2 border text-sm font-medium"
                    :class="{
                      'bg-indigo-50 border-indigo-500 text-indigo-600': link.active,
                      'bg-white border-gray-300 text-gray-500 hover:bg-gray-50': !link.active && link.url,
                      'bg-white border-gray-300 text-gray-300 cursor-not-allowed': !link.url
                    }"
                    v-html="link.label"
                  ></Link>
                </nav>
              </div>
            </div>
          </nav>
        </div>

        <!-- Empty State -->
        <div
          v-if="members.data.length === 0"
          class="text-center py-12"
        >
          <i class="fas fa-users text-4xl text-gray-400 mb-4"></i>
          <h3 class="text-lg font-medium text-gray-900 mb-2">
            Nu s-au găsit membri
          </h3>
          <p class="text-gray-600 mb-4">
            Încearcă să modifici filtrele pentru a găsi membri.
          </p>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script>
import { defineComponent } from 'vue'
import { Link } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'

export default defineComponent({
  components: {
    AppLayout,
    Link,
  },
  props: {
    members: Object,
    stats: Object,
    filters: Object,
  },
  data() {
    return {
      localFilters: { ...this.filters }
    }
  },
  methods: {
    formatDate(date) {
      return new Date(date).toLocaleDateString('ro-RO', {
        year: 'numeric',
        month: 'long'
      })
    },
    applyFilters() {
      this.$inertia.get(route('members.index'), this.localFilters, {
        preserveState: true,
        preserveScroll: true,
      })
    },
    clearFilters() {
      this.localFilters = {
        search: '',
        role: '',
        department: '',
        sort_by: 'name',
        sort_order: 'asc'
      }
      this.applyFilters()
    },
    contactMember(member) {
      // This would typically open a contact form or modal
      alert(`Contactează ${member.name} la ${member.email}`)
    }
  }
})
</script>

<style scoped>
.line-clamp-1 {
  display: -webkit-box;
  -webkit-line-clamp: 1;
  -webkit-box-orient: vertical;
  overflow: hidden;
}
</style> 