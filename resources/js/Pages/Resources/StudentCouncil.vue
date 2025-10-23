<template>
  <FrontendLayout title="Consiliul Elevilor">
    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-8">
          <h1 class="text-3xl font-bold text-gray-900 mb-6">Consiliul Elevilor</h1>
          
          <div class="prose max-w-none content-styling">
            <h2>Echipa Consiliului Elevilor</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 my-8">
              <div class="bg-blue-50 p-6 rounded-lg">
                <h3 class="text-xl font-semibold text-blue-900 mb-3">Președinte</h3>
                <p class="text-lg font-medium text-gray-900 mb-2">[Numele Președintelui]</p>
                <p class="text-gray-700 mb-3">Clasa a XII-a</p>
                <p class="text-sm text-gray-600">Responsabil pentru conducerea consiliului și reprezentarea elevilor</p>
              </div>
              <div class="bg-green-50 p-6 rounded-lg">
                <h3 class="text-xl font-semibold text-green-900 mb-3">Vicepreședinte</h3>
                <p class="text-lg font-medium text-gray-900 mb-2">[Numele Vicepreședintelui]</p>
                <p class="text-gray-700 mb-3">Clasa a XI-a</p>
                <p class="text-sm text-gray-600">Sprijină președintele și coordonează activitățile</p>
              </div>
              <div class="bg-purple-50 p-6 rounded-lg">
                <h3 class="text-xl font-semibold text-purple-900 mb-3">Secretar</h3>
                <p class="text-lg font-medium text-gray-900 mb-2">[Numele Secretarului]</p>
                <p class="text-gray-700 mb-3">Clasa a X-a</p>
                <p class="text-sm text-gray-600">Întocmește procesele verbale și menține arhiva</p>
              </div>
              <div class="bg-orange-50 p-6 rounded-lg">
                <h3 class="text-xl font-semibold text-orange-900 mb-3">Trezorier</h3>
                <p class="text-lg font-medium text-gray-900 mb-2">[Numele Trezorierului]</p>
                <p class="text-gray-700 mb-3">Clasa a XI-a</p>
                <p class="text-sm text-gray-600">Gestionează fondurile consiliului</p>
              </div>
            </div>
            
            <h2>Reprezentanți pe Clase</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 my-8">
              <div class="bg-white border border-gray-200 rounded-lg p-4 shadow-sm">
                <h4 class="font-semibold text-gray-900 mb-2">Clasa a IX-a</h4>
                <p class="text-sm text-gray-600">Reprezentant: [Numele]</p>
                <p class="text-sm text-gray-600">Supleant: [Numele]</p>
              </div>
              <div class="bg-white border border-gray-200 rounded-lg p-4 shadow-sm">
                <h4 class="font-semibold text-gray-900 mb-2">Clasa a X-a</h4>
                <p class="text-sm text-gray-600">Reprezentant: [Numele]</p>
                <p class="text-sm text-gray-600">Supleant: [Numele]</p>
              </div>
              <div class="bg-white border border-gray-200 rounded-lg p-4 shadow-sm">
                <h4 class="font-semibold text-gray-900 mb-2">Clasa a XI-a</h4>
                <p class="text-sm text-gray-600">Reprezentant: [Numele]</p>
                <p class="text-sm text-gray-600">Supleant: [Numele]</p>
              </div>
              <div class="bg-white border border-gray-200 rounded-lg p-4 shadow-sm">
                <h4 class="font-semibold text-gray-900 mb-2">Clasa a XII-a</h4>
                <p class="text-sm text-gray-600">Reprezentant: [Numele]</p>
                <p class="text-sm text-gray-600">Supleant: [Numele]</p>
              </div>
            </div>
            
            <h2>Activități și Proiecte</h2>
            <div class="bg-gray-50 p-6 rounded-lg">
              <h3 class="text-lg font-semibold text-gray-900 mb-4">Programe Organizate</h3>
              <ul class="list-disc list-inside text-gray-700 space-y-2">
                <li>Ziua Elevului - activități și concursuri</li>
                <li>Campanii de reciclare și protecția mediului</li>
                <li>Organizarea de evenimente culturale</li>
                <li>Proiecte de voluntariat în comunitate</li>
                <li>Colaborarea cu alte școli din județ</li>
                <li>Organizarea de workshop-uri educaționale</li>
              </ul>
            </div>
            
            <h2>Contact Consiliul Elevilor</h2>
            <div class="bg-blue-50 p-6 rounded-lg">
              <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                  <p class="font-medium text-gray-900">Email oficial</p>
                  <p class="text-blue-600">consiliul.elevilor@ltvs.ro</p>
                </div>
                <div>
                  <p class="font-medium text-gray-900">Program ședințe</p>
                  <p class="text-gray-600">Marți, ora 13:00 - 14:00</p>
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
