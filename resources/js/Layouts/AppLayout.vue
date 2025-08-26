<script setup>
import { computed, ref } from 'vue'
import { useForm, usePage, Link } from '@inertiajs/vue3'
import ApplicationMark from '@/Components/ApplicationMark.vue'
import Banner from '@/Components/Banner.vue'
import Dropdown from '@/Components/Dropdown.vue'
import DropdownLink from '@/Components/DropdownLink.vue'
import NavLink from '@/Components/NavLink.vue'
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue'
import Footer from '@/Components/Footer.vue'

const props = defineProps({
    title: String,
})

const page = usePage()
const showingNavigationDropdown = ref(false)

const footerData = typeof window !== 'undefined' ? window.footerData : null

const logout = () => {
    useForm().post(route('logout'))
}

const switchToTeam = (team) => {
    useForm().put(route('current-team.update'), {
        team_id: team.id,
    }, {
        preserveScroll: false,
    })
}

const getDashboardUrl = () => {
    const user = page.props.auth.user
    if (!user) return route('dashboard')
    
    switch (user.role) {
        case 'teacher':
            return route('teacher.dashboard')
        case 'student':
            return route('student.dashboard')
        case 'company':
            return route('company.dashboard')
        default:
            return route('dashboard')
    }
}

const getUrl = (name) => {
    const user = page.props.auth.user
    if (!user) {
        // Public URLs for non-authenticated users
        switch (name) {
            case 'members':
                return route('members.index')
            case 'courses':
                return route('courses.index')
            case 'forum':
                return route('forum.index')
            case 'jobs':
                return route('jobs.index')
            case 'documents':
                return route('documents.index')
            case 'calendar':
                return route('calendar.index')
            case 'groups':
                return route('groups.index')
            default:
                return '#'
        }
    }
    
    // Role-based URLs for authenticated users
    const role = user.role
    switch (role) {
        case 'teacher':
            return route(`teacher.${name}.index`)
        case 'student':
            return route(`student.${name}.index`)
        case 'company':
            return route(`company.${name}.index`)
        default:
            return route(`${name}.index`)
    }
}
</script>

