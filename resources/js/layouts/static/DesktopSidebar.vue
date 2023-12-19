<script setup lang="ts">
import { Link, useForm, usePage } from "@inertiajs/vue3";
import { defineProps, toRef } from "vue";
import { Ziggy } from "@/ziggy";
import {
    Cog6ToothIcon,
    QuestionMarkCircleIcon,
} from "@heroicons/vue/24/outline";
import { Navigation } from "@/types/layout";
import StudyMateLogo from "@images/logo.png";
import UiTMLogo from "@images/uitm.png";

const props = defineProps<{
    navigations: Navigation[];
}>();

const navigations = toRef(props.navigations);
const page = usePage();

const resetGuide = () => {
    const form = useForm({
        _method: "put",
        intro: true,
    });

    form.post(
        Ziggy.routes["profile.update"].uri.replace(
            /{.+}/,
            page.props.auth.user?.id,
        ),
        { onSuccess: () => location.reload() },
    );
};
</script>

<template>
    <div
        class="hidden lg:fixed lg:inset-y-0 lg:z-40 lg:flex lg:w-72 lg:flex-col"
    >
        <div
            class="flex grow flex-col gap-y-5 overflow-y-auto bg-indigo-700 px-6 pb-4"
            data-step="2"
            data-intro="To help you easily access all areas of our site, we've provided this handy navigation sidebar. You'll find links to all main pages here."
        >
            <div class="mt-4 flex h-16 shrink-0 items-center">
                <Link
                    :href="route('home')"
                    class="flex w-full items-center justify-center space-x-2"
                >
                    <img
                        class="h-8 w-auto"
                        :src="StudyMateLogo"
                        alt="StudyMate"
                    />
                    <span
                        class="rotate-1 transform text-xs font-light text-white brightness-75"
                        >x</span
                    >
                    <img class="h-16 w-auto" :src="UiTMLogo" alt="UiTM Logo" />
                </Link>
            </div>
            <nav class="flex flex-1 flex-col">
                <ul role="list" class="flex flex-1 flex-col gap-y-7">
                    <li>
                        <ul role="list" class="-mx-2 space-y-1">
                            <li v-for="item in navigations" :key="item.name">
                                <Link
                                    :data-intro="item?.dataIntro"
                                    :data-step="item?.dataStep"
                                    :href="route(item.href)"
                                    :class="[
                                        item.current
                                            ? 'bg-indigo-800 text-white'
                                            : 'text-indigo-200 hover:bg-indigo-600 hover:text-white',
                                        'group flex gap-x-3 rounded-md p-2 text-sm font-semibold leading-6 transition-all',
                                    ]"
                                    v-if="
                                        item?.role ==
                                            $page.props?.auth?.user?.role ||
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

                            <!-- Add an option to show the guide again -->
                            <li
                                data-intro="Click here if you want to see this guide again.<br/><br/>That's all! Thank you."
                                data-step="10"
                            >
                                <div
                                    @click="resetGuide"
                                    class="group flex cursor-pointer gap-x-3 rounded-md p-2 text-sm font-semibold leading-6 text-indigo-200 transition-all hover:bg-indigo-600 hover:text-white"
                                >
                                    <QuestionMarkCircleIcon
                                        class="h-6 w-6 shrink-0 text-white transition-all"
                                    />

                                    Guide
                                </div>
                            </li>
                        </ul>
                    </li>

                    <li class="mt-auto">
                        <Link
                            data-intro="Customize your account preferences and notifications. Link your Telegram, set customized messaging, and configure time before send for reminder."
                            data-step="7"
                            :href="
                                route(
                                    $page.props.auth.user.role != 'admin'
                                        ? 'setting.index'
                                        : 'admin.setting.index',
                                )
                            "
                            class="group -mx-2 flex gap-x-3 rounded-md p-2 text-sm font-semibold leading-6 text-indigo-200 hover:bg-indigo-700 hover:text-white"
                            :class="{
                                'bg-indigo-800 text-white hover:bg-indigo-800':
                                    $page.url.startsWith(
                                        '/setting' && '/admin/setting',
                                    ),
                            }"
                        >
                            <Cog6ToothIcon
                                class="h-6 w-6 shrink-0 text-indigo-200 group-hover:text-white"
                                aria-hidden="true"
                                :class="{
                                    'text-white': $page.url.startsWith(
                                        '/setting' && '/admin/setting',
                                    ),
                                }"
                            />
                            Settings
                        </Link>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</template>
