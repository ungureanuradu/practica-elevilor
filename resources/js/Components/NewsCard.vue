<script setup>
import { Link } from '@inertiajs/vue3'

defineProps({ news: Object })
</script>

<template>
  <Link :href="`/news/${news.id}`" class="block group">
    <article class="bg-white shadow rounded-xl p-5 flex flex-col gap-3 transition-all duration-200 hover:shadow-lg hover:scale-[1.02] cursor-pointer">
      <h3 class="text-lg font-semibold group-hover:text-blue-600 transition-colors">
        {{ news.title }}
      </h3>
      <p class="text-sm text-gray-600 line-clamp-3">
        {{ news.excerpt }}
      </p>
      <div class="mt-auto flex justify-between items-center">
        <span class="text-xs text-gray-400">{{ news.published_at }}</span>
        <span class="text-xs text-blue-600 opacity-0 group-hover:opacity-100 transition-opacity">
          Citește mai mult →
        </span>
      </div>
    </article>
  </Link>
</template>