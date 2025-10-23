<template>
  <FrontendLayout title="Consiliul de Administrație">
    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-8">
          <h1 class="text-3xl font-bold text-gray-900 mb-6">Consiliul de Administrație</h1>
          
          <div class="prose max-w-none content-styling">
            <h2>Membrii Consiliului de Administrație</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 my-8">
              <div class="bg-blue-50 p-6 rounded-lg">
                <h3 class="text-xl font-semibold text-blue-900 mb-3">Președinte</h3>
                <p class="text-lg font-medium text-gray-900 mb-2">Prof. Dr. [Numele Președintelui]</p>
                <p class="text-gray-700 mb-3">Director al școlii</p>
                <p class="text-sm text-gray-600">Responsabil pentru conducerea generală a școlii</p>
              </div>
              <div class="bg-green-50 p-6 rounded-lg">
                <h3 class="text-xl font-semibold text-green-900 mb-3">Vicepreședinte</h3>
                <p class="text-lg font-medium text-gray-900 mb-2">Prof. [Numele Vicepreședintelui]</p>
                <p class="text-gray-700 mb-3">Director adjunct</p>
                <p class="text-sm text-gray-600">Responsabil pentru activitatea didactică</p>
              </div>
            </div>
            
            <h2>Reprezentanți în Consiliu</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 my-8">
              <div class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm">
                <h3 class="text-lg font-semibold text-gray-900 mb-3">Personal Didactic</h3>
                <ul class="text-sm text-gray-600 space-y-2">
                  <li>• Prof. [Numele] - Matematică</li>
                  <li>• Prof. [Numele] - Informatică</li>
                  <li>• Prof. [Numele] - Limba română</li>
                </ul>
              </div>
              <div class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm">
                <h3 class="text-lg font-semibold text-gray-900 mb-3">Consiliul Elevilor</h3>
                <ul class="text-sm text-gray-600 space-y-2">
                  <li>• [Numele] - Președinte Consiliul Elevilor</li>
                  <li>• [Numele] - Vicepreședinte</li>
                  <li>• [Numele] - Secretar</li>
                </ul>
              </div>
              <div class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm">
                <h3 class="text-lg font-semibold text-gray-900 mb-3">Asociația Părinților</h3>
                <ul class="text-sm text-gray-600 space-y-2">
                  <li>• [Numele] - Președinte Asociația Părinților</li>
                  <li>• [Numele] - Vicepreședinte</li>
                  <li>• [Numele] - Secretar</li>
                </ul>
              </div>
            </div>
            
            <h2>Responsabilități ale Consiliului</h2>
            <div class="bg-gray-50 p-6 rounded-lg">
              <h3 class="text-lg font-semibold text-gray-900 mb-4">Funcții Principale</h3>
              <ul class="list-disc list-inside text-gray-700 space-y-2">
                <li>Elaborarea și aprobarea planului de dezvoltare al școlii</li>
                <li>Coordonarea activităților educaționale și administrative</li>
                <li>Monitorizarea implementării programelor educaționale</li>
                <li>Colaborarea cu comunitatea locală și instituțiile partenere</li>
                <li>Gestionarea resurselor financiare și materiale</li>
                <li>Organizarea activităților extracurriculare</li>
              </ul>
            </div>
            
            <h2>Program de Lucru</h2>
            <div class="bg-blue-50 p-6 rounded-lg">
              <h3 class="text-lg font-semibold text-blue-900 mb-4">Ședințe Consiliu</h3>
              <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                  <p class="font-medium text-gray-900">Ședințe regulate</p>
                  <p class="text-sm text-gray-600">Prima luni din fiecare lună, ora 16:00</p>
                </div>
                <div>
                  <p class="font-medium text-gray-900">Ședințe extraordinare</p>
                  <p class="text-sm text-gray-600">Convocare cu 48h înainte</p>
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
