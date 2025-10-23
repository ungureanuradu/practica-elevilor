<template>
  <FrontendLayout title="Examene Naționale">
    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-8">
          <h1 class="text-3xl font-bold text-gray-900 mb-6">Examene Naționale</h1>
          
          <div class="prose max-w-none content-styling">
            <h2>Calendarul Examenelor Naționale 2024-2025</h2>
            <div class="bg-blue-50 p-6 rounded-lg mb-8">
              <h3 class="text-xl font-semibold text-blue-900 mb-4">Perioada de Desfășurare</h3>
              <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                  <p class="font-medium text-gray-900">Evaluarea Națională (clasa a VIII-a)</p>
                  <p class="text-sm text-gray-600">Iunie 2025</p>
                </div>
                <div>
                  <p class="font-medium text-gray-900">Bacalaureat (clasa a XII-a)</p>
                  <p class="text-sm text-gray-600">Iunie-Iulie 2025</p>
                </div>
              </div>
            </div>
            
            <h2>Discipline de Examen</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 my-8">
              <div class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm">
                <h3 class="text-lg font-semibold text-gray-900 mb-3">Evaluarea Națională</h3>
                <ul class="text-sm text-gray-600 space-y-2">
                  <li>• Limba și literatura română</li>
                  <li>• Matematică</li>
                  <li>• Limba maternă (pentru minorități)</li>
                </ul>
              </div>
              <div class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm">
                <h3 class="text-lg font-semibold text-gray-900 mb-3">Bacalaureat</h3>
                <ul class="text-sm text-gray-600 space-y-2">
                  <li>• Limba și literatura română</li>
                  <li>• Matematică sau Istoria României</li>
                  <li>• Limba străină</li>
                  <li>• Proba de profil (conform specializării)</li>
                </ul>
              </div>
            </div>
            
            <h2>Proceduri de Înscriere</h2>
            <div class="bg-gray-50 p-6 rounded-lg">
              <h3 class="text-lg font-semibold text-gray-900 mb-4">Pași pentru Înscriere</h3>
              <ol class="list-decimal list-inside text-gray-700 space-y-2">
                <li>Completarea formularului de înscriere online</li>
                <li>Depunerea documentelor necesare</li>
                <li>Plata taxei de înscriere (dacă este cazul)</li>
                <li>Confirmarea înscrierii prin email</li>
                <li>Primirea biletului de examen</li>
              </ol>
            </div>
            
            <h2>Documente Necesare</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 my-8">
              <div>
                <h3 class="text-lg font-semibold text-gray-900 mb-3">Pentru Evaluarea Națională</h3>
                <ul class="list-disc list-inside text-sm text-gray-600 space-y-1">
                  <li>Cererea de înscriere</li>
                  <li>Copie după certificatul de naștere</li>
                  <li>Copie după buletinul de identitate</li>
                  <li>Fotografie 3x4 (2 bucăți)</li>
                </ul>
              </div>
              <div>
                <h3 class="text-lg font-semibold text-gray-900 mb-3">Pentru Bacalaureat</h3>
                <ul class="list-disc list-inside text-sm text-gray-600 space-y-1">
                  <li>Cererea de înscriere</li>
                  <li>Copie după certificatul de naștere</li>
                  <li>Copie după buletinul de identitate</li>
                  <li>Fotografie 3x4 (2 bucăți)</li>
                  <li>Certificatul de absolvire a clasei a XII-a</li>
                </ul>
              </div>
            </div>
            
            <h2>Rezultate și Contestații</h2>
            <div class="bg-green-50 p-6 rounded-lg">
              <h3 class="text-lg font-semibold text-green-900 mb-4">Proceduri Post-Examen</h3>
              <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                  <p class="font-medium text-gray-900">Publicarea rezultatelor</p>
                  <p class="text-sm text-gray-600">În termen de 30 de zile de la susținerea examenului</p>
                </div>
                <div>
                  <p class="font-medium text-gray-900">Perioada de contestație</p>
                  <p class="text-sm text-gray-600">3 zile de la publicarea rezultatelor</p>
                </div>
              </div>
            </div>
            
            <h2>Contact și Informații</h2>
            <div class="bg-blue-50 p-6 rounded-lg">
              <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                  <p class="font-medium text-gray-900">Email oficial</p>
                  <p class="text-blue-600">examene@ltvs.ro</p>
                </div>
                <div>
                  <p class="font-medium text-gray-900">Telefon</p>
                  <p class="text-gray-600">+40 233 123 456</p>
                </div>
              </div>
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
