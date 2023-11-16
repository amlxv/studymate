<script setup lang="ts">
import _ from "lodash";
import { toRefs, defineProps } from "vue";
import { Course } from "@/types/common";
import { PencilSquareIcon, TrashIcon } from "@heroicons/vue/24/outline";

const props = defineProps<{
    courses: Course[];
    onEdit: Function;
    onDelete: Function | void;
}>();

const { courses, onEdit, onDelete } = toRefs(props);
</script>

<template>
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
                    v-if="_.has(courses, '[0].user')"
                    scope="col"
                    class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900"
                >
                    Student Name
                </th>
                <th
                    v-if="_.has(courses, '[0].student')"
                    scope="col"
                    class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900"
                >
                    Student ID
                </th>
                <th
                    scope="col"
                    class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900"
                >
                    Course Name
                </th>
                <th
                    scope="col"
                    class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900"
                >
                    Course Code
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
                v-for="(course, index) in courses"
                :key="course?.id"
                v-if="!_.isEmpty(courses)"
            >
                <td
                    class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6 lg:pl-8"
                >
                    {{ index + 1 }}
                </td>
                <td
                    v-if="_.has(courses, '[0].user')"
                    class="px-3 py-4 text-sm text-gray-500"
                >
                    {{ course?.user?.name }}
                </td>
                <td
                    v-if="_.has(courses, '[0].student')"
                    class="px-3 py-4 text-sm text-gray-500"
                >
                    {{ course?.student?.student_id }}
                </td>
                <td class="px-3 py-4 text-sm text-gray-500">
                    {{ course?.name }}
                </td>
                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                    {{ course?.code }}
                </td>
                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                    {{ course?.group }}
                </td>
                <td
                    class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6 lg:pr-8"
                >
                    <div class="flex space-x-2">
                        <TrashIcon
                            class="h-5 w-5 cursor-pointer text-red-400 hover:text-red-700"
                            @click="() => onDelete(course)"
                        />
                        <PencilSquareIcon
                            class="h-5 w-5 cursor-pointer text-indigo-600 hover:text-indigo-900"
                            @click="() => onEdit(course)"
                        />
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
</template>
