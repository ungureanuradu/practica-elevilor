<template>
  <FrontendLayout title="Orarul Școlii">
    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-8">
          <h1 class="text-3xl font-bold text-gray-900 mb-6">Orarul Școlii</h1>
          
          <div class="prose max-w-none content-styling">
            <h2>Programul Zilnic</h2>
            <div class="bg-blue-50 p-6 rounded-lg mb-8">
              <h3 class="text-xl font-semibold text-blue-900 mb-4">Orele de Început și Sfârșit</h3>
              <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                  <p class="font-medium text-gray-900">Începutul orelor</p>
                  <p class="text-lg text-blue-600">8:00</p>
                </div>
                <div>
                  <p class="font-medium text-gray-900">Sfârșitul orelor</p>
                  <p class="text-lg text-blue-600">14:00</p>
                </div>
              </div>
            </div>
            
            <h2>Orarul Detaliat</h2>
            <div class="overflow-x-auto">
              <table class="min-w-full bg-white border border-gray-200 rounded-lg">
                <thead class="bg-gray-50">
                  <tr>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ora</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Luni</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Marți</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Miercuri</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Joi</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Vineri</th>
                  </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                  <tr>
                    <td class="px-4 py-3 text-sm font-medium text-gray-900">8:00 - 8:50</td>
                    <td class="px-4 py-3 text-sm text-gray-600">Matematică</td>
                    <td class="px-4 py-3 text-sm text-gray-600">Limba română</td>
                    <td class="px-4 py-3 text-sm text-gray-600">Informatică</td>
                    <td class="px-4 py-3 text-sm text-gray-600">Fizică</td>
                    <td class="px-4 py-3 text-sm text-gray-600">Chimie</td>
                  </tr>
                  <tr class="bg-gray-50">
                    <td class="px-4 py-3 text-sm font-medium text-gray-900">8:55 - 9:45</td>
                    <td class="px-4 py-3 text-sm text-gray-600">Limba română</td>
                    <td class="px-4 py-3 text-sm text-gray-600">Matematică</td>
                    <td class="px-4 py-3 text-sm text-gray-600">Limba engleză</td>
                    <td class="px-4 py-3 text-sm text-gray-600">Biologie</td>
                    <td class="px-4 py-3 text-sm text-gray-600">Istorie</td>
                  </tr>
                  <tr>
                    <td class="px-4 py-3 text-sm font-medium text-gray-900">9:50 - 10:40</td>
                    <td class="px-4 py-3 text-sm text-gray-600">Limba engleză</td>
                    <td class="px-4 py-3 text-sm text-gray-600">Fizică</td>
                    <td class="px-4 py-3 text-sm text-gray-600">Matematică</td>
                    <td class="px-4 py-3 text-sm text-gray-600">Limba română</td>
                    <td class="px-4 py-3 text-sm text-gray-600">Geografie</td>
                  </tr>
                  <tr class="bg-gray-50">
                    <td class="px-4 py-3 text-sm font-medium text-gray-900">10:45 - 11:35</td>
                    <td class="px-4 py-3 text-sm text-gray-600">Pauză</td>
                    <td class="px-4 py-3 text-sm text-gray-600">Pauză</td>
                    <td class="px-4 py-3 text-sm text-gray-600">Pauză</td>
                    <td class="px-4 py-3 text-sm text-gray-600">Pauză</td>
                    <td class="px-4 py-3 text-sm text-gray-600">Pauză</td>
                  </tr>
                  <tr>
                    <td class="px-4 py-3 text-sm font-medium text-gray-900">11:40 - 12:30</td>
                    <td class="px-4 py-3 text-sm text-gray-600">Chimie</td>
                    <td class="px-4 py-3 text-sm text-gray-600">Biologie</td>
                    <td class="px-4 py-3 text-sm text-gray-600">Istorie</td>
                    <td class="px-4 py-3 text-sm text-gray-600">Informatică</td>
                    <td class="px-4 py-3 text-sm text-gray-600">Limba engleză</td>
                  </tr>
                  <tr class="bg-gray-50">
                    <td class="px-4 py-3 text-sm font-medium text-gray-900">12:35 - 13:25</td>
                    <td class="px-4 py-3 text-sm text-gray-600">Istorie</td>
                    <td class="px-4 py-3 text-sm text-gray-600">Geografie</td>
                    <td class="px-4 py-3 text-sm text-gray-600">Fizică</td>
                    <td class="px-4 py-3 text-sm text-gray-600">Matematică</td>
                    <td class="px-4 py-3 text-sm text-gray-600">Limba română</td>
                  </tr>
                  <tr>
                    <td class="px-4 py-3 text-sm font-medium text-gray-900">13:30 - 14:00</td>
                    <td class="px-4 py-3 text-sm text-gray-600">Activități extracurriculare</td>
                    <td class="px-4 py-3 text-sm text-gray-600">Activități extracurriculare</td>
                    <td class="px-4 py-3 text-sm text-gray-600">Activități extracurriculare</td>
                    <td class="px-4 py-3 text-sm text-gray-600">Activități extracurriculare</td>
                    <td class="px-4 py-3 text-sm text-gray-600">Activități extracurriculare</td>
                  </tr>
                </tbody>
              </table>
            </div>
            
            <h2>Activități Extracurriculare</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 my-8">
              <div class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm">
                <h3 class="text-lg font-semibold text-gray-900 mb-3">Luni</h3>
                <ul class="text-sm text-gray-600 space-y-2">
                  <li>• Clubul de Informatică (13:30 - 14:30)</li>
                  <li>• Clubul de Științe (13:30 - 14:30)</li>
                </ul>
              </div>
              <div class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm">
                <h3 class="text-lg font-semibold text-gray-900 mb-3">Marți</h3>
                <ul class="text-sm text-gray-600 space-y-2">
                  <li>• Clubul de Limbi Străine (13:30 - 14:30)</li>
                  <li>• Clubul de Sport (13:30 - 14:30)</li>
                </ul>
              </div>
              <div class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm">
                <h3 class="text-lg font-semibold text-gray-900 mb-3">Miercuri</h3>
                <ul class="text-sm text-gray-600 space-y-2">
                  <li>• Clubul de Artă (13:30 - 14:30)</li>
                  <li>• Clubul de Muzică (13:30 - 14:30)</li>
                </ul>
              </div>
              <div class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm">
                <h3 class="text-lg font-semibold text-gray-900 mb-3">Joi</h3>
                <ul class="text-sm text-gray-600 space-y-2">
                  <li>• Clubul de Istorie (13:30 - 14:30)</li>
                  <li>• Clubul de Geografie (13:30 - 14:30)</li>
                </ul>
              </div>
            </div>
            
            <h2>Modificări de Orar</h2>
            <div class="bg-yellow-50 p-6 rounded-lg">
              <h3 class="text-lg font-semibold text-yellow-900 mb-4">Informații Importante</h3>
              <ul class="list-disc list-inside text-gray-700 space-y-2">
                <li>Orarul poate fi modificat în funcție de necesitățile școlii</li>
                <li>Modificările se comunică cu 24h înainte</li>
                <li>În caz de modificări, se anunță prin email și pe website</li>
                <li>Pentru întrebări despre orar, contactați secretariatul</li>
              </ul>
            </div>
            
            <h2>Contact pentru Orar</h2>
            <div class="bg-gray-50 p-6 rounded-lg">
              <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                  <p class="font-medium text-gray-900">Email oficial</p>
                  <p class="text-blue-600">orar@ltvs.ro</p>
                </div>
                <div>
                  <p class="font-medium text-gray-900">Telefon secretariat</p>
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
