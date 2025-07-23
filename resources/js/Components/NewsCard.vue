<script setup>

defineProps({ news: Object })
</script>

<template>
  <article class="bg-white shadow rounded-xl p-5 flex flex-col gap-3">
    <h3 class="text-lg font-semibold">{{ news.title }}</h3>
    <p class="text-sm text-gray-600 line-clamp-3">{{ news.excerpt }}</p>
    <span class="mt-auto text-xs text-gray-400">{{ news.published_at }}</span>
  </article>
</template>
