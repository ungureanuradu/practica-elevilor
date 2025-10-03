<script setup>
const props = defineProps({
  items: {
    type: Array,
    default: () => [
      {
        title: 'Cum se face un CV European (Europass)',
        note: 'Ghid + generator CV',
        url: 'https://europa.eu/europass/ro/create-europass-cv',
        external: true
      },
      {
        title: 'Cum îmi găsesc un angajator',
        note: 'Pași practici + resurse',
        url: '/informatii/gasire-angajator'
      },
      {
        title: 'Documente necesare la angajare',
        note: 'Checklist pentru elevi',
        url: '/informatii/documente-angajare'
      },
      {
        title: 'Ce înseamnă internship',
        note: 'Diferențe față de job/voluntariat',
        url: '/informatii/internship'
      },
    ]
  },
  title: { type: String, default: 'Informații utile' }
})
</script>

<template>
  <section>
    <h3 class="text-xl font-semibold mb-4">{{ title }}</h3>

    <ul class="divide-y">
      <li v-for="(it, i) in items" :key="i" class="py-3">
        <a
          :href="it.url"
          class="group flex items-start gap-3"
          :target="it.external ? '_blank' : undefined"
          :rel="it.external ? 'noopener noreferrer' : undefined"
        >
          <!-- bullet/icon -->
          <div class="mt-1 h-2 w-2 rounded-full bg-blue-600 shrink-0"></div>

          <div class="min-w-0">
            <div class="font-medium leading-5 group-hover:underline">
              {{ it.title }}
            </div>
            <div v-if="it.note" class="text-sm text-gray-500">
              {{ it.note }}
            </div>
          </div>
        </a>
      </li>
    </ul>

    <div class="mt-3">
      <a href="/informatii" class="text-blue-600 text-sm">
        Vezi toate ghidurile →
      </a>
    </div>
  </section>
</template>
