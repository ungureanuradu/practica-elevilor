<script setup>
import { ref, onMounted } from 'vue'
import { Link } from '@inertiajs/vue3'
import axios from 'axios'

/* ▶ lista de evenimente pe care o vom afișa */
const events = ref([])

/* ▶ când componenta se montează, cerem /api/events
 și păstrăm doar primele 4 rezultate */
onMounted(() => {
  axios.get('/api/events').then(r => {
    events.value = r.data.data.slice(0, 4)
  })
})
</script>

<template>
  <section class="space-y-3">
    <h3 class="text-lg font-semibold">Upcoming Events</h3>
    
    <ul class="divide-y">
      <li v-for="e in events" :key="e.id" class="py-2">
        <Link :href="`/events/${e.id}`" class="block group hover:bg-gray-50 rounded-lg p-2 -m-2 transition-colors duration-200">
          <p class="font-medium group-hover:text-blue-600 transition-colors">
            {{ e.title }}
          </p>
          <div class="flex items-center gap-2 text-sm text-gray-500 mt-1">
            <span>📅 {{ e.date_only }}</span>
            <span v-if="e.time_only">🕐 {{ e.time_only }}</span>
            <span v-if="e.location">📍 {{ e.location }}</span>
          </div>
          <p v-if="e.organizer" class="text-xs text-gray-400 mt-1">
            Organizator: {{ e.organizer }}
          </p>
        </Link>
      </li>
    </ul>
    
    <p v-if="events.length === 0" class="text-sm text-gray-400">
      No events scheduled.
    </p>

    <!-- Link către toate evenimentele -->
    <div class="pt-2 border-t">
      <Link href="/events" class="text-sm text-blue-600 hover:text-blue-800 font-medium">
        Vezi toate evenimentele →
      </Link>
    </div>
  </section>
</template>