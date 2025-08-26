<template>
  <AppLayout :title="group.name">
    <template #header>
      <div class="flex items-center justify-between">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          {{ group.name }}
        </h2>
        <div class="flex gap-2">
          <Link
            v-if="canEdit"
            :href="route('groups.edit', group.id)"
            class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
          >
            <i class="fas fa-edit mr-2"></i>
            Editează
          </Link>
          <button
            v-if="canDelete"
            @click="deleteGroup"
            class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
          >
            <i class="fas fa-trash mr-2"></i>
            Șterge
          </button>
        </div>
      </div>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Group Header -->
        <div class="relative mb-6">
          <!-- Cover Image -->
          <div class="h-64 bg-gradient-to-r from-blue-500 to-purple-600 rounded-lg overflow-hidden">
            <div
              v-if="group.cover_image"
              class="w-full h-full bg-cover bg-center"
              :style="{ backgroundImage: `url(${group.cover_image_url})` }"
            ></div>
            <div class="absolute inset-0 bg-black bg-opacity-40"></div>
            
            <!-- Group Info Overlay -->
            <div class="absolute bottom-6 left-6 right-6">
              <div class="flex items-end gap-4">
                <!-- Avatar -->
                <div class="w-20 h-20 rounded-full bg-white border-4 border-white shadow-lg overflow-hidden">
                  <img
                    v-if="group.avatar"
                    :src="group.avatar_url"
                    :alt="group.name"
                    class="w-full h-full object-cover"
                  />
                  <div
                    v-else
                    class="w-full h-full bg-gradient-to-br from-blue-400 to-purple-500 flex items-center justify-center text-white font-bold text-2xl"
                  >
                    {{ group.name.charAt(0).toUpperCase() }}
                  </div>
                </div>
                
                <!-- Group Details -->
                <div class="flex-1 text-white">
                  <h1 class="text-3xl font-bold mb-2">{{ group.name }}</h1>
                  <p class="text-lg opacity-90 mb-3">{{ group.excerpt }}</p>
                  
                  <!-- Group Stats -->
                  <div class="flex items-center gap-6 text-sm">
                    <div class="flex items-center">
                      <i class="fas fa-users mr-2"></i>
                      <span>{{ group.members_count_formatted }} membri</span>
                    </div>
                    <div class="flex items-center">
                      <i class="fas fa-comments mr-2"></i>
                      <span>{{ group.topics_count }} subiecte</span>
                    </div>
                    <div class="flex items-center">
                      <i class="fas fa-clock mr-2"></i>
                      <span>{{ group.last_activity_formatted }}</span>
                    </div>
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
                
                <!-- Action Buttons -->
                <div class="flex gap-2">
                  <button
                    v-if="$page.props.auth.user && !isMember && canJoin"
                    @click="joinGroup"
                    class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                  >
                    <i class="fas fa-plus mr-2"></i>
                    Aderă la Grup
                  </button>
                  <button
                    v-if="$page.props.auth.user && isMember && userRole !== 'owner'"
                    @click="leaveGroup"
                    class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                  >
                    <i class="fas fa-sign-out-alt mr-2"></i>
                    Părăsește Grupul
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
          <!-- Main Content -->
          <div class="lg:col-span-2 space-y-6">
            <!-- Description -->
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
              <h3 class="text-lg font-medium text-gray-900 mb-4">Despre Grup</h3>
              <div class="prose max-w-none">
                <p class="text-gray-700 whitespace-pre-wrap">{{ group.description }}</p>
              </div>
            </div>

            <!-- Tags -->
            <div v-if="group.tags && group.tags.length" class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
              <h3 class="text-lg font-medium text-gray-900 mb-4">Etichete</h3>
              <div class="flex flex-wrap gap-2">
                <span
                  v-for="tag in group.tags"
                  :key="tag"
                  class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800"
                >
                  {{ tag }}
                </span>
              </div>
            </div>

            <!-- Topics -->
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
              <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-medium text-gray-900">Subiecte</h3>
                <Link
                  v-if="isMember"
                  :href="route('group-topics.create', group.id)"
                  class="inline-flex items-center px-3 py-1.5 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                >
                  <i class="fas fa-plus mr-1"></i>
                  Subiect Nou
                </Link>
              </div>
              
              <div v-if="group.topics && group.topics.length" class="space-y-3">
                <div
                  v-for="topic in group.topics"
                  :key="topic.id"
                  class="flex items-center justify-between p-3 border border-gray-200 rounded-lg hover:bg-gray-50"
                >
                  <div class="flex items-center gap-3">
                    <div
                      v-if="topic.icon"
                      class="w-8 h-8 rounded-full flex items-center justify-center text-white text-sm"
                      :style="{ backgroundColor: topic.color }"
                    >
                      <i :class="topic.icon"></i>
                    </div>
                    <div>
                      <h4 class="font-medium text-gray-900">{{ topic.name }}</h4>
                      <p class="text-sm text-gray-600">{{ topic.description }}</p>
                    </div>
                  </div>
                  <div class="flex items-center gap-2 text-sm text-gray-500">
                    <span>{{ topic.posts_count }} postări</span>
                    <i v-if="topic.is_pinned" class="fas fa-thumbtack text-blue-500"></i>
                  </div>
                </div>
              </div>
              
              <div v-else class="text-center py-8 text-gray-500">
                <i class="fas fa-comments text-3xl mb-3"></i>
                <p>Nu există subiecte încă.</p>
                <p class="text-sm">Fii primul care creează un subiect!</p>
              </div>
            </div>
          </div>

          <!-- Sidebar -->
          <div class="space-y-6">
            <!-- Group Info -->
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
              <h3 class="text-lg font-medium text-gray-900 mb-4">Informații Grup</h3>
              
              <div class="space-y-3">
                <div class="flex justify-between">
                  <span class="text-sm text-gray-600">Categorie:</span>
                  <span class="text-sm font-medium">{{ group.category_label }}</span>
                </div>
                <div class="flex justify-between">
                  <span class="text-sm text-gray-600">Tip:</span>
                  <span class="text-sm font-medium">{{ group.type_label }}</span>
                </div>
                <div class="flex justify-between">
                  <span class="text-sm text-gray-600">Membri:</span>
                  <span class="text-sm font-medium">{{ group.members_count_formatted }}</span>
                </div>
                <div v-if="group.max_members" class="flex justify-between">
                  <span class="text-sm text-gray-600">Limita:</span>
                  <span class="text-sm font-medium">{{ group.max_members }}</span>
                </div>
                <div class="flex justify-between">
                  <span class="text-sm text-gray-600">Creat:</span>
                  <span class="text-sm font-medium">{{ formatDate(group.created_at) }}</span>
                </div>
              </div>
            </div>

            <!-- Group Owner -->
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
              <h3 class="text-lg font-medium text-gray-900 mb-4">Proprietar</h3>
              
              <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-gray-200 flex items-center justify-center">
                  <i class="fas fa-user text-gray-600"></i>
                </div>
                <div>
                  <p class="font-medium text-gray-900">{{ group.owner.name }}</p>
                  <p class="text-sm text-gray-600">{{ group.owner.role_label }}</p>
                </div>
              </div>
            </div>

            <!-- Recent Members -->
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
              <h3 class="text-lg font-medium text-gray-900 mb-4">Membri Recenti</h3>
              
              <div v-if="group.active_members && group.active_members.length" class="space-y-3">
                <div
                  v-for="member in group.active_members.slice(0, 5)"
                  :key="member.id"
                  class="flex items-center gap-3"
                >
                  <div class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center">
                    <i class="fas fa-user text-gray-600 text-sm"></i>
                  </div>
                  <div class="flex-1">
                    <p class="text-sm font-medium text-gray-900">{{ member.name }}</p>
                    <p class="text-xs text-gray-600">{{ member.role_label }}</p>
                  </div>
                </div>
                
                <div v-if="group.active_members.length > 5" class="text-center">
                  <Link
                    :href="route('group-members.index', group.id)"
                    class="text-sm text-blue-600 hover:text-blue-800"
                  >
                    Vezi toți membrii ({{ group.active_members.length }})
                  </Link>
                </div>
              </div>
              
              <div v-else class="text-center py-4 text-gray-500">
                <p class="text-sm">Nu există membri încă.</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script>
