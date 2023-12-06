<script setup lang="ts">
import introJs from "intro.js";
import queryString from "query-string";
import { onMounted, ref, toRef } from "vue";
import { usePage } from "@inertiajs/vue3";
import { useTimeoutFn } from "@vueuse/core";
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
    HomeIcon,
    AcademicCapIcon,
    ClockIcon,
    UsersIcon,
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
        dataIntro:
            "Quickly access your personal dashboard page. Catch up on account stats, recent activity, and the latest updates.",
        dataStep: 3,
    },
    {
        name: "Upcoming",
        href: "upcoming",
        icon: ClockIcon,
        current: page.url.startsWith("/upcoming"),
        role: "student",
        dataIntro:
            "See details of any upcoming events, performances, or programs on your schedule. Check dates, times, locations, and other event information.",
        dataStep: 4,
    },
    {
        name: "Schedules",
        href: "schedule.index",
        icon: CalendarIcon,
        current: page.url.startsWith("/schedule"),
        role: "student",
        dataIntro:
            "View and organize your personal schedule. Add upcoming schedule, set reminders, dates, times, and manage all your events.",
        dataStep: 5,
    },
    {
        name: "Schedules",
        href: "admin.schedule.index",
        icon: CalendarIcon,
        current: page.url.startsWith("/admin/schedule"),
        role: "admin",
    },
    {
        name: "Courses",
        href: "course.index",
        icon: AcademicCapIcon,
        current: page.url.startsWith("/course"),
        role: "student",
        dataIntro:
            "Input your courses to automatically populate your timetable. The system will scrape available class times and sync your schedule.",
        dataStep: 6,
    },
    {
        name: "Courses",
        href: "admin.course.index",
        icon: AcademicCapIcon,
        current: page.url.startsWith("/admin/course"),
        role: "admin",
    },
    {
        name: "Students",
        href: "admin.student.index",
        icon: UsersIcon,
        current: page.url.startsWith("/admin/student"),
        role: "admin",
    },
];

const userNavigations: UserNavigation[] = [
    { name: "Your profile", href: "profile.index" },
];

const isCanSearch = () => {
    return (
        page.url.startsWith("/admin/schedule") ||
        page.url.startsWith("/admin/student") ||
        page.url.startsWith("/schedules")
    );
};

onMounted(() => {
    useTimeoutFn(() => introJs().start(), 500);
});
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
                    <form
                        class="relative flex flex-1"
                        data-intro="Search only available on selected pages. When present, use this to easily find what you need in that particular section or dataset. The search bar will appear on pages where looking up specific information is most useful."
                        data-step="8"
                    >
                        <div v-if="isCanSearch()">
                            <label for="search-field" class="sr-only"
                                >Search</label
                            >

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
                        </div>

                        <div v-else>
                            <AcademicCapIcon
                                class="pointer-events-none absolute inset-y-0 left-0 h-full w-5 text-gray-400"
                                aria-hidden="true"
                            />

                            <input
                                class="block h-full w-full border-0 py-0 pl-8 pr-0 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm"
                                placeholder="StudyMate"
                                disabled="disabled"
                                v-if="!isCanSearch()"
                            />
                        </div>
                    </form>
                    <div class="flex items-center gap-x-4 lg:gap-x-6">
                        <button
                            type="button"
                            class="-m-2.5 hidden p-2.5 text-gray-400 hover:text-gray-500"
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
                        <ProfileDropdown
                            :user-navigations="userNavigations"
                            data-intro="Click the profile section to access account management options and to securely log out.<br/><br/>That's all! Thank you."
                            data-step="9"
                        />
                    </div>
                </div>
            </div>

            <main class="py-10">
                <div class="px-4 transition-all duration-700 sm:px-6 lg:px-8">
                    <slot />
                </div>
            </main>
        </div>
    </div>
</template>
