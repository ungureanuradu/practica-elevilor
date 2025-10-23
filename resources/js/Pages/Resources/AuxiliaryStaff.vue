<template>
  <FrontendLayout title="Personal Didactic Auxiliar">
    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-8">
          <h1 class="text-3xl font-bold text-gray-900 mb-6">Personal Didactic Auxiliar</h1>
          
          <div class="prose max-w-none content-styling">
            <h2>Echipa de Suport Educațional</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 my-8">
              <div class="bg-blue-50 p-6 rounded-lg">
                <h3 class="text-xl font-semibold text-blue-900 mb-3">Psiholog Școlar</h3>
                <p class="text-gray-700 mb-2">Psiholog: [Numele Psihologului]</p>
                <p class="text-sm text-gray-600 mb-3">Responsabilități:</p>
                <ul class="text-sm text-gray-600 space-y-1">
                  <li>• Consiliere psihologică pentru elevi</li>
                  <li>• Orientare profesională</li>
                  <li>• Sprijin pentru probleme de învățare</li>
                  <li>• Colaborare cu părinții</li>
                </ul>
              </div>
              <div class="bg-green-50 p-6 rounded-lg">
                <h3 class="text-xl font-semibold text-green-900 mb-3">Bibliotecar</h3>
                <p class="text-gray-700 mb-2">Bibliotecar: [Numele Bibliotecarului]</p>
                <p class="text-sm text-gray-600 mb-3">Responsabilități:</p>
                <ul class="text-sm text-gray-600 space-y-1">
                  <li>• Gestionarea bibliotecii școlare</li>
                  <li>• Organizarea activităților de lectură</li>
                  <li>• Sprijin pentru cercetare școlară</li>
                  <li>• Promovarea lecturii</li>
                </ul>
              </div>
              <div class="bg-purple-50 p-6 rounded-lg">
                <h3 class="text-xl font-semibold text-purple-900 mb-3">Asistent Social</h3>
                <p class="text-gray-700 mb-2">Asistent social: [Numele Asistentului]</p>
                <p class="text-sm text-gray-600 mb-3">Responsabilități:</p>
                <ul class="text-sm text-gray-600 space-y-1">
                  <li>• Sprijin pentru familiile în dificultate</li>
                  <li>• Colaborare cu serviciile sociale</li>
                  <li>• Organizarea de programe de sprijin</li>
                  <li>• Monitorizarea situației elevilor</li>
                </ul>
              </div>
              <div class="bg-orange-50 p-6 rounded-lg">
                <h3 class="text-xl font-semibold text-orange-900 mb-3">Educator</h3>
                <p class="text-gray-700 mb-2">Educator: [Numele Educatorului]</p>
                <p class="text-sm text-gray-600 mb-3">Responsabilități:</p>
                <ul class="text-sm text-gray-600 space-y-1">
                  <li>• Supravegherea elevilor în pauze</li>
                  <li>• Organizarea activităților extracurriculare</li>
                  <li>• Sprijin pentru disciplina școlară</li>
                  <li>• Colaborare cu profesorii</li>
                </ul>
              </div>
            </div>
            
            <h2>Servicii de Suport</h2>
            <div class="bg-gray-50 p-6 rounded-lg">
              <h3 class="text-lg font-semibold text-gray-900 mb-4">Programe de Sprijin</h3>
              <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                  <h4 class="font-semibold text-gray-900 mb-2">Consiliere Psihologică</h4>
                  <p class="text-sm text-gray-600">Program: Luni - Vineri, 8:00 - 16:00</p>
                  <p class="text-sm text-gray-600">Email: psiholog@ltvs.ro</p>
                </div>
                <div>
                  <h4 class="font-semibold text-gray-900 mb-2">Biblioteca Școlară</h4>
                  <p class="text-sm text-gray-600">Program: Luni - Vineri, 8:00 - 16:00</p>
                  <p class="text-sm text-gray-600">Email: biblioteca@ltvs.ro</p>
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
