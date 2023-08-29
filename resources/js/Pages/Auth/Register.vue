<script setup lang="ts">
import { Link, useForm } from "@inertiajs/vue3";

const form = useForm({
    name: null,
    email: null,
    password: null,
    password_confirmation: null,
});
</script>

<template>
    <div class="flex min-h-full flex-1">
        <div
            class="flex flex-1 flex-col justify-center px-4 py-12 sm:px-6 lg:flex-none lg:px-20 xl:px-24"
        >
            <div class="mx-auto w-full max-w-sm lg:w-96">
                <div>
                    <Link href="/">
                        <img
                            class="h-10 w-auto"
                            src="https://i.imgur.com/Lgce8Ha.png"
                            alt="StudyMate"
                        />
                    </Link>
                    <h2
                        class="mt-8 text-2xl font-bold leading-9 tracking-tight text-gray-900"
                    >
                        Create your account
                    </h2>
                    <p class="mt-2 text-sm leading-6 text-gray-500">
                        Already have an account?
                        {{ " " }}
                        <Link
                            :href="$route('login')"
                            class="font-semibold text-indigo-600 hover:text-indigo-500"
                            >Sign in
                        </Link>
                    </p>
                </div>

                <div class="mt-10">
                    <div>
                        <form
                            @submit.prevent="form.post($route('register'))"
                            class="space-y-6"
                        >
                            <div>
                                <label
                                    for="name"
                                    class="block text-sm font-medium leading-6 text-gray-900"
                                    >Name</label
                                >
                                <div class="mt-2">
                                    <input
                                        id="name"
                                        v-model="form.name"
                                        type="text"
                                        autocomplete="name"
                                        required
                                        class="block w-full rounded-md border-0 py-1.5 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                    />
                                </div>
                            </div>

                            <div>
                                <label
                                    for="email"
                                    class="block text-sm font-medium leading-6 text-gray-900"
                                    >Email address</label
                                >
                                <div class="mt-2">
                                    <input
                                        id="email"
                                        v-model="form.email"
                                        type="email"
                                        autocomplete="email"
                                        required
                                        class="block w-full rounded-md border-0 py-1.5 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                    />
                                </div>
                            </div>

                            <div>
                                <label
                                    for="password"
                                    class="block text-sm font-medium leading-6 text-gray-900"
                                    >Password</label
                                >
                                <div class="mt-2">
                                    <input
                                        id="password"
                                        v-model="form.password"
                                        type="password"
                                        autocomplete="password"
                                        required
                                        class="block w-full rounded-md border-0 py-1.5 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                    />
                                </div>
                            </div>

                            <div>
                                <label
                                    for="password_confirmation"
                                    class="block text-sm font-medium leading-6 text-gray-900"
                                    >Confirm Password</label
                                >
                                <div class="mt-2">
                                    <input
                                        id="password_confirmation"
                                        v-model="form.password_confirmation"
                                        type="password"
                                        autocomplete="password_confirmation"
                                        required
                                        class="block w-full rounded-md border-0 py-1.5 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                    />
                                </div>
                            </div>

                            <div>
                                <button
                                    type="submit"
                                    class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                                >
                                    Sign up
                                </button>
                            </div>
                        </form>
                    </div>

                    <div class="mt-10">
                        <div class="relative">
                            <div
                                class="absolute inset-0 flex items-center"
                                aria-hidden="true"
                            >
                                <div class="w-full border-t border-gray-200" />
                            </div>
                            <div
                                class="relative flex justify-center text-sm font-medium leading-6"
                            >
                                <span class="bg-white px-6 text-gray-900"
                                    >Or continue with</span
                                >
                            </div>
                        </div>

                        <div class="mt-6 grid grid-cols-2 gap-4">
                            <a
                                :href="
                                    $route('social-provider.redirect', 'github')
                                "
                                class="flex w-full items-center justify-center gap-3 rounded-md bg-[#24292F] px-3 py-1.5 text-white focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#24292F]"
                            >
                                <svg
                                    class="h-5 w-5"
                                    aria-hidden="true"
                                    fill="currentColor"
                                    viewBox="0 0 20 20"
                                >
                                    <path
                                        fill-rule="evenodd"
                                        d="M10 0C4.477 0 0 4.484 0 10.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0110 4.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.203 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.942.359.31.678.921.678 1.856 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0020 10.017C20 4.484 15.522 0 10 0z"
                                        clip-rule="evenodd"
                                    />
                                </svg>
                                <span class="text-sm font-semibold leading-6"
                                    >GitHub</span
                                >
                            </a>

                            <a
                                :href="
                                    $route('social-provider.redirect', 'google')
                                "
                                class="flex w-full items-center justify-center gap-3 rounded-md border border-slate-300 bg-white px-3 py-1.5 text-gray-900 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#1D9BF0]"
                            >
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    x="0px"
                                    y="0px"
                                    class="h-5 w-5"
                                    viewBox="0 0 48 48"
                                >
                                    <path
                                        fill="#fbc02d"
                                        d="M43.611,20.083H42V20H24v8h11.303c-1.649,4.657-6.08,8-11.303,8c-6.627,0-12-5.373-12-12	s5.373-12,12-12c3.059,0,5.842,1.154,7.961,3.039l5.657-5.657C34.046,6.053,29.268,4,24,4C12.955,4,4,12.955,4,24s8.955,20,20,20	s20-8.955,20-20C44,22.659,43.862,21.35,43.611,20.083z"
                                    ></path>
                                    <path
                                        fill="#e53935"
                                        d="M6.306,14.691l6.571,4.819C14.655,15.108,18.961,12,24,12c3.059,0,5.842,1.154,7.961,3.039	l5.657-5.657C34.046,6.053,29.268,4,24,4C16.318,4,9.656,8.337,6.306,14.691z"
                                    ></path>
                                    <path
                                        fill="#4caf50"
                                        d="M24,44c5.166,0,9.86-1.977,13.409-5.192l-6.19-5.238C29.211,35.091,26.715,36,24,36	c-5.202,0-9.619-3.317-11.283-7.946l-6.522,5.025C9.505,39.556,16.227,44,24,44z"
                                    ></path>
                                    <path
                                        fill="#1565c0"
                                        d="M43.611,20.083L43.595,20L42,20H24v8h11.303c-0.792,2.237-2.231,4.166-4.087,5.571	c0.001-0.001,0.002-0.001,0.003-0.002l6.19,5.238C36.971,39.205,44,34,44,24C44,22.659,43.862,21.35,43.611,20.083z"
                                    ></path>
                                </svg>

                                <span class="text-sm font-semibold leading-6"
                                    >Google</span
                                >
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="relative hidden w-0 flex-1 lg:block">
            <img
                class="absolute inset-0 h-full w-full object-cover"
                src="https://images.unsplash.com/photo-1496917756835-20cb06e75b4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1908&q=80"
                alt="Just a random image"
            />
        </div>
    </div>
</template>
