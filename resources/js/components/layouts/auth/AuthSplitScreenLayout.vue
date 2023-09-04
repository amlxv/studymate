<!-- Note: Only used/suitable for registration and sign in -->

<script setup lang="ts">
import { defineProps } from "vue";
import { Link } from "@inertiajs/vue3";
import SocialButton from "@/components/common/buttons/SocialButton.vue";
import BaseIcon from "@/components/common/BaseIcon.vue";
import Toast from "@/components/common/notifications/Toast.vue";

const props = defineProps<{
    label: string;
    callback?: string;
    callbackPreMessage?: string;
    callbackMessage?: string;
    image: string;
}>();
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
                        {{ label }}
                    </h2>
                    <p
                        v-if="!!callback"
                        class="mt-2 text-sm leading-6 text-gray-500"
                    >
                        {{ callbackPreMessage }}
                        {{ " " }}
                        <Link
                            :href="callback"
                            class="font-semibold text-indigo-600 hover:text-indigo-500"
                            >{{ callbackMessage }}
                        </Link>
                    </p>
                </div>

                <div class="mt-10">
                    <div>
                        <slot name="form" />
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
                            >
                                <template v-slot:icon>
                                    <BaseIcon name="github" />
                                </template>
                            </SocialButton>

                            <SocialButton
                                id="google"
                                :href="
                                    $route('social-provider.redirect', 'google')
                                "
                            >
                                <template v-slot:icon>
                                    <BaseIcon name="google" />
                                </template>
                            </SocialButton>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="relative hidden w-0 flex-1 lg:block">
            <img
                class="absolute inset-0 h-full w-full object-cover"
                :src="image"
                alt="An image for illustration"
            />
        </div>
    </div>

    <Toast />
</template>
