<script setup>
import { ref } from 'vue'
import { Link } from '@inertiajs/vue3'
import NewsGrid from '@/Components/NewsGrid.vue'
import UpcomingEvents from '@/Components/UpcomingEvents.vue'
import Footer from '@/Components/Footer.vue'

const mobileOpen = ref(false)
const footerData = typeof window !== 'undefined' ? window.footerData : null


// (opțional) poți trimite items custom dacă vrei alte linkuri:
const useful = [
  {
    title: 'Cum se face un CV European (Europass)',
    note: 'Ghid + generator CV',
    url: 'https://europa.eu/europass/ro/create-europass-cv',
    external: true
  },
  { title: 'Cum îmi găsesc un angajator', note: 'Pași practici', url: '/informatii/gasire-angajator' },
  { title: 'Documente necesare la angajare', note: 'Checklist', url: '/informatii/documente-angajare' },
  { title: 'Ce înseamnă internship', note: 'Explicații simple', url: '/informatii/internship' },
]
</script>

<template>
  <!-- NAVBAR -->
  <header class="bg-blue-700 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-14 flex items-center justify-between">
      <h1 class="font-extrabold text-sm sm:text-base">
        Liceul Tehnologic „Vasile Sav”
      </h1>

      <!-- Desktop menu -->
      <nav class="hidden md:flex items-center gap-6 text-sm">
        <Link href="/">Acasă</Link>
        <Link href="/membri">Membri</Link>
        <Link href="/cursuri">Cursuri</Link>
        <Link href="/forum">Forum</Link>
        <Link href="/joburi">Joburi</Link>
      </nav>

      <!-- Mobile button -->
      <button
        class="md:hidden inline-flex items-center justify-center p-2 rounded hover:bg-blue-600 focus:outline-none"
        @click="mobileOpen = !mobileOpen"
        aria-label="Deschide meniul"
      >
        <svg v-if="!mobileOpen" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
        </svg>
        <svg v-else xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
        </svg>
      </button>
    </div>

    <!-- Mobile dropdown -->
    <div v-show="mobileOpen" class="md:hidden border-t border-blue-600">
      <div class="max-w-7xl mx-auto px-4 py-3 flex flex-col gap-3 text-sm">
        <Link href="/" @click="mobileOpen=false">Acasă</Link>
        <Link href="/membri" @click="mobileOpen=false">Membri</Link>
        <Link href="/cursuri" @click="mobileOpen=false">Cursuri</Link>
        <Link href="/forum" @click="mobileOpen=false">Forum</Link>
        <Link href="/joburi" @click="mobileOpen=false">Joburi</Link>
      </div>
    </div>
  </header>

  <!-- HERO limitat (mai mult spațiu pe lateral) -->
  <section class="py-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="bg-blue-600 text-white text-center rounded-2xl px-6 sm:px-10 py-12 sm:py-16 shadow">
        <!-- opțional: limitează lățimea textului ca să respire și mai bine -->
        <div class="max-w-4xl mx-auto">
          <h2 class="text-3xl sm:text-4xl font-extrabold leading-snug">
            Platformă de Informare între Educție și Sectorul Industrial
          </h2>
          <p class="mt-2 text-xl sm:text-2xl font-semibold">
           Proiect PEO: O Cale către Succesul Profesional
          </p>
          <p class="mt-4 text-lg sm:text-xl opacity-90">
            COD SMIS 317832
          </p>
          <p class="mt-4 text-lg sm:text-xl opacity-90">
          Beneficiar: Liceul Tehnologic „Vasile Sav” 
          </p>
        </div>
      </div>
    </div>
  </section>

  <!-- NEWS -->
  <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="grid gap-10 lg:grid-cols-[2fr_1fr]">
      <section>
        <h3 class="text-2xl font-bold mb-6">Noutăți</h3>
        <NewsGrid />
        <h3 class="text-2xl font-bold mb-6">Joburi</h3>
        <JobsGrid :items="jobs" />
      </section>

      <aside class="lg:border-l lg:pl-8">
        <UpcomingEvents />
        <br></br>
        <section class="space-y-3"><h3 class="text-lg font-semibold">Ghiduri</h3><ul class="divide-y"><li class="py-2"><a class="block group hover:bg-gray-50 rounded-lg p-2 -m-2 transition-colors duration-200" href="/events/7"><p class="font-medium group-hover:text-blue-600 transition-colors">Cum să îti faci un CV Europass?</p><div class="flex items-center gap-2 text-sm text-gray-500 mt-1"><span>📅 </span><!--v-if--><span>📍 New Marge</span></div><!--v-if--></a></li><li class="py-2"><a class="block group hover:bg-gray-50 rounded-lg p-2 -m-2 transition-colors duration-200" href="/events/8"><p class="font-medium group-hover:text-blue-600 transition-colors">Cum să îti găsești un loc de muncă?</p><div class="flex items-center gap-2 text-sm text-gray-500 mt-1"><span>📅 </span><!--v-if--><span>📍 Dejuanfurt</span></div><!--v-if--></a></li><li class="py-2"><a class="block group hover:bg-gray-50 rounded-lg p-2 -m-2 transition-colors duration-200" href="/events/2"><p class="font-medium group-hover:text-blue-600 transition-colors">Ce acte ai nevoie la angajare?</p><div class="flex items-center gap-2 text-sm text-gray-500 mt-1"><span>📅 </span><!--v-if--><span>📍 Tadmouth</span></div><!--v-if--></a></li><li class="py-2"><a class="block group hover:bg-gray-50 rounded-lg p-2 -m-2 transition-colors duration-200" href="/events/4"><p class="font-medium group-hover:text-blue-600 transition-colors">Ce este un intership?</p><div class="flex items-center gap-2 text-sm text-gray-500 mt-1"><span>📅 </span><!--v-if--><span>📍 South Justina</span></div><!--v-if--></a></li></ul><!--v-if--><!-- Link către toate evenimentele --><div class="pt-2 border-t"><a class="text-sm text-blue-600 hover:text-blue-800 font-medium" href="/events"> Vezi toate ghidurile → </a></div></section>
        <br></br>
      </aside>
    </div>

    <Footer v-if="footerData" :data="footerData" />
  </main>
</template>