import { defineComponent } from 'vue'
import { Link, useForm } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'

export default defineComponent({
  components: {
    AppLayout,
    Link,
  },
  props: {
    group: Object,
    isMember: Boolean,
    userRole: String,
    canEdit: Boolean,
    canDelete: Boolean,
    canJoin: Boolean,
  },
  methods: {
    formatDate(date) {
      return new Date(date).toLocaleDateString('ro-RO', {
        year: 'numeric',
        month: 'long',
        day: 'numeric'
      })
    },
    joinGroup() {
      this.$inertia.post(route('groups.join', this.group.id), {}, {
        onSuccess: () => {
          this.$inertia.reload()
        }
      })
    },
    leaveGroup() {
      if (confirm('Ești sigur că vrei să părăsești acest grup?')) {
        this.$inertia.post(route('groups.leave', this.group.id), {}, {
          onSuccess: () => {
            this.$inertia.reload()
          }
        })
      }
    },
    deleteGroup() {
      if (confirm('Ești sigur că vrei să ștergi acest grup? Această acțiune nu poate fi anulată.')) {
        this.$inertia.delete(route('groups.destroy', this.group.id), {
          onSuccess: () => {
            this.$inertia.visit(route('groups.index'))
          }
        })
      }
    }
  }
})
</script> 