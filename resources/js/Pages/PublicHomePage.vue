<script setup>
import { Link } from '@inertiajs/vue3'
import NewsGrid from '@/Components/NewsGrid.vue'
import UpcomingEvents from '@/Components/UpcomingEvents.vue'
import FrontendLayout from '@/Layouts/FrontendLayout.vue'


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
  <FrontendLayout>

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
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
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

  </div>
  </FrontendLayout>
</template>
