<template>
  <FrontendLayout title="Conducerea">
    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-8">
          <h1 class="text-3xl font-bold text-gray-900 mb-6">Conducerea Școlii</h1>
          
          <div class="prose max-w-none content-styling">
            <h2>Echipa de Conducere</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 my-8">
              <div class="bg-blue-50 p-6 rounded-lg">
                <h3 class="text-xl font-semibold text-blue-900 mb-3">Director</h3>
                <p class="text-lg font-medium text-gray-900 mb-2">Prof. Dr. [Numele Directorului]</p>
                <p class="text-gray-700 mb-3">Responsabil pentru conducerea generală a școlii</p>
                <p class="text-sm text-gray-600">
                  <strong>Email:</strong> director@ltvs.ro<br>
                  <strong>Telefon:</strong> +40 233 123 456
                </p>
              </div>
              <div class="bg-green-50 p-6 rounded-lg">
                <h3 class="text-xl font-semibold text-green-900 mb-3">Director Adjunct</h3>
                <p class="text-lg font-medium text-gray-900 mb-2">Prof. [Numele Directorului Adjunct]</p>
                <p class="text-gray-700 mb-3">Responsabil pentru activitatea didactică</p>
                <p class="text-sm text-gray-600">
                  <strong>Email:</strong> adjunct@ltvs.ro<br>
                  <strong>Telefon:</strong> +40 233 123 457
                </p>
              </div>
            </div>
            
            <h2>Responsabilități</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 my-8">
              <div>
                <h3 class="text-lg font-semibold text-gray-900 mb-3">Director</h3>
                <ul class="list-disc list-inside text-gray-700 space-y-2">
                  <li>Conducerea generală a școlii</li>
                  <li>Reprezentarea școlii în relațiile externe</li>
                  <li>Elaborarea planurilor de dezvoltare</li>
                  <li>Coordonarea activităților educaționale</li>
                  <li>Gestionarea resurselor umane și materiale</li>
                </ul>
              </div>
              <div>
                <h3 class="text-lg font-semibold text-gray-900 mb-3">Director Adjunct</h3>
                <ul class="list-disc list-inside text-gray-700 space-y-2">
                  <li>Coordonarea activității didactice</li>
                  <li>Supravegherea programelor de studii</li>
                  <li>Coordonarea evaluării elevilor</li>
                  <li>Organizarea activităților extracurriculare</li>
                  <li>Colaborarea cu personalul didactic</li>
                </ul>
              </div>
            </div>
            
            <h2>Program de Audiențe</h2>
            <div class="bg-gray-50 p-6 rounded-lg">
              <h3 class="text-lg font-semibold text-gray-900 mb-4">Program pentru Părinți și Elevi</h3>
              <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                  <p class="font-medium text-gray-900">Luni - Vineri</p>
                  <p class="text-gray-700">8:00 - 16:00</p>
                </div>
                <div>
                  <p class="font-medium text-gray-900">Program special</p>
                  <p class="text-gray-700">Marți: 16:00 - 18:00 (pentru părinți)</p>
                </div>
              </div>
              <p class="text-sm text-gray-600 mt-4">
                <strong>Notă:</strong> Pentru programări, vă rugăm să contactați în prealabil prin telefon sau email.
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