<template>
    <div>
        <Head :title="title" />

        <Banner />

        <div class="min-h-screen bg-gray-100 flex flex-col">
            <nav class="bg-blue-700 text-white">
                <!-- Primary Navigation Menu -->
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-14 flex items-center justify-between">
                    <!-- Logo -->
                    <div class="shrink-0 flex items-center">
                        <Link :href="route('home')">
                            <h1 class="font-extrabold text-sm sm:text-base">
                                Liceul Tehnologic „Vasile Sav"
                            </h1>
                        </Link>
                    </div>

                    <!-- Desktop menu for ALL users -->
                    <nav class="hidden md:flex items-center gap-6 text-sm">
                        <Link href="/">Acasă</Link>
                        <Link :href="getUrl('members')">Membri</Link>
                        <Link :href="getUrl('courses')">Cursuri</Link>
                        <Link :href="getUrl('forum')">Forum</Link>
                        <Link :href="getUrl('jobs')">Joburi</Link>

                        <!-- Settings Dropdown for AUTHENTICATED users only -->
                        <div v-if="page.props.auth.user" class="ms-3 relative">
                            <Dropdown align="right" width="48">
                                <template #trigger>
                                    <button v-if="page.props.jetstream.managesProfilePhotos" class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                                        <img class="size-8 rounded-full object-cover" :src="page.props.auth.user.profile_photo_url" :alt="page.props.auth.user.name">
                                    </button>

                                    <span v-else class="inline-flex rounded-md">
                                        <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-200 bg-blue-700 hover:text-white focus:outline-none transition ease-in-out duration-150">
                                            {{ page.props.auth.user.name }}

                                            <svg class="ms-2 -me-0.5 size-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                            </svg>
                                        </button>
                                    </span>
                                </template>

                                <template #content>
                                    <!-- Account Management -->
                                    <div class="block px-4 py-2 text-xs text-gray-400">
                                        Manage Account
                                    </div>

                                    <DropdownLink :href="route('profile.show')">
                                        Profile
                                    </DropdownLink>

                                    <DropdownLink v-if="page.props.jetstream.hasApiFeatures" :href="route('api-tokens.index')">
                                        API Tokens
                                    </DropdownLink>

                                    <div class="border-t border-gray-200" />

                                    <!-- Authentication -->
                                    <form @submit.prevent="logout">
                                        <DropdownLink as="button">
                                            Log Out
                                        </DropdownLink>
                                    </form>
                                </template>
                            </Dropdown>
                        </div>
                    </nav>

                    <!-- Hamburger for ALL users -->
                    <div class="-me-2 flex items-center md:hidden">
                        <button @click="showingNavigationDropdown = ! showingNavigationDropdown" class="inline-flex items-center justify-center p-2 rounded-md text-gray-200 hover:text-white hover:bg-blue-600 focus:outline-none focus:bg-blue-600 focus:text-white transition duration-150 ease-in-out">
                            <svg class="size-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                <path :class="{'hidden': showingNavigationDropdown, 'inline-flex': ! showingNavigationDropdown }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                <path :class="{'hidden': ! showingNavigationDropdown, 'inline-flex': showingNavigationDropdown }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Responsive Navigation Menu for ALL users -->
                <div :class="{'block': showingNavigationDropdown, 'hidden': ! showingNavigationDropdown}" class="md:hidden">
                    <div class="pt-2 pb-3 space-y-1">
                        <Link href="/" @click="showingNavigationDropdown=false" class="block w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-start text-base font-medium text-gray-200 hover:text-white hover:bg-blue-600 hover:border-gray-300 focus:outline-none focus:text-white focus:bg-blue-600 focus:border-gray-300 transition duration-150 ease-in-out">
                            Acasă
                        </Link>
                        <Link :href="getUrl('members')" @click="showingNavigationDropdown=false" class="block w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-start text-base font-medium text-gray-200 hover:text-white hover:bg-blue-600 hover:border-gray-300 focus:outline-none focus:text-white focus:bg-blue-600 focus:border-gray-300 transition duration-150 ease-in-out">
                            Membri
                        </Link>
                        <Link :href="getUrl('courses')" @click="showingNavigationDropdown=false" class="block w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-start text-base font-medium text-gray-200 hover:text-white hover:bg-blue-600 hover:border-gray-300 focus:outline-none focus:text-white focus:bg-blue-600 focus:border-gray-300 transition duration-150 ease-in-out">
                            Cursuri
                        </Link>
                        <Link :href="getUrl('forum')" @click="showingNavigationDropdown=false" class="block w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-start text-base font-medium text-gray-200 hover:text-white hover:bg-blue-600 hover:border-gray-300 focus:outline-none focus:text-white focus:bg-blue-600 focus:border-gray-300 transition duration-150 ease-in-out">
                            Forum
                        </Link>
                        <Link :href="getUrl('jobs')" @click="showingNavigationDropdown=false" class="block w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-start text-base font-medium text-gray-200 hover:text-white hover:bg-blue-600 hover:border-gray-300 focus:outline-none focus:text-white focus:bg-blue-600 focus:border-gray-300 transition duration-150 ease-in-out">
                            Joburi
                        </Link>
                    </div>

                    <!-- Responsive Settings Options for AUTHENTICATED users only -->
                    <div v-if="page.props.auth.user" class="pt-4 pb-1 border-t border-gray-200">
                        <div class="flex items-center px-4">
                            <div v-if="page.props.jetstream.managesProfilePhotos" class="shrink-0 me-3">
                                <img class="size-10 rounded-full object-cover" :src="page.props.auth.user.profile_photo_url" :alt="page.props.auth.user.name">
                            </div>

                            <div>
                                <div class="font-medium text-base text-gray-800">
                                    {{ page.props.auth.user.name }}
                                </div>
                                <div class="font-medium text-sm text-gray-500">
                                    {{ page.props.auth.user.email }}
                                </div>
                            </div>
                        </div>

                        <div class="mt-3 space-y-1">
                            <ResponsiveNavLink :href="route('profile.show')" :active="route().current('profile.show')">
                                Profile
                            </ResponsiveNavLink>

                            <ResponsiveNavLink v-if="page.props.jetstream.hasApiFeatures" :href="route('api-tokens.index')" :active="route().current('api-tokens.index')">
                                API Tokens
                            </ResponsiveNavLink>

                            <!-- Authentication -->
                            <form method="POST" @submit.prevent="logout">
                                <ResponsiveNavLink as="button">
                                    Log Out
                                </ResponsiveNavLink>
                            </form>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Page Heading -->
            <header v-if="$slots.header" class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    <slot name="header" />
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1">
                <slot />
            </main>
            <!-- Footer -->
            <Footer v-if="footerData" :data="footerData" />
        </div>
    </div>
</template>
