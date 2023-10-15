<script setup lang="ts">
import { Link } from "@inertiajs/vue3";
import { defineProps, toRef } from "vue";
import { Cog6ToothIcon } from "@heroicons/vue/24/outline";
import { Navigation } from "@/types/layout";

const props = defineProps<{
    navigations: Navigation[];
}>();

const navigations = toRef(props.navigations);
</script>

<template>
    <div
        class="hidden lg:fixed lg:inset-y-0 lg:z-40 lg:flex lg:w-72 lg:flex-col"
    >
        <div
            class="flex grow flex-col gap-y-5 overflow-y-auto bg-indigo-600 px-6 pb-4"
        >
            <div class="flex h-16 shrink-0 items-center">
                <Link :href="route('home')">
                    <img
                        class="h-8 w-auto"
                        src="/assets/images/logo.png"
                        alt="StudyMate"
                    />
                </Link>
            </div>
            <nav class="flex flex-1 flex-col">
                <ul role="list" class="flex flex-1 flex-col gap-y-7">
                    <li>
                        <ul role="list" class="-mx-2 space-y-1">
                            <li v-for="item in navigations" :key="item.name">
                                <Link
                                    :href="route(item.href)"
                                    :class="[
                                        item.current
                                            ? 'bg-indigo-700 text-white'
                                            : 'text-indigo-200 hover:bg-indigo-700 hover:text-white',
                                        'group flex gap-x-3 rounded-md p-2 text-sm font-semibold leading-6',
                                    ]"
                                >
                                    <component
                                        :is="item.icon"
                                        :class="[
                                            item.current
                                                ? 'text-white'
                                                : 'text-indigo-200 group-hover:text-white',
                                            'h-6 w-6 shrink-0',
                                        ]"
                                        aria-hidden="true"
                                    />
                                    {{ item.name }}
                                </Link>
                            </li>
                        </ul>
                    </li>

                    <li class="mt-auto">
                        <a
                            href="#"
                            class="group -mx-2 flex gap-x-3 rounded-md p-2 text-sm font-semibold leading-6 text-indigo-200 hover:bg-indigo-700 hover:text-white"
                        >
                            <Cog6ToothIcon
                                class="h-6 w-6 shrink-0 text-indigo-200 group-hover:text-white"
                                aria-hidden="true"
                            />
                            Settings
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</template>
