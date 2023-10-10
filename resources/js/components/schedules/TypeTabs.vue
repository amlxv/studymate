<script setup lang="ts">
import { defineProps } from "vue";
import { AcademicCapIcon, CalendarIcon } from "@heroicons/vue/24/outline";

const props = defineProps<{
    type: string;
}>();

const tabs = [
    {
        name: "Class Timetable",
        key: "class",
        icon: AcademicCapIcon,
    },
    {
        name: "Activities",
        key: "activity",
        icon: CalendarIcon,
    },
];
</script>

<template>
    <div class="mt-6">
        <div class="sm:hidden">
            <label for="tabs" class="sr-only">Select a tab</label>
            <select
                id="tabs"
                name="tabs"
                class="block w-full rounded-md focus:border-indigo-500 focus:ring-indigo-500"
                @change="$emit('typeChange', $event.target.value)"
            >
                <option
                    v-for="tab in tabs"
                    :key="tab.key"
                    :selected="tab.key == type"
                    :value="tab.key"
                >
                    {{ tab.name }}
                </option>
            </select>
        </div>
        <div class="hidden sm:block">
            <div class="">
                <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                    <div
                        v-for="tab in tabs"
                        :key="tab.key"
                        :class="[
                            tab.key == type
                                ? 'border-indigo-500 text-indigo-600'
                                : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700',
                            'group inline-flex cursor-pointer items-center border-b-2 px-1 py-4 text-sm font-medium',
                        ]"
                        @click="$emit('typeChange', tab.key)"
                    >
                        <component
                            :is="tab.icon"
                            :class="[
                                tab.key == type
                                    ? 'text-indigo-500'
                                    : 'text-gray-400 group-hover:text-gray-500',
                                '-ml-0.5 mr-2 h-5 w-5',
                            ]"
                            aria-hidden="true"
                        />
                        <span>{{ tab.name }}</span>
                    </div>
                </nav>
            </div>
        </div>
    </div>
</template>
