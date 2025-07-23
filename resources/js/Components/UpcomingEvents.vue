<script setup>
import { ref, onMounted } from 'vue'
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
        <p class="font-medium">{{ e.title }}</p>
        <span class="text-sm text-gray-500">
          {{ new Date(e.start).toLocaleDateString() }}
        </span>
      </li>
    </ul>

    <p v-if="events.length === 0" class="text-sm text-gray-400">
      No events scheduled.
    </p>
  </section>
</template>
