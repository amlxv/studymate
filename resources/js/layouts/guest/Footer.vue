<script setup lang="ts">
import { Link } from "@inertiajs/vue3";
</script>

<template>
    <footer class="mx-auto mt-10 max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="py-16">
            <img
                class="mx-auto h-10 w-auto"
                src="@images/logo-b.png"
                alt="StudyMate Icon"
            />
            <nav class="mt-10 text-sm" aria-label="quick links">
                <div class="-my-1 flex justify-center gap-x-6">
                    <Link
                        :href="route('home')"
                        class="text-gray-700 hover:text-indigo-600"
                        >Home
                    </Link>
                    <Link
                        href="#contact"
                        class="text-gray-700 hover:text-indigo-600"
                        >Contact Us
                    </Link>
                    <Link
                        href="#features"
                        class="text-gray-700 hover:text-indigo-600"
                        >Features
                    </Link>
                    <Link
                        :href="route('register')"
                        class="text-gray-700 hover:text-indigo-600"
                        >Register
                    </Link>
                    <Link
                        :href="route('login')"
                        class="text-gray-700 hover:text-indigo-600"
                        >Sign In
                    </Link>
                </div>
            </nav>
        </div>
        <div
            class="flex flex-col items-center border-t border-slate-400/10 py-10 sm:flex-row-reverse sm:justify-between"
        >
            <div class="flex gap-x-6">
                <a
                    href="https://linkedin.com/in/amlxv"
                    target="_blank"
                    class="group"
                    aria-label="amlxv on LinkedIn"
                >
                    <svg
                        aria-hidden="true"
                        class="mt-[-1px] h-6 w-6 fill-slate-500 group-hover:fill-slate-700"
                    >
                        <path
                            d="M24,4H6C4.895,4,4,4.895,4,6v18c0,1.105,0.895,2,2,2h18c1.105,0,2-0.895,2-2V6C26,4.895,25.105,4,24,4z M10.954,22h-2.95 v-9.492h2.95V22z M9.449,11.151c-0.951,0-1.72-0.771-1.72-1.72c0-0.949,0.77-1.719,1.72-1.719c0.948,0,1.719,0.771,1.719,1.719 C11.168,10.38,10.397,11.151,9.449,11.151z M22.004,22h-2.948v-4.616c0-1.101-0.02-2.517-1.533-2.517 c-1.535,0-1.771,1.199-1.771,2.437V22h-2.948v-9.492h2.83v1.297h0.04c0.394-0.746,1.356-1.533,2.791-1.533 c2.987,0,3.539,1.966,3.539,4.522V22z"
                        ></path>
                    </svg>
                </a>
                <a
                    href="https://github.com/amlxv"
                    target="_blank"
                    class="group"
                    aria-label="amlxv on GitHub"
                >
                    <svg
                        aria-hidden="true"
                        class="h-6 w-6 fill-slate-500 group-hover:fill-slate-700"
                    >
                        <path
                            d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0 1 12 6.844a9.59 9.59 0 0 1 2.504.337c1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.02 10.02 0 0 0 22 12.017C22 6.484 17.522 2 12 2Z"
                        />
                    </svg>
                </a>
            </div>
            <p class="mt-6 text-sm text-slate-500 sm:mt-0">
                Copyright &copy; {{ new Date().getFullYear() }} AML Digital
                Services. All rights reserved.
            </p>
        </div>
    </footer>
</template>
