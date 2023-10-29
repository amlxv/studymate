<script setup lang="ts">
import _ from "lodash";
import { usePage, router, Link } from "@inertiajs/vue3";
import Layout from "@/layouts/Layout.vue";
import SectionHeading from "@/composables/heading/SectionHeading.vue";
import { PlusIcon } from "@heroicons/vue/20/solid";
import { BellAlertIcon, BellSlashIcon } from "@heroicons/vue/24/solid";
import { CalendarIcon, ClockIcon } from "@heroicons/vue/24/outline";

const page = usePage();
</script>

<template>
    <Layout>
        <SectionHeading
            title="Upcoming Events"
            description="Discover your upcoming daily to-do list here."
        >
        </SectionHeading>

        <div class="mt-10">
            <div v-if="!_.isEmpty($page.props?.upcomingEvents)">
                <ol
                    class="mt-4 divide-y divide-gray-100 rounded-lg border border-gray-200 text-sm leading-6 lg:col-span-7 xl:col-span-8"
                >
                    <li
                        v-for="(event, index) in _.sortBy(
                            <Array<unknown>>$page.props?.upcomingEvents,
                            ['time_start'],
                        )"
                        :key="event?.id"
                        class="skew-x group relative flex cursor-pointer space-x-6 p-8 transition-all xl:static"
                        :class="{
                            'z-10 rounded-lg border border-indigo-200 bg-gradient-to-br from-indigo-800 to-indigo-400':
                                !index,
                            'lg:mx-5 lg:skew-x-3 lg:hover:mx-0 lg:hover:skew-x-0':
                                index,
                        }"
                        @click="router.get(route('schedule.edit', event?.id))"
                    >
                        <div
                            class="flex h-14 w-14 flex-none items-center justify-center rounded-full text-2xl font-semibold text-gray-800 transition-all"
                            :class="{
                                'animate-[bounce_1.8s_ease-in-out_infinite] bg-indigo-50 text-indigo-900 ':
                                    !index,
                                'group-hover:text-indigo-900': index,
                            }"
                        >
                            <span>{{ index + 1 }}</span>
                        </div>
                        <div class="w-full">
                            <h3
                                class="pr-10 font-semibold text-gray-900 xl:pr-0"
                                :class="{
                                    'text-white': !index,
                                    'group-hover:text-indigo-900': index,
                                }"
                            >
                                {{ event?.title }}
                            </h3>
                            <dl
                                class="mt-2 flex flex-col text-gray-500"
                                :class="{ 'text-white': !index }"
                            >
                                <div
                                    class="flex w-24 flex-none items-start space-x-3"
                                >
                                    <dt class="mt-0.5">
                                        <span class="sr-only">Date</span>
                                        <ClockIcon
                                            class="h-5 w-5 text-gray-400"
                                            :class="{ 'text-white': !index }"
                                            aria-hidden="true"
                                        />
                                    </dt>
                                    <dd>
                                        <time :datetime="event?.time_start">
                                            {{
                                                event?.time_start
                                                    .toString()
                                                    .slice(0, 5)
                                            }}
                                        </time>
                                    </dd>
                                </div>
                                <div class="mt-2 flex items-start space-x-3">
                                    <dd class="whitespace-pre-line">
                                        {{ event?.description }}
                                    </dd>
                                </div>
                            </dl>
                        </div>
                        <BellAlertIcon
                            v-if="event?.remind"
                            class="h-5 w-5 text-gray-400"
                            :class="{ 'text-white': !index }"
                        />

                        <BellSlashIcon
                            v-else
                            class="h-5 w-5 text-gray-400"
                            :class="{ 'text-white': !index }"
                        />
                    </li>
                </ol>
            </div>
            <div v-else class="mt-20 py-16">
                <div class="text-center">
                    <CalendarIcon class="mx-auto h-14 w-14 text-gray-400" />

                    <h3 class="mt-2 text-sm font-semibold text-gray-900">
                        Nothing here
                    </h3>
                    <p class="mt-1 text-sm text-gray-500">
                        You have no tasks anymore for today. Have a good day!
                    </p>
                    <div class="mt-6">
                        <Link :href="route('schedule.create')">
                            <button
                                type="button"
                                class="inline-flex items-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                            >
                                <PlusIcon
                                    class="-ml-0.5 mr-1.5 h-5 w-5"
                                    aria-hidden="true"
                                />
                                New Schedule
                            </button>
                        </Link>
                    </div>
                </div>
            </div>
        </div>
    </Layout>
</template>
