<template>
  <FrontendLayout title="Galerie Foto">
    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-8">
          <h1 class="text-3xl font-bold text-gray-900 mb-6">Galerie Foto</h1>
          
          <div class="prose max-w-none content-styling">
            <p class="text-lg text-gray-700 mb-8">
              Descoperiți viața școlară prin imaginile din galeria noastră. Momentele importante, activitățile educaționale și evenimentele speciale care marchează anul școlar.
            </p>
            
            <h2>Evenimente Școlare</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
              <div class="bg-gray-200 h-48 rounded-lg flex items-center justify-center">
                <span class="text-gray-500">Imagine 1 - Ziua Școlii</span>
              </div>
              <div class="bg-gray-200 h-48 rounded-lg flex items-center justify-center">
                <span class="text-gray-500">Imagine 2 - Ceremonia de Absolvire</span>
              </div>
              <div class="bg-gray-200 h-48 rounded-lg flex items-center justify-center">
                <span class="text-gray-500">Imagine 3 - Olimpiada Școlară</span>
              </div>
              <div class="bg-gray-200 h-48 rounded-lg flex items-center justify-center">
                <span class="text-gray-500">Imagine 4 - Laboratorul de Informatică</span>
              </div>
              <div class="bg-gray-200 h-48 rounded-lg flex items-center justify-center">
                <span class="text-gray-500">Imagine 5 - Biblioteca Școlii</span>
              </div>
              <div class="bg-gray-200 h-48 rounded-lg flex items-center justify-center">
                <span class="text-gray-500">Imagine 6 - Sala de Sport</span>
              </div>
            </div>
            
            <h2>Instalații Școlare</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
              <div class="bg-gray-200 h-64 rounded-lg flex items-center justify-center">
                <span class="text-gray-500">Imagine - Clădirea Principală</span>
              </div>
              <div class="bg-gray-200 h-64 rounded-lg flex items-center justify-center">
                <span class="text-gray-500">Imagine - Curtea Școlii</span>
              </div>
            </div>
            
            <h2>Activități Educaționale</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
              <div class="bg-gray-200 h-32 rounded-lg flex items-center justify-center">
                <span class="text-gray-500 text-sm">Laborator Chimie</span>
              </div>
              <div class="bg-gray-200 h-32 rounded-lg flex items-center justify-center">
                <span class="text-gray-500 text-sm">Laborator Fizică</span>
              </div>
              <div class="bg-gray-200 h-32 rounded-lg flex items-center justify-center">
                <span class="text-gray-500 text-sm">Laborator Biologie</span>
              </div>
              <div class="bg-gray-200 h-32 rounded-lg flex items-center justify-center">
                <span class="text-gray-500 text-sm">Laborator IT</span>
              </div>
            </div>
            
            <div class="bg-blue-50 p-6 rounded-lg">
              <h3 class="text-xl font-semibold text-blue-900 mb-3">Contribuiți la Galerie</h3>
              <p class="text-gray-700 mb-4">
                Dacă aveți fotografii cu evenimente școlare sau activități educaționale, vă rugăm să le trimiteți la:
              </p>
              <p class="text-blue-600 font-medium">
                Email: galerie@ltvs.ro
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
