<script setup>
import NewsGrid from '@/Components/NewsGrid.vue'
import UpcomingEvents from '@/Components/UpcomingEvents.vue'
import { Link } from '@inertiajs/vue3'

</script>

<template>
  <!-- NAV BAR -->
  <header class="bg-blue-700 text-white">
    <div class="container mx-auto flex items-center justify-between py-4">
      <h1 class="font-extrabold">PRACTICA ELEVILOR</h1>
      <nav class="flex gap-6">
        <Link href="/">Home</Link>
        <Link href="/members">Members</Link>
        <Link href="/courses">Courses</Link>
        <Link href="/forum">Forum</Link>
        <Link href="/jobs">Jobs</Link>
      </nav>
    </div>
  </header>

  <!-- HERO -->
  <section class="bg-blue-600 text-white text-center py-14 px-3">
    <h2 class="text-4xl font-extrabold leading-tight">
      PRACTICA ELEVILOR<br>
      O CALE CARE SUCCESUL PROFESIONAL<br>
      <span class="block text-2xl mt-4">COD SMIS 317832</span>
    </h2>
  </section>

  <!-- NEWS -->
  <main class="container mx-auto py-12 px-4">
    <div class="grid gap-10 lg:grid-cols-[2fr_1fr]">
      
      <!-- col 1: News -->
      <section>
        <h3 class="text-2xl font-bold mb-6">News Feed</h3>
        <NewsGrid />
      </section>

      <!-- col 2: Upcoming Events -->
      <aside class="lg:border-l lg:pl-8">
        <UpcomingEvents />
      </aside>

    </div>
  </main>
</template>
