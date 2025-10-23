<template>
  <FrontendLayout title="Cuvântul Conducerii">
    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-8">
          <h1 class="text-3xl font-bold text-gray-900 mb-6">Cuvântul Conducerii</h1>
          
          <div class="prose max-w-none content-styling">
            <div class="bg-blue-50 p-8 rounded-lg mb-8">
              <h2 class="text-2xl font-semibold text-blue-900 mb-4">Mesajul Directorului</h2>
              <p class="text-lg text-gray-700 mb-4">
                Dragi elevi, părinți și membri ai comunității educaționale,
              </p>
              <p class="text-gray-700 mb-4">
                Este o onoare și o responsabilitate să conduc această instituție de învățământ cu o tradiție îndelungată în educația tehnică din județul Neamț. Liceul Tehnologic „Vasile Sav" continuă să fie un pilon al educației moderne, adaptându-se constant la cerințele unei societăți în continuă transformare.
              </p>
              <p class="text-gray-700 mb-4">
                Misiunea noastră este să formăm tineri capabili să se adapteze la cerințele pieței muncii, să dezvolte competențe digitale și să devină cetățeni responsabili ai României și ai Europei.
              </p>
              <p class="text-gray-700">
                <strong>Prof. Dr. [Numele Directorului]<br>Director</strong>
              </p>
            </div>
            
            <h2>Echipa de Conducere</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 my-8">
              <div class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm">
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Director</h3>
                <p class="text-gray-600 mb-2">Prof. Dr. [Numele Directorului]</p>
                <p class="text-sm text-gray-500">Responsabil pentru conducerea generală a școlii</p>
              </div>
              <div class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm">
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Director Adjunct</h3>
                <p class="text-gray-600 mb-2">Prof. [Numele Directorului Adjunct]</p>
                <p class="text-sm text-gray-500">Responsabil pentru activitatea didactică</p>
              </div>
              <div class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm">
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Șef Administrativ</h3>
                <p class="text-gray-600 mb-2">[Numele Șefului Administrativ]</p>
                <p class="text-sm text-gray-500">Responsabil pentru administrarea școlii</p>
              </div>
            </div>
            
            <h2>Consiliul de Administrație</h2>
            <p>
              Consiliul de Administrație este format din reprezentanți ai:
            </p>
            <ul>
              <li>Personalului didactic</li>
              <li>Elevilor (Consiliul Elevilor)</li>
              <li>Părinților (Asociația Părinților)</li>
              <li>Comunității locale</li>
            </ul>
            
            <h2>Contact Conducere</h2>
            <div class="bg-gray-50 p-6 rounded-lg">
              <p class="text-gray-700 mb-2">
                <strong>Email:</strong> conducere@ltvs.ro
              </p>
              <p class="text-gray-700 mb-2">
                <strong>Telefon:</strong> +40 233 123 456
              </p>
              <p class="text-gray-700">
                <strong>Program:</strong> Luni - Vineri: 8:00 - 16:00
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </FrontendLayout>
</template>

<script setup>
import FrontendLayout from '@/Layouts/FrontendLayout.vue'
</script>
