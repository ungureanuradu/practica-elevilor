<template>
  <FrontendLayout title="Comisii">
    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-8">
          <h1 class="text-3xl font-bold text-gray-900 mb-6">Comisii</h1>
          
          <div class="prose max-w-none content-styling">
            <h2>Comisii Școlare</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 my-8">
              <div class="bg-blue-50 p-6 rounded-lg">
                <h3 class="text-xl font-semibold text-blue-900 mb-3">Comisia de Disciplină</h3>
                <p class="text-gray-700 mb-3">Președinte: Prof. [Numele Președintelui]</p>
                <p class="text-sm text-gray-600 mb-3">Membri:</p>
                <ul class="text-sm text-gray-600 space-y-1">
                  <li>• Prof. [Numele] - Matematică</li>
                  <li>• Prof. [Numele] - Limba română</li>
                  <li>• Reprezentant Consiliul Elevilor</li>
                </ul>
              </div>
              <div class="bg-green-50 p-6 rounded-lg">
                <h3 class="text-xl font-semibold text-green-900 mb-3">Comisia de Evaluare</h3>
                <p class="text-gray-700 mb-3">Președinte: Prof. [Numele Președintelui]</p>
                <p class="text-sm text-gray-600 mb-3">Membri:</p>
                <ul class="text-sm text-gray-600 space-y-1">
                  <li>• Prof. [Numele] - Informatică</li>
                  <li>• Prof. [Numele] - Fizică</li>
                  <li>• Prof. [Numele] - Chimie</li>
                </ul>
              </div>
              <div class="bg-purple-50 p-6 rounded-lg">
                <h3 class="text-xl font-semibold text-purple-900 mb-3">Comisia de Admisii</h3>
                <p class="text-gray-700 mb-3">Președinte: Prof. [Numele Președintelui]</p>
                <p class="text-sm text-gray-600 mb-3">Membri:</p>
                <ul class="text-sm text-gray-600 space-y-1">
                  <li>• Prof. [Numele] - Matematică</li>
                  <li>• Prof. [Numele] - Limba română</li>
                  <li>• Reprezentant Asociația Părinților</li>
                </ul>
              </div>
              <div class="bg-orange-50 p-6 rounded-lg">
                <h3 class="text-xl font-semibold text-orange-900 mb-3">Comisia de Olimpiade</h3>
                <p class="text-gray-700 mb-3">Președinte: Prof. [Numele Președintelui]</p>
                <p class="text-sm text-gray-600 mb-3">Membri:</p>
                <ul class="text-sm text-gray-600 space-y-1">
                  <li>• Prof. [Numele] - Informatică</li>
                  <li>• Prof. [Numele] - Matematică</li>
                  <li>• Prof. [Numele] - Fizică</li>
                </ul>
              </div>
            </div>
            
            <h2>Responsabilități ale Comisiilor</h2>
            <div class="bg-gray-50 p-6 rounded-lg">
              <h3 class="text-lg font-semibold text-gray-900 mb-4">Funcții Principale</h3>
              <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                  <h4 class="font-semibold text-gray-900 mb-2">Comisia de Disciplină</h4>
                  <ul class="text-sm text-gray-600 space-y-1">
                    <li>• Analizează cazurile de indisciplină</li>
                    <li>• Propune măsuri educative</li>
                    <li>• Monitorizează comportamentul elevilor</li>
                  </ul>
                </div>
                <div>
                  <h4 class="font-semibold text-gray-900 mb-2">Comisia de Evaluare</h4>
                  <ul class="text-sm text-gray-600 space-y-1">
                    <li>• Coordonează procesul de evaluare</li>
                    <li>• Elaborează teste și examene</li>
                    <li>• Monitorizează progresul elevilor</li>
                  </ul>
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
