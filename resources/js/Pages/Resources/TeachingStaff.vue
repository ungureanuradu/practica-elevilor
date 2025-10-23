<template>
  <FrontendLayout title="Personal Didactic">
    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-8">
          <h1 class="text-3xl font-bold text-gray-900 mb-6">Personal Didactic</h1>
          
          <div class="prose max-w-none content-styling">
            <h2>Echipa Didactică</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 my-8">
              <div class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm">
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Prof. Dr. [Numele]</h3>
                <p class="text-gray-600 mb-2">Matematică-Informatică</p>
                <p class="text-sm text-gray-500">Șef catedră</p>
              </div>
              <div class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm">
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Prof. [Numele]</h3>
                <p class="text-gray-600 mb-2">Limba și literatura română</p>
                <p class="text-sm text-gray-500">Profesor titular</p>
              </div>
              <div class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm">
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Prof. [Numele]</h3>
                <p class="text-gray-600 mb-2">Limba engleză</p>
                <p class="text-sm text-gray-500">Profesor titular</p>
              </div>
              <div class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm">
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Prof. [Numele]</h3>
                <p class="text-gray-600 mb-2">Fizică</p>
                <p class="text-sm text-gray-500">Profesor titular</p>
              </div>
              <div class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm">
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Prof. [Numele]</h3>
                <p class="text-gray-600 mb-2">Chimie</p>
                <p class="text-sm text-gray-500">Profesor titular</p>
              </div>
              <div class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm">
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Prof. [Numele]</h3>
                <p class="text-gray-600 mb-2">Biologie</p>
                <p class="text-sm text-gray-500">Profesor titular</p>
              </div>
            </div>
            
            <h2>Statistici Personal Didactic</h2>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 my-8">
              <div class="bg-blue-50 p-4 rounded-lg text-center">
                <div class="text-2xl font-bold text-blue-600">25</div>
                <div class="text-sm text-gray-600">Profesori titulari</div>
              </div>
              <div class="bg-green-50 p-4 rounded-lg text-center">
                <div class="text-2xl font-bold text-green-600">8</div>
                <div class="text-sm text-gray-600">Profesori doctori</div>
              </div>
              <div class="bg-purple-50 p-4 rounded-lg text-center">
                <div class="text-2xl font-bold text-purple-600">5</div>
                <div class="text-sm text-gray-600">Profesori debutanți</div>
              </div>
              <div class="bg-orange-50 p-4 rounded-lg text-center">
                <div class="text-2xl font-bold text-orange-600">12</div>
                <div class="text-sm text-gray-600">Ani experiență medie</div>
              </div>
            </div>
            
            <h2>Formare Continuă</h2>
            <div class="bg-gray-50 p-6 rounded-lg">
              <h3 class="text-lg font-semibold text-gray-900 mb-4">Programe de Dezvoltare Profesională</h3>
              <ul class="list-disc list-inside text-gray-700 space-y-2">
                <li>Cursuri de specializare în domeniul de competență</li>
                <li>Workshop-uri de inovație pedagogică</li>
                <li>Formare în utilizarea tehnologiilor educaționale</li>
                <li>Participarea la conferințe și simpozioane educaționale</li>
                <li>Programe de schimb de experiență cu alte școli</li>
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
