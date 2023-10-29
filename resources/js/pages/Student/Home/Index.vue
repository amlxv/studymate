<script setup lang="ts">
import { ref } from "vue";
import { usePage } from "@inertiajs/vue3";
import Layout from "@/layouts/Layout.vue";
import SectionHeading from "@/composables/heading/SectionHeading.vue";
import {
    AcademicCapIcon,
    CalendarDaysIcon,
    RectangleStackIcon,
} from "@heroicons/vue/24/outline";

const page = usePage();

const stats = ref([
    {
        name: "Total Classes",
        stat: page.props?.schedules?.classes?.length ?? 0,
        icon: AcademicCapIcon,
    },
    {
        name: "Total Activities",
        stat: page.props?.schedules?.activities?.length ?? 0,
        icon: RectangleStackIcon,
    },
    {
        name: "Total Schedules",
        stat:
            page.props?.schedules?.classes?.length +
                page.props?.schedules?.activities?.length ?? 0,
        icon: CalendarDaysIcon,
    },
]);
</script>

<template>
    <Layout>
        <SectionHeading
            title="Dashboard"
            description="View the trends in more details."
        >
        </SectionHeading>

        <div class="mt-8">
            <div>
                <dl class="mt-5 grid grid-cols-1 gap-5 sm:grid-cols-3">
                    <div
                        v-for="item in stats"
                        :key="item.name"
                        class="group flex items-center justify-between overflow-hidden rounded-xl border border-gray-200 bg-white px-4 py-5 transition-all duration-500 hover:border-indigo-300 hover:bg-indigo-50 sm:p-6"
                    >
                        <div>
                            <dt
                                class="truncate text-sm font-medium text-gray-500 group-hover:text-indigo-500"
                            >
                                {{ item.name }}
                            </dt>
                            <dd
                                class="mt-1 text-3xl font-semibold tracking-tight text-gray-900"
                            >
                                {{ item.stat }}
                            </dd>
                        </div>

                        <div>
                            <component
                                :is="item.icon"
                                class="h-8 w-8 text-slate-600 group-hover:text-indigo-500"
                            ></component>
                        </div>
                    </div>
                </dl>
            </div>
        </div>

        <!--       CHART HERE       -->
    </Layout>
</template>
