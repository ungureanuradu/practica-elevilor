<template>
  <AppLayout title="Grupuri">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Grupuri
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Header Section -->
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6 mb-6">
          <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
              <h3 class="text-lg font-medium text-gray-900">Descoperă Grupuri</h3>
              <p class="text-sm text-gray-600 mt-1">
                Găsește grupuri care se potrivesc cu interesele tale
              </p>
            </div>
            <div class="flex gap-3">
              <Link
                v-if="$page.props.auth.user"
                :href="route('groups.create')"
                class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
              >
                <i class="fas fa-plus mr-2"></i>
                Creează Grup
              </Link>
              <Link
                v-if="$page.props.auth.user"
                :href="route('groups.my')"
                class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
              >
                <i class="fas fa-users mr-2"></i>
                Grupurile Mele
              </Link>
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
                  v-model="localFilters.search"
                  type="text"
                  placeholder="Caută grupuri..."
                  class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                />
              </div>

              <!-- Category Filter -->
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                  Categorie
                </label>
                <select
                  v-model="localFilters.category"
                  class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                >
                  <option value="">Toate categoriile</option>
                  <option
                    v-for="(label, value) in categories"
                    :key="value"
                    :value="value"
                  >
                    {{ label }}
                  </option>
                </select>
              </div>

              <!-- Type Filter -->
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                  Tip
                </label>
                <select
                  v-model="localFilters.type"
                  class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                >
                  <option value="">Toate tipurile</option>
                  <option
                    v-for="(label, value) in types"
                    :key="value"
                    :value="value"
                  >
                    {{ label }}
                  </option>
                </select>
              </div>

              <!-- Sort -->
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                  Sortează
                </label>
                <select
                  v-model="localFilters.sort_by"
                  class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                >
                  <option value="created_at">Cele mai noi</option>
                  <option value="name">Nume</option>
                  <option value="members_count">Membri</option>
                  <option value="last_activity">Activitate</option>
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

        <!-- Groups Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
          <div
            v-for="group in groups.data"
            :key="group.id"
            class="bg-white overflow-hidden shadow-xl sm:rounded-lg hover:shadow-2xl transition-shadow duration-300"
          >
            <!-- Group Header -->
            <div class="relative h-32 bg-gradient-to-r from-blue-500 to-purple-600">
              <div
                v-if="group.cover_image"
                class="absolute inset-0 bg-cover bg-center"
                :style="{ backgroundImage: `url(${group.cover_image_url})` }"
              ></div>
              <div class="absolute inset-0 bg-black bg-opacity-40"></div>
              
              <!-- Group Avatar -->
              <div class="absolute -bottom-8 left-6">
                <div class="w-16 h-16 rounded-full bg-white border-4 border-white shadow-lg overflow-hidden">
                  <img
                    v-if="group.avatar"
                    :src="group.avatar_url"
                    :alt="group.name"
                    class="w-full h-full object-cover"
                  />
                  <div
                    v-else
                    class="w-full h-full bg-gradient-to-br from-blue-400 to-purple-500 flex items-center justify-center text-white font-bold text-lg"
                  >
                    {{ group.name.charAt(0).toUpperCase() }}
                  </div>
                </div>
              </div>

              <!-- Group Type Badge -->
              <div class="absolute top-3 right-3">
                <span
                  class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"
                  :class="{
                    'bg-green-100 text-green-800': group.type === 'public',
                    'bg-yellow-100 text-yellow-800': group.type === 'private',
                    'bg-red-100 text-red-800': group.type === 'secret'
                  }"
                >
                  {{ group.type_label }}
                </span>
              </div>
            </div>

            <!-- Group Content -->
            <div class="pt-10 pb-4 px-6">
              <div class="flex items-start justify-between mb-3">
                <h3 class="text-lg font-semibold text-gray-900 line-clamp-1">
                  {{ group.name }}
                </h3>
              </div>

              <p class="text-sm text-gray-600 mb-4 line-clamp-2">
                {{ group.excerpt || group.description }}
              </p>

              <!-- Group Stats -->
              <div class="flex items-center justify-between text-sm text-gray-500 mb-4">
                <div class="flex items-center">
                  <i class="fas fa-users mr-1"></i>
                  <span>{{ group.members_count_formatted }} membri</span>
                </div>
                <div class="flex items-center">
                  <i class="fas fa-comments mr-1"></i>
                  <span>{{ group.topics_count }} subiecte</span>
                </div>
              </div>

              <!-- Group Tags -->
              <div v-if="group.tags && group.tags.length" class="mb-4">
                <div class="flex flex-wrap gap-1">
                  <span
                    v-for="tag in group.tags.slice(0, 3)"
                    :key="tag"
                    class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800"
                  >
                    {{ tag }}
                  </span>
                  <span
                    v-if="group.tags.length > 3"
                    class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-600"
                  >
                    +{{ group.tags.length - 3 }}
                  </span>
                </div>
              </div>

              <!-- Group Actions -->
              <div class="flex items-center justify-between">
                <div class="flex items-center text-xs text-gray-500">
                  <i class="fas fa-clock mr-1"></i>
                  <span>{{ group.last_activity_formatted }}</span>
                </div>

                <div class="flex gap-2">
                  <Link
                    :href="route('groups.show', group.id)"
                    class="inline-flex items-center px-3 py-1.5 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                  >
                    Vezi Detalii
                  </Link>
                  
                  <button
                    v-if="$page.props.auth.user && !userGroups.includes(group.id) && group.can_join"
                    @click="joinGroup(group.id)"
                    class="inline-flex items-center px-3 py-1.5 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                  >
                    <i class="fas fa-plus mr-1"></i>
                    Aderă
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Pagination -->
        <div v-if="groups.links && groups.links.length > 3" class="mt-8">
          <nav class="flex items-center justify-between">
            <div class="flex-1 flex justify-between sm:hidden">
              <Link
                v-if="groups.prev_page_url"
                :href="groups.prev_page_url"
                class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50"
              >
                Anterior
              </Link>
              <Link
                v-if="groups.next_page_url"
                :href="groups.next_page_url"
                class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50"
              >
                Următor
              </Link>
            </div>
            <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
              <div>
                <p class="text-sm text-gray-700">
                  Afișând
                  <span class="font-medium">{{ groups.from }}</span>
                  până la
                  <span class="font-medium">{{ groups.to }}</span>
                  din
                  <span class="font-medium">{{ groups.total }}</span>
                  rezultate
                </p>
              </div>
              <div>
                <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px">
                  <Link
                    v-for="(link, key) in groups.links"
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
          v-if="groups.data.length === 0"
          class="text-center py-12"
        >
          <i class="fas fa-users text-4xl text-gray-400 mb-4"></i>
          <h3 class="text-lg font-medium text-gray-900 mb-2">
            Nu s-au găsit grupuri
          </h3>
          <p class="text-gray-600 mb-4">
            Încearcă să modifici filtrele sau să creezi un grup nou.
          </p>
          <Link
            v-if="$page.props.auth.user"
            :href="route('groups.create')"
            class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
          >
            <i class="fas fa-plus mr-2"></i>
            Creează Primul Grup
          </Link>
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
    groups: Object,
    userGroups: Array,
    filters: Object,
    categories: Object,
    types: Object,
  },
  data() {
    return {
      localFilters: { ...this.filters }
    }
  },
  methods: {
    applyFilters() {
      this.$inertia.get(route('groups.index'), this.localFilters, {
        preserveState: true,
        preserveScroll: true,
      })
    },
    clearFilters() {
      this.localFilters = {
        search: '',
        category: '',
        type: '',
        sort_by: 'created_at',
        sort_order: 'desc'
      }
      this.applyFilters()
    },
    joinGroup(groupId) {
      this.$inertia.post(route('groups.join', groupId), {}, {
        onSuccess: () => {
          // Refresh the page to update user groups
          this.$inertia.reload()
        }
      })
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

.line-clamp-2 {
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}
</style> 