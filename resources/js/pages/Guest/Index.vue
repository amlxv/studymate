<script setup lang="ts">
import { ref } from "vue";
import { Link, usePage } from "@inertiajs/vue3";
import { Dialog, DialogPanel } from "@headlessui/vue";
import {
    Bars3Icon,
    CalendarDaysIcon,
    FingerPrintIcon,
    RectangleStackIcon,
    XMarkIcon,
    BellAlertIcon,
} from "@heroicons/vue/24/outline";

const page = usePage();

const navigations = [
    { name: "Features", href: "#features" },
    { name: "About", href: "#about" },
    { name: "Contact", href: "#contact" },
];

const mobileMenuOpen = ref(false);

const features = [
    {
        name: "Class Timetable",
        description:
            "Stay on top of your clas timetable with just a few taps. Our passionately designed system integrated with iCress.",
        icon: CalendarDaysIcon,
    },
    {
        name: "Activity Management",
        description:
            "Never forget quizzes, exams, or due dates again. Just let the our system logs all your key dates in one place.",
        icon: RectangleStackIcon,
    },
    {
        name: "Schedule Reminder",
        description:
            "Never miss a class or activity again - our system notifies you ahead of time so you stay on top of your schedule.",
        icon: BellAlertIcon,
    },
    {
        name: "Advanced Security",
        description:
            "Student information is securely stored in our servers, protected by unique email and password logins for each user.",
        icon: FingerPrintIcon,
    },
];
</script>

