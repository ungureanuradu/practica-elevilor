<script setup>
import { ref } from 'vue'
import { Link } from '@inertiajs/vue3'
import Footer from '@/Components/Footer.vue'

defineProps({
    title: String,
})

const mobileOpen = ref(false)

const footerData = typeof window !== 'undefined' ? window.footerData : null

</script>

<template>
    <div class="min-h-screen bg-gray-50">
        <!-- NAVBAR -->
        <header class="bg-blue-700 text-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-14 flex items-center justify-between">
                <h1 class="font-extrabold text-sm sm:text-base">
                    Liceul Tehnologic „Vasile Sav"
                </h1>

                <!-- Desktop menu -->
                <nav class="hidden md:flex items-center gap-6 text-sm">
                    <Link href="/">Acasă</Link>
                    <Link href="/membri">Membri</Link>
                    <Link href="/cursuri">Cursuri</Link>
                    <Link href="/forum">Forum</Link>
                    <Link href="/joburi">Joburi</Link>
                    
                    <!-- Dashboard button for logged in users -->
                    <Link 
                        v-if="$page.props.auth.user" 
                        :href="route('dashboard')" 
                        class="bg-blue-600 hover:bg-blue-500 px-3 py-1 rounded-md text-sm font-medium transition-colors"
                    >
                        Dashboard
                    </Link>
                </nav>

                <!-- Mobile button -->
                <button
                    class="md:hidden inline-flex items-center justify-center p-2 rounded hover:bg-blue-600 focus:outline-none"
                    @click="mobileOpen = !mobileOpen"
                    aria-label="Deschide meniul"
                >
                    <svg v-if="!mobileOpen" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                    <svg v-else xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <!-- Mobile dropdown -->
            <div v-show="mobileOpen" class="md:hidden border-t border-blue-600">
                <div class="max-w-7xl mx-auto px-4 py-3 flex flex-col gap-3 text-sm">
                    <Link href="/" @click="mobileOpen=false">Acasă</Link>
                    <Link href="/membri" @click="mobileOpen=false">Membri</Link>
                    <Link href="/cursuri" @click="mobileOpen=false">Cursuri</Link>
                    <Link href="/forum" @click="mobileOpen=false">Forum</Link>
                    <Link href="/joburi" @click="mobileOpen=false">Joburi</Link>
                    
                    <!-- Dashboard button for logged in users -->
                    <Link 
                        v-if="$page.props.auth.user" 
                        :href="route('dashboard')" 
                        @click="mobileOpen=false"
                        class="bg-blue-600 hover:bg-blue-500 px-3 py-2 rounded-md text-sm font-medium transition-colors text-center"
                    >
                        Dashboard
                    </Link>
                </div>
            </div>
        </header>

        <!-- Page Content -->
        <main class="flex-1">
            <slot />
        </main>

        <!-- Footer -->
        <Footer :data="footerData" />
    </div>
</template>
