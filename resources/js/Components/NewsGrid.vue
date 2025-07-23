<script setup>
import { ref, onMounted } from 'vue'
import axios              from 'axios'
import NewsCard           from '@/Components/NewsCard.vue'   // “@” = resources/js

const items = ref([])

onMounted(() => {
  axios.get('/api/news').then(r => items.value = r.data.data)
})
</script>

<template>
  <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
    <NewsCard v-for="n in items" :key="n.id" :news="n" />
  </div>
</template>
