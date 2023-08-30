<script setup lang="ts">
import { Link, useForm } from "@inertiajs/vue3";
import FormInput from "@/components/common/forms/FormInput.vue";
import SocialButton from "@/components/common/buttons/SocialButton.vue";

const form = useForm({
    email: null,
    password: null,
    remember: false,
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
                        Sign in to your account
                    </h2>
                    <p class="mt-2 text-sm leading-6 text-gray-500">
                        Not a member?
                        {{ " " }}
                        <Link
                            :href="$route('register')"
                            class="font-semibold text-indigo-600 hover:text-indigo-500"
                            >Sign up now
                        </Link>
                    </p>
                </div>

                <div class="mt-10">
                    <div>
                        <form
                            @submit.prevent="
                                form.post($route('login'), {
                                    preserveScroll: true,
                                })
                            "
                            class="space-y-6"
                        >
                            <FormInput
                                id="email"
                                label="Email address"
                                placeholder="studymate@amlxv.com"
                                :model="form"
                                :error="form.errors.email"
                            />

                            <FormInput
                                id="password"
                                label="Password"
                                placeholder="********"
                                :model="form"
                                :error="form.errors.password"
                            />

                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <input
                                        id="remember"
                                        v-model="form.remember"
                                        type="checkbox"
                                        class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-600"
                                    />
                                    <label
                                        for="remember"
                                        class="ml-3 block text-sm leading-6 text-gray-700"
                                        >Remember me</label
                                    >
                                </div>

                                <div class="text-sm leading-6">
                                    <Link
                                        :href="$route('password.request')"
                                        class="font-semibold text-indigo-600 hover:text-indigo-500"
                                        >Forgot password?
                                    </Link>
                                </div>
                            </div>

                            <div>
                                <button
                                    :disabled="form.processing"
                                    type="submit"
                                    class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                                >
                                    Sign in
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
                            <SocialButton
                                id="github"
                                :href="
                                    $route('social-provider.redirect', 'github')
                                "
                            />

                            <SocialButton
                                id="google"
                                :href="
                                    $route('social-provider.redirect', 'google')
                                "
                            />
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