<template>
    <div class="bg-white">
        <!-- Header -->
        <header class="absolute inset-x-0 top-0 z-50">
            <nav
                class="flex items-center justify-between p-6 lg:px-8"
                aria-label="Global"
            >
                <div class="flex lg:flex-1">
                    <Link :href="route('home')" class="-m-1.5 p-1.5">
                        <span class="sr-only">StudyMate</span>
                        <img
                            class="h-8 w-auto"
                            src="/assets/images/logo.png"
                            alt="StudyMate Icon"
                        />
                    </Link>
                </div>
                <div class="flex lg:hidden">
                    <button
                        type="button"
                        class="-m-2.5 inline-flex items-center justify-center rounded-md p-2.5 text-gray-700"
                        @click="mobileMenuOpen = true"
                    >
                        <span class="sr-only">Open main menu</span>
                        <Bars3Icon class="h-6 w-6" aria-hidden="true" />
                    </button>
                </div>
                <div class="hidden lg:flex lg:gap-x-12">
                    <Link
                        v-for="item in navigations"
                        :key="item.name"
                        :href="item.href"
                        class="text-sm font-semibold leading-6 text-gray-900"
                        >{{ item.name }}
                    </Link>
                </div>
                <div class="hidden lg:flex lg:flex-1 lg:justify-end">
                    <Link
                        :href="route('login')"
                        class="text-sm font-semibold leading-6 text-gray-900"
                        >Log in <span aria-hidden="true">&rarr;</span></Link
                    >
                </div>
            </nav>
            <Dialog
                as="div"
                class="lg:hidden"
                @close="mobileMenuOpen = false"
                :open="mobileMenuOpen"
            >
                <div class="fixed inset-0 z-50" />
                <DialogPanel
                    class="fixed inset-y-0 right-0 z-50 w-full overflow-y-auto bg-white px-6 py-6 sm:max-w-sm sm:ring-1 sm:ring-gray-900/10"
                >
                    <div class="flex items-center justify-between">
                        <Link :href="route('home')" class="-m-1.5 p-1.5">
                            <span class="sr-only">StudyMate</span>
                            <img
                                class="h-8 w-auto"
                                src="/assets/images/logo.png"
                                alt="StudyMate Icon"
                            />
                        </Link>
                        <button
                            type="button"
                            class="-m-2.5 rounded-md p-2.5 text-gray-700"
                            @click="mobileMenuOpen = false"
                        >
                            <span class="sr-only">Close menu</span>
                            <XMarkIcon class="h-6 w-6" aria-hidden="true" />
                        </button>
                    </div>
                    <div class="mt-6 flow-root">
                        <div class="-my-6 divide-y divide-gray-500/10">
                            <div class="space-y-2 py-6">
                                <Link
                                    v-for="item in navigations"
                                    :key="item.name"
                                    :href="item.href"
                                    class="-mx-3 block rounded-lg px-3 py-2 text-base font-semibold leading-7 text-gray-900 hover:bg-gray-50"
                                    >{{ item.name }}
                                </Link>
                            </div>
                            <div class="py-6">
                                <Link
                                    :href="route('login')"
                                    class="-mx-3 block rounded-lg px-3 py-2.5 text-base font-semibold leading-7 text-gray-900 hover:bg-gray-50"
                                    >Log in
                                </Link>
                            </div>
                        </div>
                    </div>
                </DialogPanel>
            </Dialog>
        </header>

        <main class="isolate">
            <!-- Hero section -->
            <div class="relative pt-14">
                <div
                    class="absolute inset-x-0 -top-40 -z-10 transform-gpu overflow-hidden blur-3xl sm:-top-80"
                    aria-hidden="true"
                >
                    <div
                        class="relative left-[calc(50%-11rem)] aspect-[1155/678] w-[36.125rem] -translate-x-1/2 rotate-[30deg] bg-gradient-to-tr from-[#ff80b5] to-[#9089fc] opacity-30 sm:left-[calc(50%-30rem)] sm:w-[72.1875rem]"
                        style="
                            clip-path: polygon(
                                74.1% 44.1%,
                                100% 61.6%,
                                97.5% 26.9%,
                                85.5% 0.1%,
                                80.7% 2%,
                                72.5% 32.5%,
                                60.2% 62.4%,
                                52.4% 68.1%,
                                47.5% 58.3%,
                                45.2% 34.5%,
                                27.5% 76.7%,
                                0.1% 64.9%,
                                17.9% 100%,
                                27.6% 76.8%,
                                76.1% 97.7%,
                                74.1% 44.1%
                            );
                        "
                    />
                </div>
                <div class="py-24 sm:pb-20 sm:pt-60">
                    <div class="mx-auto max-w-7xl px-6 lg:px-8">
                        <div class="mx-auto max-w-2xl text-center">
                            <h1
                                class="text-4xl font-bold tracking-tight text-gray-900 sm:text-7xl"
                            >
                                Planning
                                <span
                                    class="relative whitespace-nowrap text-indigo-600"
                                    ><svg
                                        aria-hidden="true"
                                        viewBox="0 0 418 42"
                                        class="absolute left-0 top-2/3 h-[0.58em] w-full fill-indigo-300/70"
                                        preserveAspectRatio="none"
                                    >
                                        <path
                                            d="M203.371.916c-26.013-2.078-76.686 1.963-124.73 9.946L67.3 12.749C35.421 18.062 18.2 21.766 6.004 25.934 1.244 27.561.828 27.778.874 28.61c.07 1.214.828 1.121 9.595-1.176 9.072-2.377 17.15-3.92 39.246-7.496C123.565 7.986 157.869 4.492 195.942 5.046c7.461.108 19.25 1.696 19.17 2.582-.107 1.183-7.874 4.31-25.75 10.366-21.992 7.45-35.43 12.534-36.701 13.884-2.173 2.308-.202 4.407 4.442 4.734 2.654.187 3.263.157 15.593-.78 35.401-2.686 57.944-3.488 88.365-3.143 46.327.526 75.721 2.23 130.788 7.584 19.787 1.924 20.814 1.98 24.557 1.332l.066-.011c1.201-.203 1.53-1.825.399-2.335-2.911-1.31-4.893-1.604-22.048-3.261-57.509-5.556-87.871-7.36-132.059-7.842-23.239-.254-33.617-.116-50.627.674-11.629.54-42.371 2.494-46.696 2.967-2.359.259 8.133-3.625 26.504-9.81 23.239-7.825 27.934-10.149 28.304-14.005.417-4.348-3.529-6-16.878-7.066Z"
                                        ></path></svg
                                    ><span class="relative"
                                        >made simple</span
                                    ></span
                                >
                                for students.
                            </h1>
                            <p class="mt-6 text-lg leading-8 text-gray-600">
                                Streamline your studies and maximize your
                                productivity with StudyMate. Intelligent
                                platform helps you plan your very precious time.
                            </p>
                            <div
                                class="mt-10 flex items-center justify-center gap-x-6"
                            >
                                <Link
                                    :href="route('register')"
                                    class="rounded-md bg-indigo-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                                    >Get started
                                </Link>
                                <Link
                                    href="#"
                                    class="text-sm font-semibold leading-6 text-gray-900"
                                    >Learn more
                                    <span aria-hidden="true">→</span></Link
                                >
                            </div>
                        </div>
                        <div class="mt-16 flow-root sm:mt-24">
                            <div
                                class="-m-2 rounded-xl bg-gray-900/5 p-2 ring-1 ring-inset ring-gray-900/10 lg:-m-4 lg:rounded-2xl lg:p-4"
                            >
                                <img
                                    src="/assets/images/app-screenshot.png"
                                    alt="App screenshot"
                                    width="4286"
                                    height="2394"
                                    class="rounded-md shadow-2xl ring-1 ring-gray-900/10"
                                />
                            </div>
                        </div>
                    </div>
                </div>
                <div
                    class="absolute inset-x-0 top-[calc(100%-13rem)] -z-10 transform-gpu overflow-hidden blur-3xl sm:top-[calc(100%-30rem)]"
                    aria-hidden="true"
                >
                    <div
                        class="relative left-[calc(50%+3rem)] aspect-[1155/678] w-[36.125rem] -translate-x-1/2 bg-gradient-to-tr from-[#ff80b5] to-[#9089fc] opacity-30 sm:left-[calc(50%+36rem)] sm:w-[72.1875rem]"
                        style="
                            clip-path: polygon(
                                74.1% 44.1%,
                                100% 61.6%,
                                97.5% 26.9%,
                                85.5% 0.1%,
                                80.7% 2%,
                                72.5% 32.5%,
                                60.2% 62.4%,
                                52.4% 68.1%,
                                47.5% 58.3%,
                                45.2% 34.5%,
                                27.5% 76.7%,
                                0.1% 64.9%,
                                17.9% 100%,
                                27.6% 76.8%,
                                76.1% 97.7%,
                                74.1% 44.1%
                            );
                        "
                    />
                </div>
            </div>

            <!-- Feature section -->
            <div
                id="features"
                class="mx-auto flex min-h-screen max-w-7xl flex-col justify-center px-6 lg:px-8"
            >
                <div class="mx-auto max-w-2xl lg:text-center">
                    <h2
                        class="text-base font-semibold leading-7 text-indigo-600"
                    >
                        StudyMate
                    </h2>
                    <p
                        class="mt-2 text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl"
                    >
                        For students, by a student.
                    </p>
                    <p class="mt-6 text-lg leading-8 text-gray-600">
                        Easily schedule classes, study sessions, activities, and
                        more. Get reminders on your phone so you never miss an
                        assignment.
                    </p>
                </div>
                <div
                    class="mx-auto mt-16 max-w-2xl sm:mt-20 lg:mt-24 lg:max-w-4xl"
                >
                    <dl
                        class="grid max-w-xl grid-cols-1 gap-x-8 gap-y-10 lg:max-w-none lg:grid-cols-2 lg:gap-y-16"
                    >
                        <div
                            v-for="feature in features"
                            :key="feature.name"
                            class="relative pl-16"
                        >
                            <dt
                                class="text-base font-semibold leading-7 text-gray-900"
                            >
                                <div
                                    class="absolute left-0 top-0 flex h-10 w-10 items-center justify-center rounded-lg bg-indigo-600"
                                >
                                    <component
                                        :is="feature.icon"
                                        class="h-6 w-6 text-white"
                                        aria-hidden="true"
                                    />
                                </div>
                                {{ feature.name }}
                            </dt>
                            <dd class="mt-2 text-base leading-7 text-gray-600">
                                {{ feature.description }}
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>

            <!-- Contact section -->
            <div
                id="contact"
                class="mx-auto flex min-h-screen max-w-7xl flex-col justify-center px-6 lg:px-8"
            >
                <div
                    class="relative isolate bg-white px-6 py-24 sm:py-32 lg:px-8"
                >
                    <svg
                        class="absolute inset-0 -z-10 h-full w-full stroke-gray-200 [mask-image:radial-gradient(100%_100%_at_top_right,white,transparent)]"
                        aria-hidden="true"
                    >
                        <defs>
                            <pattern
                                id="83fd4e5a-9d52-42fc-97b6-718e5d7ee527"
                                width="200"
                                height="200"
                                x="50%"
                                y="-64"
                                patternUnits="userSpaceOnUse"
                            >
                                <path d="M100 200V.5M.5 .5H200" fill="none" />
                            </pattern>
                        </defs>
                        <svg
                            x="50%"
                            y="-64"
                            class="overflow-visible fill-gray-50"
                        >
                            <path
                                d="M-100.5 0h201v201h-201Z M699.5 0h201v201h-201Z M499.5 400h201v201h-201Z M299.5 800h201v201h-201Z"
                                stroke-width="0"
                            />
                        </svg>
                        <rect
                            width="100%"
                            height="100%"
                            stroke-width="0"
                            fill="url(#83fd4e5a-9d52-42fc-97b6-718e5d7ee527)"
                        />
                    </svg>
                    <div class="mx-auto max-w-xl lg:max-w-4xl">
                        <h2
                            class="text-4xl font-bold tracking-tight text-gray-900"
                        >
                            Let’s talk.
                        </h2>
                        <p class="mt-2 text-lg leading-8 text-gray-600">
                            We help companies and individuals build out their
                            brand guidelines.
                        </p>
                        <div
                            class="mt-16 flex flex-col gap-16 sm:gap-y-20 lg:flex-row"
                        >
                            <form action="#" method="POST" class="lg:flex-auto">
                                <div
                                    class="grid grid-cols-1 gap-x-8 gap-y-6 sm:grid-cols-2"
                                >
                                    <div>
                                        <label
                                            for="first-name"
                                            class="block text-sm font-semibold leading-6 text-gray-900"
                                            >First name</label
                                        >
                                        <div class="mt-2.5">
                                            <input
                                                type="text"
                                                name="first-name"
                                                id="first-name"
                                                autocomplete="given-name"
                                                class="block w-full rounded-md border-0 px-3.5 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                            />
                                        </div>
                                    </div>
                                    <div>
                                        <label
                                            for="last-name"
                                            class="block text-sm font-semibold leading-6 text-gray-900"
                                            >Last name</label
                                        >
                                        <div class="mt-2.5">
                                            <input
                                                type="text"
                                                name="last-name"
                                                id="last-name"
                                                autocomplete="family-name"
                                                class="block w-full rounded-md border-0 px-3.5 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                            />
                                        </div>
                                    </div>
                                    <div>
                                        <label
                                            for="budget"
                                            class="block text-sm font-semibold leading-6 text-gray-900"
                                            >Budget</label
                                        >
                                        <div class="mt-2.5">
                                            <input
                                                id="budget"
                                                name="budget"
                                                type="text"
                                                class="block w-full rounded-md border-0 px-3.5 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                            />
                                        </div>
                                    </div>
                                    <div>
                                        <label
                                            for="website"
                                            class="block text-sm font-semibold leading-6 text-gray-900"
                                            >Website</label
                                        >
                                        <div class="mt-2.5">
                                            <input
                                                type="url"
                                                name="website"
                                                id="website"
                                                class="block w-full rounded-md border-0 px-3.5 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                            />
                                        </div>
                                    </div>
                                    <div class="sm:col-span-2">
                                        <label
                                            for="message"
                                            class="block text-sm font-semibold leading-6 text-gray-900"
                                            >Message</label
                                        >
                                        <div class="mt-2.5">
                                            <textarea
                                                id="message"
                                                name="message"
                                                rows="4"
                                                class="block w-full rounded-md border-0 px-3.5 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                            />
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-10">
                                    <button
                                        type="submit"
                                        class="block w-full rounded-md bg-indigo-600 px-3.5 py-2.5 text-center text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                                    >
                                        Let’s talk
                                    </button>
                                </div>
                                <p class="mt-4 text-sm leading-6 text-gray-500">
                                    By submitting this form, I agree to the
                                    <a
                                        href="#"
                                        class="font-semibold text-indigo-600"
                                        >privacy&nbsp;policy</a
                                    >.
                                </p>
                            </form>
                            <div class="lg:mt-6 lg:w-80 lg:flex-none">
                                <img
                                    class="h-12 w-auto"
                                    src="https://tailwindui.com/img/logos/workcation-logo-indigo-600.svg"
                                    alt=""
                                />
                                <figure class="mt-10">
                                    <blockquote
                                        class="text-lg font-semibold leading-8 text-gray-900"
                                    >
                                        <p>
                                            “Lorem ipsum dolor sit amet
                                            consectetur adipisicing elit. Nemo
                                            expedita voluptas culpa sapiente
                                            alias molestiae. Numquam corrupti in
                                            laborum sed rerum et corporis.”
                                        </p>
                                    </blockquote>
                                    <figcaption class="mt-10 flex gap-x-6">
                                        <img
                                            src="https://avatars.githubusercontent.com/u/34534953?v=4"
                                            alt=""
                                            class="h-12 w-12 flex-none rounded-full bg-gray-50"
                                        />
                                        <div>
                                            <div
                                                class="text-base font-semibold text-gray-900"
                                            >
                                                Amirul
                                            </div>
                                            <div
                                                class="text-sm leading-6 text-gray-600"
                                            >
                                                CEO of StudyMate
                                            </div>
                                        </div>
                                    </figcaption>
                                </figure>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</template>
