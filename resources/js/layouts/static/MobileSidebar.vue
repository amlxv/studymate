<script setup lang="ts">
import { defineProps, toRefs } from "vue";
import { Link } from "@inertiajs/vue3";
import {
    Dialog,
    DialogPanel,
    TransitionChild,
    TransitionRoot,
} from "@headlessui/vue";
import { Cog6ToothIcon, XMarkIcon } from "@heroicons/vue/24/outline";
import { Navigation } from "@/types/layout";

const props = defineProps<{
    sidebarOpen: boolean;
    navigations: Navigation[];
}>();

const { sidebarOpen, navigations } = toRefs(props);
</script>

<template>
    <TransitionRoot as="template" :show="sidebarOpen">
        <Dialog
            as="div"
            class="relative z-50 lg:hidden"
            @close="$emit('sidebarClose')"
        >
            <TransitionChild
                as="template"
                enter="transition-opacity ease-linear duration-300"
                enter-from="opacity-0"
                enter-to="opacity-100"
                leave="transition-opacity ease-linear duration-300"
                leave-from="opacity-100"
                leave-to="opacity-0"
            >
                <div class="fixed inset-0 bg-gray-900/80" />
            </TransitionChild>

            <div class="fixed inset-0 flex">
                <TransitionChild
                    as="template"
                    enter="transition ease-in-out duration-300 transform"
                    enter-from="-translate-x-full"
                    enter-to="translate-x-0"
                    leave="transition ease-in-out duration-300 transform"
                    leave-from="translate-x-0"
                    leave-to="-translate-x-full"
                >
                    <DialogPanel
                        class="relative mr-16 flex w-full max-w-xs flex-1"
                    >
                        <TransitionChild
                            as="template"
                            enter="ease-in-out duration-300"
                            enter-from="opacity-0"
                            enter-to="opacity-100"
                            leave="ease-in-out duration-300"
                            leave-from="opacity-100"
                            leave-to="opacity-0"
                        >
                            <div
                                class="absolute left-full top-0 flex w-16 justify-center pt-5"
                            >
                                <button
                                    type="button"
                                    class="-m-2.5 p-2.5"
                                    @click="$emit('sidebarClose')"
                                >
                                    <span class="sr-only">Close sidebar</span>
                                    <XMarkIcon
                                        class="h-6 w-6 text-white"
                                        aria-hidden="true"
                                    />
                                </button>
                            </div>
                        </TransitionChild>
                        <div
                            class="flex grow flex-col gap-y-5 overflow-y-auto bg-indigo-700 px-6 pb-4"
                        >
                            <div class="flex h-16 shrink-0 items-center">
                                <Link :href="route('home')">
                                    <img
                                        class="h-8 w-auto"
                                        :src="
                                            route('home') +
                                            '/assets/images/logo.png'
                                        "
                                        alt="StudyMate"
                                    />
                                </Link>
                            </div>
                            <nav class="flex flex-1 flex-col">
                                <ul
                                    role="list"
                                    class="flex flex-1 flex-col gap-y-7"
                                >
                                    <li>
                                        <ul role="list" class="-mx-2 space-y-1">
                                            <li
                                                v-for="item in navigations"
                                                :key="item.name"
                                            >
                                                <Link
                                                    :href="route(item.href)"
                                                    :class="[
                                                        item.current
                                                            ? 'bg-indigo-800 text-white'
                                                            : 'text-indigo-200 hover:bg-indigo-600 hover:text-white',
                                                        'group flex gap-x-3 rounded-md p-2 text-sm font-semibold leading-6 transition-all',
                                                    ]"
                                                    v-if="
                                                        item?.role ==
                                                            $page.props?.auth
                                                                ?.user?.role ||
                                                        !item?.role
                                                    "
                                                >
                                                    <component
                                                        :is="item.icon"
                                                        :class="[
                                                            item.current
                                                                ? 'text-white'
                                                                : 'text-indigo-200 group-hover:text-white',
                                                            'h-6 w-6 shrink-0 transition-all',
                                                        ]"
                                                        aria-hidden="true"
                                                    />
                                                    {{ item.name }}
                                                </Link>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="mt-auto">
                                        <Link
                                            :href="
                                                route(
                                                    $page.props.auth.user
                                                        .role != 'admin'
                                                        ? 'setting.index'
                                                        : 'admin.setting.index',
                                                )
                                            "
                                            class="group -mx-2 flex gap-x-3 rounded-md p-2 text-sm font-semibold leading-6 text-indigo-200 hover:bg-indigo-700 hover:text-white"
                                            :class="{
                                                'bg-indigo-800 text-white hover:bg-indigo-800':
                                                    $page.url.startsWith(
                                                        '/setting' &&
                                                            '/admin/setting',
                                                    ),
                                            }"
                                        >
                                            <Cog6ToothIcon
                                                class="h-6 w-6 shrink-0 text-indigo-200 group-hover:text-white"
                                                aria-hidden="true"
                                            />
                                            Settings
                                        </Link>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </DialogPanel>
                </TransitionChild>
            </div>
        </Dialog>
    </TransitionRoot>
</template>
