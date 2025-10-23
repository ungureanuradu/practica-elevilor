<template>
  <FrontendLayout title="Comunicări">
    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-8">
          <h1 class="text-3xl font-bold text-gray-900 mb-6">Comunicări</h1>
          
          <div class="prose max-w-none content-styling">
            <h2>Comunicări Oficiale</h2>
            <div class="bg-blue-50 p-6 rounded-lg mb-8">
              <h3 class="text-xl font-semibold text-blue-900 mb-4">Ultimele Comunicări</h3>
              <div class="space-y-4">
                <div class="border-l-4 border-blue-500 pl-4">
                  <h4 class="font-semibold text-gray-900">Comunicat privind organizarea anului școlar 2024-2025</h4>
                  <p class="text-sm text-gray-600">Data: 15 august 2024</p>
                </div>
                <div class="border-l-4 border-green-500 pl-4">
                  <h4 class="font-semibold text-gray-900">Programul de înscrieri pentru clasa a IX-a</h4>
                  <p class="text-sm text-gray-600">Data: 10 iulie 2024</p>
                </div>
                <div class="border-l-4 border-orange-500 pl-4">
                  <h4 class="font-semibold text-gray-900">Modificări în orarul școlar</h4>
                  <p class="text-sm text-gray-600">Data: 5 septembrie 2024</p>
                </div>
              </div>
            </div>
            
            <h2>Canale de Comunicare</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 my-8">
              <div class="bg-white border border-gray-200 rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-3">Website Școlii</h3>
                <p class="text-gray-700 mb-3">Informații actualizate despre activitățile școlii</p>
                <p class="text-blue-600 font-medium">www.ltvs.ro</p>
              </div>
              <div class="bg-white border border-gray-200 rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-3">Email Oficial</h3>
                <p class="text-gray-700 mb-3">Pentru comunicări oficiale</p>
                <p class="text-blue-600 font-medium">contact@ltvs.ro</p>
              </div>
              <div class="bg-white border border-gray-200 rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-3">Telefon</h3>
                <p class="text-gray-700 mb-3">Program: Luni - Vineri, 8:00 - 16:00</p>
                <p class="text-blue-600 font-medium">+40 233 123 456</p>
              </div>
              <div class="bg-white border border-gray-200 rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-3">Facebook</h3>
                <p class="text-gray-700 mb-3">Pentru știri și evenimente</p>
                <p class="text-blue-600 font-medium">@LTVasileSav</p>
              </div>
            </div>
            
            <h2>Proceduri de Comunicare</h2>
            <div class="bg-gray-50 p-6 rounded-lg">
              <h3 class="text-lg font-semibold text-gray-900 mb-4">Pentru Părinți</h3>
              <ul class="list-disc list-inside text-gray-700 space-y-2">
                <li>Comunicările urgente se transmit prin telefon</li>
                <li>Informațiile generale se publică pe website</li>
                <li>Evenimentele importante se anunță cu 48h înainte</li>
                <li>Modificările de orar se comunică prin email</li>
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
