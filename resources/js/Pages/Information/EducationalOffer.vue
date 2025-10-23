<template>
  <FrontendLayout title="Oferta Educațională">
    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-8">
          <h1 class="text-3xl font-bold text-gray-900 mb-6">Oferta Educațională</h1>
          
          <div class="prose max-w-none content-styling">
            <h2>Programe de Studii</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 my-8">
              <div class="bg-blue-50 p-6 rounded-lg">
                <h3 class="text-xl font-semibold text-blue-900 mb-3">Informatică</h3>
                <p class="text-gray-700 mb-3">Program de studii cu profil informatic</p>
                <ul class="text-sm text-gray-600 space-y-1">
                  <li>• Programare și algoritmi</li>
                  <li>• Baze de date</li>
                  <li>• Rețele de calculatoare</li>
                  <li>• Dezvoltare web</li>
                </ul>
              </div>
              <div class="bg-green-50 p-6 rounded-lg">
                <h3 class="text-xl font-semibold text-green-900 mb-3">Matematică-Informatică</h3>
                <p class="text-gray-700 mb-3">Program de studii cu profil matematică-informatică</p>
                <ul class="text-sm text-gray-600 space-y-1">
                  <li>• Matematică avansată</li>
                  <li>• Fizică</li>
                  <li>• Informatică</li>
                  <li>• Chimie</li>
                </ul>
              </div>
              <div class="bg-purple-50 p-6 rounded-lg">
                <h3 class="text-xl font-semibold text-purple-900 mb-3">Științe ale Naturii</h3>
                <p class="text-gray-700 mb-3">Program de studii cu profil științe ale naturii</p>
                <ul class="text-sm text-gray-600 space-y-1">
                  <li>• Biologie</li>
                  <li>• Chimie</li>
                  <li>• Fizică</li>
                  <li>• Geografie</li>
                </ul>
              </div>
              <div class="bg-orange-50 p-6 rounded-lg">
                <h3 class="text-xl font-semibold text-orange-900 mb-3">Filologie</h3>
                <p class="text-gray-700 mb-3">Program de studii cu profil filologie</p>
                <ul class="text-sm text-gray-600 space-y-1">
                  <li>• Limba și literatura română</li>
                  <li>• Limba engleză</li>
                  <li>• Limba franceză</li>
                  <li>• Istorie</li>
                </ul>
              </div>
            </div>
            
            <h2>Activități Extracurriculare</h2>
            <div class="bg-gray-50 p-6 rounded-lg">
              <h3 class="text-lg font-semibold text-gray-900 mb-4">Cluburi și Asociații</h3>
              <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="text-center">
                  <h4 class="font-semibold text-gray-900">Clubul de Informatică</h4>
                  <p class="text-sm text-gray-600">Programare și robotică</p>
                </div>
                <div class="text-center">
                  <h4 class="font-semibold text-gray-900">Clubul de Științe</h4>
                  <p class="text-sm text-gray-600">Experimente și proiecte</p>
                </div>
                <div class="text-center">
                  <h4 class="font-semibold text-gray-900">Clubul de Limbi Străine</h4>
                  <p class="text-sm text-gray-600">Engleză, franceză, germană</p>
                </div>
              </div>
            </div>
            
            <h2>Instalații și Echipamente</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 my-8">
              <div>
                <h3 class="text-lg font-semibold text-gray-900 mb-3">Laboratoare</h3>
                <ul class="list-disc list-inside text-gray-700 space-y-2">
                  <li>Laborator de Informatică (30 calculatoare)</li>
                  <li>Laborator de Fizică</li>
                  <li>Laborator de Chimie</li>
                  <li>Laborator de Biologie</li>
                </ul>
              </div>
              <div>
                <h3 class="text-lg font-semibold text-gray-900 mb-3">Alte Instalații</h3>
                <ul class="list-disc list-inside text-gray-700 space-y-2">
                  <li>Bibliotecă cu 5000+ volume</li>
                  <li>Sala de sport</li>
                  <li>Cantină școlară</li>
                  <li>Curte pentru activități în aer liber</li>
                </ul>
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
