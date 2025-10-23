<template>
  <FrontendLayout title="Resurse Umane">
    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-8">
          <h1 class="text-3xl font-bold text-gray-900 mb-6">Resurse Umane</h1>
          
          <div class="prose max-w-none content-styling">
            <h2>Echipa de Resurse Umane</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 my-8">
              <div class="bg-blue-50 p-6 rounded-lg">
                <h3 class="text-xl font-semibold text-blue-900 mb-3">Manager Resurse Umane</h3>
                <p class="text-lg font-medium text-gray-900 mb-2">[Numele Managerului]</p>
                <p class="text-gray-700 mb-3">Responsabil pentru gestionarea personalului</p>
                <p class="text-sm text-gray-600">
                  <strong>Email:</strong> hr@ltvs.ro<br>
                  <strong>Telefon:</strong> +40 233 123 456
                </p>
              </div>
              <div class="bg-green-50 p-6 rounded-lg">
                <h3 class="text-xl font-semibold text-green-900 mb-3">Specialist Resurse Umane</h3>
                <p class="text-lg font-medium text-gray-900 mb-2">[Numele Specialistului]</p>
                <p class="text-gray-700 mb-3">Responsabil pentru recrutare și dezvoltare</p>
                <p class="text-sm text-gray-600">
                  <strong>Email:</strong> recrutare@ltvs.ro<br>
                  <strong>Telefon:</strong> +40 233 123 457
                </p>
              </div>
            </div>
            
            <h2>Procese de Recrutare</h2>
            <div class="bg-gray-50 p-6 rounded-lg">
              <h3 class="text-lg font-semibold text-gray-900 mb-4">Pași pentru Aplicare</h3>
              <ol class="list-decimal list-inside text-gray-700 space-y-2">
                <li>Consultarea posturilor disponibile pe website</li>
                <li>Completarea formularului de aplicare</li>
                <li>Depunerea CV-ului și scrisorii de intenție</li>
                <li>Participarea la interviul de selecție</li>
                <li>Evaluarea tehnică (dacă este cazul)</li>
                <li>Anunțarea rezultatului</li>
              </ol>
            </div>
            
            <h2>Posturi Disponibile</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 my-8">
              <div class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm">
                <h3 class="text-lg font-semibold text-gray-900 mb-3">Personal Didactic</h3>
                <ul class="text-sm text-gray-600 space-y-2">
                  <li>• Profesor de Matematică</li>
                  <li>• Profesor de Informatică</li>
                  <li>• Profesor de Limba Engleză</li>
                  <li>• Profesor de Fizică</li>
                  <li>• Profesor de Chimie</li>
                </ul>
              </div>
              <div class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm">
                <h3 class="text-lg font-semibold text-gray-900 mb-3">Personal Auxiliar</h3>
                <ul class="text-sm text-gray-600 space-y-2">
                  <li>• Psiholog școlar</li>
                  <li>• Bibliotecar</li>
                  <li>• Asistent social</li>
                  <li>• Educator</li>
                  <li>• Personal administrativ</li>
                </ul>
              </div>
            </div>
            
            <h2>Beneficii și Condiții</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 my-8">
              <div class="bg-blue-50 p-6 rounded-lg">
                <h3 class="text-lg font-semibold text-blue-900 mb-3">Beneficii</h3>
                <ul class="text-sm text-gray-600 space-y-2">
                  <li>• Salariu competitiv</li>
                  <li>• Program de formare continuă</li>
                  <li>• Asigurări de sănătate</li>
                  <li>• Program de vacanțe</li>
                  <li>• Posibilități de avansare</li>
                </ul>
              </div>
              <div class="bg-green-50 p-6 rounded-lg">
                <h3 class="text-lg font-semibold text-green-900 mb-3">Condiții de Muncă</h3>
                <ul class="text-sm text-gray-600 space-y-2">
                  <li>• Program: Luni - Vineri, 8:00 - 16:00</li>
                  <li>• Mediu de lucru modern</li>
                  <li>• Echipamente de ultimă generație</li>
                  <li>• Colaborare cu echipa educațională</li>
                  <li>• Sprijin pentru dezvoltare profesională</li>
                </ul>
              </div>
            </div>
            
            <h2>Formare și Dezvoltare</h2>
            <div class="bg-purple-50 p-6 rounded-lg">
              <h3 class="text-lg font-semibold text-purple-900 mb-4">Programe de Dezvoltare</h3>
              <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                  <h4 class="font-semibold text-gray-900 mb-2">Formare Internă</h4>
                  <ul class="text-sm text-gray-600 space-y-1">
                    <li>• Workshop-uri de specializare</li>
                    <li>• Cursuri de inovație pedagogică</li>
                    <li>• Training-uri de management</li>
                  </ul>
                </div>
                <div>
                  <h4 class="font-semibold text-gray-900 mb-2">Formare Externă</h4>
                  <ul class="text-sm text-gray-600 space-y-1">
                    <li>• Conferințe educaționale</li>
                    <li>• Cursuri de specializare</li>
                    <li>• Programe de schimb</li>
                  </ul>
                </div>
              </div>
            </div>
            
            <h2>Contact Resurse Umane</h2>
            <div class="bg-gray-50 p-6 rounded-lg">
              <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                  <p class="font-medium text-gray-900">Email general</p>
                  <p class="text-blue-600">hr@ltvs.ro</p>
                </div>
                <div>
                  <p class="font-medium text-gray-900">Email recrutare</p>
                  <p class="text-blue-600">recrutare@ltvs.ro</p>
                </div>
              </div>
              <p class="text-sm text-gray-600 mt-4">
                <strong>Program de audiențe:</strong> Luni - Vineri, 8:00 - 16:00
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
