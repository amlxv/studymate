<script setup lang="ts">
import { ref, toRef } from "vue";
import { usePage } from "@inertiajs/vue3";
import queryString from "query-string";
import { Navigation, UserNavigation } from "@/types/layout";
import DesktopSidebar from "@/layouts/static/DesktopSidebar.vue";
import MobileSidebar from "@/layouts/static/MobileSidebar.vue";
import ProfileDropdown from "@/layouts/static/ProfileDropdown.vue";
import Toast from "@/composables/notifications/Toast.vue";
import { MagnifyingGlassIcon } from "@heroicons/vue/20/solid";
import {
    Bars3Icon,
    BellIcon,
    CalendarIcon,
    FolderIcon,
    HomeIcon,
    AcademicCapIcon,
} from "@heroicons/vue/24/outline";

const { search: searchParams } = new URL(window.location.toString());
const params = queryString.parse(searchParams);

const page = usePage();
const search = toRef(params.search);
const sidebarOpen = ref(false);

const navigations: Navigation[] = [
    {
        name: "Dashboard",
        href: "home",
        icon: HomeIcon,
        current: page.url === "/",
    },
    {
        name: "Schedules",
        href: "schedule.index",
        icon: CalendarIcon,
        current: page.url.startsWith("/schedule"),
    },
    {
        name: "Classes",
        href: "home",
        icon: FolderIcon,
        current: page.url.startsWith("/class"),
    },
    {
        name: "Courses",
        href: "course.index",
        icon: AcademicCapIcon,
        current: page.url.startsWith("/course"),
    },
];

const userNavigations: UserNavigation[] = [
    { name: "Your profile", href: "profile.index" },
];
</script>
<template>
    <Toast />

    <div>
        <MobileSidebar
            :sidebar-open="sidebarOpen"
            :navigations="navigations"
            @sidebar-close="sidebarOpen = false"
        />

        <DesktopSidebar :navigations="navigations" />

        <div class="lg:pl-72">
            <div
                class="sticky top-0 z-40 flex h-16 shrink-0 items-center gap-x-4 border-b border-gray-200 bg-white px-4 shadow-sm sm:gap-x-6 sm:px-6 lg:px-8"
            >
                <button
                    type="button"
                    class="-m-2.5 p-2.5 text-gray-700 lg:hidden"
                    @click="sidebarOpen = true"
                >
                    <span class="sr-only">Open sidebar</span>
                    <Bars3Icon class="h-6 w-6" aria-hidden="true" />
                </button>

                <!-- Separator -->
                <div
                    class="h-6 w-px bg-gray-200 lg:hidden"
                    aria-hidden="true"
                />

                <div class="flex flex-1 gap-x-4 self-stretch lg:gap-x-6">
                    <form class="relative flex flex-1">
                        <label for="search-field" class="sr-only">Search</label>
                        <MagnifyingGlassIcon
                            class="pointer-events-none absolute inset-y-0 left-0 h-full w-5 text-gray-400"
                            aria-hidden="true"
                        />
                        <input
                            id="search-field"
                            class="block h-full w-full border-0 py-0 pl-8 pr-0 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm"
                            placeholder="Search..."
                            v-model="search"
                            type="search"
                            name="search"
                        />
                    </form>
                    <div class="flex items-center gap-x-4 lg:gap-x-6">
                        <button
                            type="button"
                            class="-m-2.5 p-2.5 text-gray-400 hover:text-gray-500"
                        >
                            <span class="sr-only">View notifications</span>
                            <BellIcon class="h-6 w-6" aria-hidden="true" />
                        </button>

                        <!-- Separator -->
                        <div
                            class="hidden lg:block lg:h-6 lg:w-px lg:bg-gray-200"
                            aria-hidden="true"
                        />

                        <!-- Profile dropdown -->
                        <ProfileDropdown :user-navigations="userNavigations" />
                    </div>
                </div>
            </div>

            <main class="py-10">
                <div class="px-4 sm:px-6 lg:px-8">
                    <slot />
                </div>
            </main>
        </div>
    </div>
</template>
