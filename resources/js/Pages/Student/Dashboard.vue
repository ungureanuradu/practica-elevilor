<template>
  <AppLayout title="Dashboard Student">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Dashboard Student
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Welcome Section -->
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6 mb-6">
          <div class="flex items-center justify-between">
            <div>
              <h3 class="text-lg font-medium text-gray-900">Bun venit, {{ $page.props.auth.user.name }}!</h3>
              <p class="text-sm text-gray-600 mt-1">
                Dashboard-ul tău de student - accesează cursurile, evenimentele și oportunitățile
              </p>
            </div>
            <div class="text-right">
              <p class="text-sm text-gray-500">Rol: {{ $page.props.auth.user.role_label }}</p>
              <p class="text-sm text-gray-500">{{ $page.props.auth.user.school }}</p>
            </div>
          </div>
        </div>

        <!-- Quick Stats -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
          <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
            <div class="flex items-center">
              <div class="flex-shrink-0">
                <i class="fas fa-book text-2xl text-blue-500"></i>
              </div>
              <div class="ml-4">
                <p class="text-sm font-medium text-gray-500">Cursuri Înscris</p>
                <p class="text-2xl font-semibold text-gray-900">{{ stats.enrolled_courses || 0 }}</p>
              </div>
            </div>
          </div>

          <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
            <div class="flex items-center">
              <div class="flex-shrink-0">
                <i class="fas fa-calendar-check text-2xl text-green-500"></i>
              </div>
              <div class="ml-4">
                <p class="text-sm font-medium text-gray-500">Evenimente Participare</p>
                <p class="text-2xl font-semibold text-gray-900">{{ stats.registered_events || 0 }}</p>
              </div>
            </div>
          </div>

          <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
            <div class="flex items-center">
              <div class="flex-shrink-0">
                <i class="fas fa-briefcase text-2xl text-purple-500"></i>
              </div>
              <div class="ml-4">
                <p class="text-sm font-medium text-gray-500">Aplicații Job</p>
                <p class="text-2xl font-semibold text-gray-900">{{ stats.job_applications || 0 }}</p>
              </div>
            </div>
          </div>

          <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
            <div class="flex items-center">
              <div class="flex-shrink-0">
                <i class="fas fa-users text-2xl text-orange-500"></i>
              </div>
              <div class="ml-4">
                <p class="text-sm font-medium text-gray-500">Grupuri Membru</p>
                <p class="text-2xl font-semibold text-gray-900">{{ stats.group_memberships || 0 }}</p>
              </div>
            </div>
          </div>
        </div>

        <!-- Quick Actions -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
          <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Acțiuni Rapide</h3>
            <div class="space-y-3">
              <Link
                :href="route('student.courses.index')"
                class="inline-flex items-center w-full px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
              >
                <i class="fas fa-search mr-2"></i>
                Caută Cursuri
              </Link>
              <Link
                :href="route('student.jobs.index')"
                class="inline-flex items-center w-full px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
              >
                <i class="fas fa-briefcase mr-2"></i>
                Caută Joburi
              </Link>
              <Link
                :href="route('student.calendar.index')"
                class="inline-flex items-center w-full px-4 py-2 bg-purple-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-purple-700 focus:bg-purple-700 active:bg-purple-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
              >
                <i class="fas fa-calendar mr-2"></i>
                Vezi Evenimente
              </Link>
            </div>
          </div>

          <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Navigare Rapidă</h3>
            <div class="space-y-3">
              <Link
                :href="route('student.forum.index')"
                class="inline-flex items-center w-full px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
              >
                <i class="fas fa-comments mr-2"></i>
                Forum
              </Link>
              <Link
                :href="route('student.groups.index')"
                class="inline-flex items-center w-full px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
              >
                <i class="fas fa-users mr-2"></i>
                Grupuri
              </Link>
              <Link
                :href="route('student.documents.index')"
                class="inline-flex items-center w-full px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
              >
                <i class="fas fa-file-alt mr-2"></i>
                Documente
              </Link>
            </div>
          </div>

          <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Aplicațiile Mele</h3>
            <div class="space-y-3">
              <Link
                :href="route('student.applications.my')"
                class="inline-flex items-center w-full px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
              >
                <i class="fas fa-clipboard-list mr-2"></i>
                Aplicațiile Mele
              </Link>
              <Link
                :href="route('student.members.index')"
                class="inline-flex items-center w-full px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
              >
                <i class="fas fa-user-graduate mr-2"></i>
                Membri
              </Link>
              <Link
                :href="route('profile.show')"
                class="inline-flex items-center w-full px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
              >
                <i class="fas fa-user-edit mr-2"></i>
                Editează Profilul
              </Link>
            </div>
          </div>
        </div>

        <!-- Recent Activity -->
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
          <h3 class="text-lg font-medium text-gray-900 mb-4">Activitate Recentă</h3>
          <div v-if="recentActivity && recentActivity.length" class="space-y-4">
            <div
              v-for="activity in recentActivity"
              :key="activity.id"
              class="flex items-center space-x-4 p-4 border border-gray-200 rounded-lg"
            >
              <div class="flex-shrink-0">
                <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                  <i class="fas fa-bell text-blue-600 text-sm"></i>
                </div>
              </div>
              <div class="flex-1">
                <p class="text-sm font-medium text-gray-900">{{ activity.title }}</p>
                <p class="text-sm text-gray-500">{{ activity.description }}</p>
              </div>
              <div class="text-sm text-gray-400">
                {{ formatDate(activity.created_at) }}
              </div>
            </div>
          </div>
          <div v-else class="text-center py-8 text-gray-500">
            <i class="fas fa-inbox text-3xl mb-3"></i>
            <p>Nu există activitate recentă</p>
          </div>
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
    stats: Object,
    recentActivity: Array,
  },
  methods: {
    formatDate(date) {
      return new Date(date).toLocaleDateString('ro-RO', {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
      })
    }
  }
})
</script> 