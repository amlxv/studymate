<script setup lang="ts">
import _ from "lodash";
import Layout from "@/layouts/Layout.vue";
import SectionHeading from "@/composables/heading/SectionHeading.vue";
import { Link } from "@inertiajs/vue3";
import { PencilSquareIcon } from "@heroicons/vue/24/outline";
</script>

<template>
    <Layout>
        <SectionHeading
            title="Courses"
            description="The section where you can manage the courses."
        >
            <Link :href="route('course.create')">
                <button
                    type="button"
                    class="inline-flex items-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                >
                    Create
                </button>
            </Link>
        </SectionHeading>

        <div class="px-4 sm:px-6 lg:px-8">
            <div class="mt-8 flow-root">
                <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="inline-block min-w-full py-2 align-middle">
                        <table class="min-w-full divide-y divide-gray-300">
                            <thead>
                                <tr>
                                    <th
                                        scope="col"
                                        class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6 lg:pl-8"
                                    >
                                        No.
                                    </th>
                                    <th
                                        scope="col"
                                        class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900"
                                    >
                                        Name
                                    </th>
                                    <th
                                        scope="col"
                                        class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900"
                                    >
                                        Code
                                    </th>
                                    <th
                                        scope="col"
                                        class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900"
                                    >
                                        Group
                                    </th>
                                    <th
                                        scope="col"
                                        class="relative py-3.5 pl-3 pr-4 sm:pr-6 lg:pr-8"
                                    >
                                        <span class="sr-only"></span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 bg-white">
                                <tr
                                    v-for="(course, index) in $page.props
                                        ?.courses"
                                    :key="course?.id"
                                    v-if="!_.isEmpty($page.props?.courses)"
                                >
                                    <td
                                        class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6 lg:pl-8"
                                    >
                                        {{ index + 1 }}
                                    </td>
                                    <td class="px-3 py-4 text-sm text-gray-500">
                                        {{ course?.name }}
                                    </td>
                                    <td
                                        class="whitespace-nowrap px-3 py-4 text-sm text-gray-500"
                                    >
                                        {{ course?.code }}
                                    </td>
                                    <td
                                        class="whitespace-nowrap px-3 py-4 text-sm text-gray-500"
                                    >
                                        {{ course?.group }}
                                    </td>
                                    <td
                                        class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6 lg:pr-8"
                                    >
                                        <Link
                                            :href="
                                                route('course.edit', course?.id)
                                            "
                                            class="text-indigo-600 hover:text-indigo-900"
                                        >
                                            <PencilSquareIcon class="h-5 w-5" />
                                            <span class="sr-only"
                                                >, {{ course?.id }}</span
                                            ></Link
                                        >
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </Layout>
</template>
