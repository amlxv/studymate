<script setup lang="ts">
import _ from "lodash";
import { toRefs, defineProps } from "vue";
import { Student } from "@/types/common";
import { PencilSquareIcon, TrashIcon } from "@heroicons/vue/24/outline";
import { UserCircleIcon } from "@heroicons/vue/24/solid";
import { getImagePath } from "@/composables/etc/utils";

const props = defineProps<{
    students: Student[];
    onEdit?: Function;
    onDelete?: Function | void;
}>();

const { students, onEdit, onDelete } = toRefs(props);
</script>

<template>
    <table class="min-w-full divide-y divide-gray-300">
        <thead>
            <tr>
                <th
                    scope="col"
                    class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-0"
                >
                    Name
                </th>
                <th
                    scope="col"
                    class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900"
                >
                    Student ID
                </th>
                <th
                    scope="col"
                    class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900"
                >
                    Program
                </th>

                <th
                    scope="col"
                    class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900"
                >
                    Campus
                </th>
                <th
                    scope="col"
                    class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900"
                >
                    Gender
                </th>
                <th
                    scope="col"
                    class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900"
                >
                    Status
                </th>
                <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-0">
                    <span class="sr-only">Edit</span>
                </th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200 bg-white">
            <tr v-for="student in students" :key="student?.email">
                <td class="whitespace-nowrap py-5 pl-4 pr-3 text-sm sm:pl-0">
                    <div class="flex items-center">
                        <div class="h-11 w-11 flex-shrink-0">
                            <img
                                v-if="student?.avatar"
                                class="h-11 w-11 rounded-full"
                                :src="getImagePath(student?.avatar as string)"
                                alt=""
                            />
                            <UserCircleIcon
                                v-else
                                class="h-11 w-11 rounded-full text-gray-300"
                                aria-hidden="true"
                            />
                        </div>
                        <div class="ml-4">
                            <div class="font-medium text-gray-900">
                                {{ student?.name }}
                            </div>
                            <div class="mt-1 text-gray-500">
                                {{ student?.email }}
                            </div>
                        </div>
                    </div>
                </td>
                <td class="whitespace-nowrap px-3 py-5 text-sm text-gray-500">
                    {{ student?.student_id }}
                </td>
                <td class="whitespace-nowrap px-3 py-5 text-sm text-gray-500">
                    <div class="text-gray-900">
                        {{ student?.program }}
                    </div>
                    <div class="text-gray500 mt-1">
                        {{ student?.faculty }}
                    </div>
                </td>
                <td class="whitespace-nowrap px-3 py-5 text-sm text-gray-500">
                    {{ student?.campus }}
                </td>
                <td class="whitespace-nowrap px-3 py-5 text-sm text-gray-500">
                    {{ _.capitalize(student?.gender) }}
                </td>
                <td class="whitespace-nowrap px-3 py-5 text-sm text-gray-500">
                    <span
                        v-if="
                            student?.student_id &&
                            student?.campus &&
                            student?.faculty &&
                            student?.program
                        "
                        class="inline-flex items-center rounded-md bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20"
                        >Active</span
                    >
                    <span
                        v-else
                        class="inline-flex items-center rounded-md bg-red-50 px-2 py-1 text-xs font-medium text-red-700 ring-1 ring-inset ring-red-600/20"
                        >Pending</span
                    >
                </td>

                <td
                    class="relative whitespace-nowrap py-5 pl-3 pr-4 text-right text-sm font-medium sm:pr-0"
                >
                    <div class="flex space-x-2">
                        <TrashIcon
                            class="h-5 w-5 cursor-pointer text-red-400 hover:text-red-700"
                            @click="() => onDelete(student)"
                        />
                        <PencilSquareIcon
                            class="h-5 w-5 cursor-pointer text-indigo-600 hover:text-indigo-900"
                            @click="() => onEdit(student)"
                        />
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
</template>
