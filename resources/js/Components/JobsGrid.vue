<script setup>
const props = defineProps({
  items: { type: Array, default: () => [] }
})
</script>

<template>
  <div class="grid gap-6 sm:grid-cols-2 xl:grid-cols-3">
    <article v-for="job in items" :key="job.id"
      class="bg-white rounded-xl shadow-sm p-5 border">
      <h4 class="font-semibold text-lg mb-1">{{ job.title }}</h4>
      <p class="text-sm text-gray-500 mb-2">
        {{ job.company }} • {{ job.location }}
      </p>
      <p class="text-sm text-gray-600 line-clamp-3 mb-4">{{ job.summary }}</p>
      <a :href="`/joburi/${job.slug || job.id}`" class="text-blue-600 text-sm">Detalii →</a>
    </article>
  </div>
</template>
