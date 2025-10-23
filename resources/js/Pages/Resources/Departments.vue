<template>
  <FrontendLayout title="Catedre">
    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-8">
          <h1 class="text-3xl font-bold text-gray-900 mb-6">Catedre</h1>
          
          <div class="prose max-w-none content-styling">
            <h2>Structura Catedrelor</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 my-8">
              <div class="bg-blue-50 p-6 rounded-lg">
                <h3 class="text-xl font-semibold text-blue-900 mb-3">Catedra de Matematică-Informatică</h3>
                <p class="text-gray-700 mb-3">Șef catedră: Prof. [Numele Șefului]</p>
                <ul class="text-sm text-gray-600 space-y-1">
                  <li>• Matematică</li>
                  <li>• Informatică</li>
                  <li>• Fizică</li>
                </ul>
              </div>
              <div class="bg-green-50 p-6 rounded-lg">
                <h3 class="text-xl font-semibold text-green-900 mb-3">Catedra de Științe ale Naturii</h3>
                <p class="text-gray-700 mb-3">Șef catedră: Prof. [Numele Șefului]</p>
                <ul class="text-sm text-gray-600 space-y-1">
                  <li>• Biologie</li>
                  <li>• Chimie</li>
                  <li>• Geografie</li>
                </ul>
              </div>
              <div class="bg-purple-50 p-6 rounded-lg">
                <h3 class="text-xl font-semibold text-purple-900 mb-3">Catedra de Filologie</h3>
                <p class="text-gray-700 mb-3">Șef catedră: Prof. [Numele Șefului]</p>
                <ul class="text-sm text-gray-600 space-y-1">
                  <li>• Limba și literatura română</li>
                  <li>• Limba engleză</li>
                  <li>• Limba franceză</li>
                </ul>
              </div>
              <div class="bg-orange-50 p-6 rounded-lg">
                <h3 class="text-xl font-semibold text-orange-900 mb-3">Catedra de Istorie și Științe Sociale</h3>
                <p class="text-gray-700 mb-3">Șef catedră: Prof. [Numele Șefului]</p>
                <ul class="text-sm text-gray-600 space-y-1">
                  <li>• Istorie</li>
                  <li>• Geografie</li>
                  <li>• Educație civică</li>
                </ul>
              </div>
            </div>
            
            <h2>Responsabilități ale Catedrelor</h2>
            <div class="bg-gray-50 p-6 rounded-lg">
              <ul class="list-disc list-inside text-gray-700 space-y-2">
                <li>Elaborarea programelor de studii specifice</li>
                <li>Coordonarea activității didactice în domeniul respectiv</li>
                <li>Organizarea concursurilor și olimpiadelor școlare</li>
                <li>Dezvoltarea materialelor didactice</li>
                <li>Formarea continuă a profesorilor</li>
              </ul>
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
