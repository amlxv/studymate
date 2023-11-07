<script setup lang="ts">
import _ from "lodash";
import moment from "moment";
import { toRefs } from "vue";
import { Link } from "@inertiajs/vue3";
import { PencilSquareIcon } from "@heroicons/vue/24/outline";

const props = defineProps<{
    type: string;
    classes: unknown;
    activities: unknown;
    form: unknown;
}>();

const { type, classes, activities, form } = toRefs(props);
</script>

<template>
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
                                    Title
                                </th>
                                <th
                                    v-if="'name' in classes.data[0]"
                                    scope="col"
                                    class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900"
                                >
                                    Student Name
                                </th>
                                <th
                                    v-if="'name' in classes.data[0]"
                                    scope="col"
                                    class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900"
                                >
                                    Email
                                </th>
                                <th
                                    scope="col"
                                    class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900"
                                >
                                    Description
                                </th>
                                <th
                                    v-if="type == 'class'"
                                    scope="col"
                                    class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900"
                                >
                                    Day
                                </th>
                                <th
                                    v-if="type == 'activity'"
                                    scope="col"
                                    class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900"
                                >
                                    Date
                                </th>
                                <th
                                    scope="col"
                                    class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900"
                                >
                                    Start
                                </th>
                                <th
                                    scope="col"
                                    class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900"
                                >
                                    End
                                </th>
                                <th
                                    scope="col"
                                    class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900"
                                >
                                    Reminder
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
                                v-for="item in classes.data"
                                :key="item.id"
                                v-if="type == 'class'"
                            >
                                <td
                                    class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6 lg:pl-8"
                                >
                                    {{ _.capitalize(item.title) }}
                                </td>
                                <td
                                    class="whitespace-nowrap px-3 py-4 text-sm text-gray-500"
                                >
                                    {{ item.name }}
                                </td>
                                <td
                                    class="whitespace-nowrap px-3 py-4 text-sm text-gray-500"
                                >
                                    {{ item.email }}
                                </td>
                                <td class="px-3 py-4 text-sm text-gray-500">
                                    {{
                                        item.description.toString().slice(0, 35)
                                    }}
                                </td>
                                <td
                                    class="whitespace-nowrap px-3 py-4 text-sm text-gray-500"
                                >
                                    {{ _.capitalize(item.day) }}
                                </td>
                                <td
                                    class="whitespace-nowrap px-3 py-4 text-sm text-gray-500"
                                >
                                    {{ item.time_start.toString().slice(0, 5) }}
                                </td>
                                <td
                                    class="whitespace-nowrap px-3 py-4 text-sm text-gray-500"
                                >
                                    {{ item.time_end.toString().slice(0, 5) }}
                                </td>
                                <td
                                    class="whitespace-nowrap px-3 py-4 text-sm text-gray-500"
                                >
                                    {{ item.remind ? "Yes" : "No" }}
                                </td>

                                <td
                                    class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6 lg:pr-8"
                                >
                                    <Link
                                        :href="
                                            route(
                                                $page.props.auth.user.role !=
                                                    'admin'
                                                    ? 'schedule.edit'
                                                    : 'admin.schedule.edit',
                                                item.id,
                                            )
                                        "
                                        class="text-indigo-600 hover:text-indigo-900"
                                    >
                                        <PencilSquareIcon class="h-5 w-5" />
                                        <span class="sr-only"
                                            >, {{ item.id }}</span
                                        ></Link
                                    >
                                </td>
                            </tr>

                            <tr
                                v-for="item in activities.data"
                                :key="item.id"
                                v-if="type == 'activity'"
                            >
                                <td
                                    class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6 lg:pl-8"
                                >
                                    {{ item.title }}
                                </td>
                                <td
                                    class="whitespace-nowrap px-3 py-4 text-sm text-gray-500"
                                >
                                    {{ item.name }}
                                </td>
                                <td
                                    class="whitespace-nowrap px-3 py-4 text-sm text-gray-500"
                                >
                                    {{ item.email }}
                                </td>
                                <td class="px-3 py-4 text-sm text-gray-500">
                                    {{ item.description.toString().slice(0, 35)
                                    }}{{
                                        item.description.toString().length >= 35
                                            ? "..."
                                            : ""
                                    }}
                                </td>
                                <td
                                    class="whitespace-nowrap px-3 py-4 text-sm text-gray-500"
                                >
                                    {{ moment(item.date).format("DD MMM Y") }}
                                </td>
                                <td
                                    class="whitespace-nowrap px-3 py-4 text-sm text-gray-500"
                                >
                                    {{ item.time_start.toString().slice(0, 5) }}
                                </td>
                                <td
                                    class="whitespace-nowrap px-3 py-4 text-sm text-gray-500"
                                >
                                    {{ item.time_end.toString().slice(0, 5) }}
                                </td>
                                <td
                                    class="whitespace-nowrap px-3 py-4 text-sm text-gray-500"
                                >
                                    {{ item.remind ? "Yes" : "No" }}
                                </td>

                                <td
                                    class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6 lg:pr-8"
                                >
                                    <Link
                                        :href="
                                            route(
                                                $page.props.auth.user.role !=
                                                    'admin'
                                                    ? 'schedule.edit'
                                                    : 'admin.schedule.edit',
                                                item.id,
                                            )
                                        "
                                        class="text-indigo-600 hover:text-indigo-900"
                                    >
                                        <PencilSquareIcon class="h-5 w-5" />
                                        <span class="sr-only"
                                            >, {{ item.id }}</span
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
</template>
