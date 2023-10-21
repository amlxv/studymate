<script setup lang="ts">
import _ from "lodash";
import { computed, onMounted, ref } from "vue";
import { Link, usePage, router } from "@inertiajs/vue3";
import Layout from "@/layouts/Layout.vue";
import SectionHeading from "@/composables/heading/SectionHeading.vue";
import InfoModal from "@/components/schedules/InfoModal.vue";
import { ClockIcon } from "@heroicons/vue/20/solid";
import {
    calculateDaysDifferenceByDayName,
    days,
} from "@/composables/etc/utils";
import DeleteConfirmation from "@/composables/modals/DeleteConfirmation.vue";
import { TrashIcon } from "@heroicons/vue/24/outline";

const page = usePage();
const selectedDay = ref();
const selectedEvent = ref();

const schedules = computed(() => page.props.schedules);

const isInfoModalOpen = ref(false);
const isDeleteConfirmationModalOpen = ref(false);

onMounted(() => {
    selectedDay.value = schedules.value.find(
        (schedule) => schedule["isToday"] == true,
    )?.["events"];
});

const handleInfoModal = (event) => {
    selectedEvent.value = event;
    isInfoModalOpen.value = true;
};

const handleDelete = (path) => {
    router.delete(path);
    isDeleteConfirmationModalOpen.value = false;
};

const handleDeleteConfirmationModal = () => {
    isInfoModalOpen.value = false;
    isDeleteConfirmationModalOpen.value = true;
};
</script>

<template>
    <InfoModal
        :open="isInfoModalOpen"
        @close="isInfoModalOpen = false"
        :event="selectedEvent"
        @delete="handleDeleteConfirmationModal"
    />
    <DeleteConfirmation
        :open="isDeleteConfirmationModalOpen"
        @close="isDeleteConfirmationModalOpen = false"
        @delete="handleDelete(route('schedule.destroy', selectedEvent.id))"
    />
    <Layout>
        <SectionHeading
            title="Schedules"
            description="Where all the schedules within month are being managed."
        >
            <Link :href="route('schedule.all')">
                <button
                    type="button"
                    class="mr-2 inline-flex items-center bg-white px-4 py-2 text-sm font-semibold text-indigo-500"
                >
                    View all
                </button>
            </Link>

            <Link :href="route('schedule.create')">
                <button
                    type="button"
                    class="inline-flex items-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                >
                    Create
                </button>
            </Link>
        </SectionHeading>

        <div class="mt-10">
            <div class="lg:flex lg:h-full lg:flex-col">
                <div
                    class="shadow ring-1 ring-black ring-opacity-5 lg:flex lg:flex-auto lg:flex-col"
                >
                    <div
                        class="grid grid-cols-7 gap-px border-b border-gray-300 bg-gray-200 text-center text-xs font-semibold leading-6 text-gray-700 lg:flex-none"
                    >
                        <div class="bg-white py-2" v-for="day in days">
                            {{ day[0]
                            }}<span class="sr-only sm:not-sr-only">{{
                                day.slice(1)
                            }}</span>
                        </div>
                    </div>
                    <div
                        class="flex bg-gray-200 text-xs leading-6 text-gray-700 lg:flex-auto"
                    >
                        <div
                            class="hidden min-h-[65vh] w-full lg:grid lg:grid-cols-7 lg:grid-rows-6 lg:gap-px"
                        >
                            <div
                                v-for="index in calculateDaysDifferenceByDayName(
                                    'Monday',
                                    _.capitalize(schedules[0].day),
                                    days,
                                )"
                                :key="index"
                                v-if="schedules.day !== 'monday'"
                                class="relative bg-slate-50 px-3 py-2"
                            />
                            <div
                                v-for="schedule in schedules"
                                :key="schedule['date']"
                                class="relative bg-white px-3 py-2 transition-colors hover:bg-gray-50"
                            >
                                <time
                                    :datetime="schedule['date']"
                                    :class="
                                        schedule['isToday']
                                            ? 'flex h-6 w-6 items-center justify-center rounded-full bg-indigo-600 font-semibold text-white'
                                            : undefined
                                    "
                                >
                                    {{
                                        schedule["date"]
                                            .split("-")
                                            .pop()
                                            .replace(/^0/, "")
                                    }}
                                </time>
                                <ol
                                    v-if="schedule['events'].length > 0"
                                    class="mt-2"
                                >
                                    <li
                                        v-for="(event, index) in schedule[
                                            'events'
                                        ].slice(0, 2)"
                                        :key="event.id"
                                    >
                                        <div
                                            class="group flex cursor-pointer"
                                            @click="handleInfoModal(event)"
                                        >
                                            <p
                                                class="flex-auto truncate font-medium text-gray-900 group-hover:text-indigo-600"
                                            >
                                                {{ index + 1 }}.
                                                {{ event["title"] }}
                                            </p>
                                            <time
                                                :datetime="event['time_start']"
                                                class="ml-3 hidden flex-none text-gray-500 group-hover:text-indigo-600 xl:block"
                                            >
                                                {{
                                                    event["time_start"]
                                                        .toString()
                                                        .slice(0, 5)
                                                }}
                                            </time>
                                        </div>
                                    </li>
                                    <li
                                        v-if="schedule['events'].length > 2"
                                        class="text-gray-500"
                                    >
                                        + {{ schedule["events"].length - 2 }}
                                        more
                                    </li>
                                </ol>
                            </div>

                            <div
                                v-for="index in calculateDaysDifferenceByDayName(
                                    _.capitalize(
                                        _.last(<Array<unknown>>schedules).day,
                                    ),
                                    'Sunday',
                                    days,
                                )"
                                :key="index"
                                v-if="schedules[0].day !== 'monday'"
                                class="relative bg-slate-50 px-3 py-2"
                            />
                        </div>

                        <!-- Mobile -->
                        <div
                            class="isolate grid w-full grid-cols-7 grid-rows-6 gap-px lg:hidden"
                        >
                            <button
                                v-for="index in calculateDaysDifferenceByDayName(
                                    'Monday',
                                    _.capitalize(schedules[0].day),
                                    days,
                                )"
                                :key="index"
                                v-if="schedules[0].day !== 'monday'"
                                type="button"
                                class="flex h-14 cursor-default flex-col bg-slate-50 px-3 py-2 focus:z-10"
                            />
                            <button
                                v-for="schedule in schedules"
                                :key="schedule['date']"
                                type="button"
                                :class="[
                                    (schedule['events'] == selectedDay ||
                                        schedule['isToday']) &&
                                        'font-semibold',
                                    schedule['events'] == selectedDay &&
                                        'text-white',
                                    !schedule['events'] == selectedDay &&
                                        schedule['isToday'] &&
                                        'text-indigo-600',
                                    !schedule['events'] == selectedDay &&
                                        !schedule['isToday'] &&
                                        'text-gray-900',
                                    'flex h-14 flex-col bg-white px-3 py-2 hover:bg-gray-100 focus:z-10',
                                ]"
                                @click="selectedDay = schedule['events']"
                            >
                                <time
                                    :datetime="schedule['date']"
                                    :class="[
                                        schedule['events'] == selectedDay &&
                                            'flex h-6 w-6 items-center justify-center rounded-full',
                                        schedule['events'] == selectedDay &&
                                            schedule['isToday'] &&
                                            'bg-indigo-600',
                                        schedule['events'] == selectedDay &&
                                            !schedule['isToday'] &&
                                            'bg-gray-900',
                                        'ml-auto',
                                    ]"
                                >
                                    {{
                                        schedule["date"]
                                            .split("-")
                                            .pop()
                                            .replace(/^0/, "")
                                    }}
                                </time>
                                <span class="sr-only"
                                    >{{
                                        schedule["events"].length
                                    }}
                                    events</span
                                >
                                <span
                                    v-if="schedule['events'].length > 0"
                                    class="-mx-0.5 mt-auto flex flex-wrap-reverse"
                                >
                                    <span
                                        v-for="index in 5"
                                        :key="index"
                                        class="mx-0.5 mb-1 h-1.5 w-1.5 rounded-full bg-gray-400"
                                    />
                                </span>
                            </button>
                            <button
                                v-for="index in calculateDaysDifferenceByDayName(
                                    _.capitalize(
                                        _.last(<Array<unknown>>schedules).day,
                                    ),
                                    'Sunday',
                                    days,
                                )"
                                :key="index"
                                v-if="schedules[0].day !== 'monday'"
                                type="button"
                                class="flex h-14 cursor-default flex-col bg-slate-100 px-3 py-2 focus:z-10"
                            />
                        </div>
                    </div>
                </div>

                <!-- Mobile -->
                <div v-if="selectedDay" class="px-4 py-10 sm:px-6 lg:hidden">
                    <ol
                        class="divide-y divide-gray-100 overflow-hidden rounded-lg bg-white text-sm shadow ring-1 ring-black ring-opacity-5"
                    >
                        <li
                            v-for="(event, index) in selectedDay"
                            :key="event.id"
                            class="group flex p-4 pr-6 focus-within:bg-gray-50 hover:bg-gray-50"
                        >
                            <div class="flex-auto">
                                <p class="mb-1 font-semibold text-gray-900">
                                    {{ index + 1 }}. {{ event["title"] }}
                                </p>
                                <p
                                    class="whitespace-pre-line text-xs font-light text-gray-800"
                                >
                                    {{ event["description"] }}
                                </p>
                                <time
                                    class="mt-2 flex items-center text-gray-700"
                                >
                                    <ClockIcon
                                        class="mr-2 h-5 w-5 text-gray-400"
                                        aria-hidden="true"
                                    />
                                    {{
                                        event["time_start"]
                                            .toString()
                                            .slice(0, 5)
                                    }}
                                </time>
                            </div>

                            <div
                                class="ml-6 flex-none cursor-pointer self-center rounded-md bg-white px-3 py-2 font-semibold text-gray-900 opacity-0 shadow-sm ring-1 ring-inset ring-gray-300 hover:ring-gray-400 focus:opacity-100 group-hover:opacity-100"
                                @click="
                                    selectedEvent = event;
                                    handleDeleteConfirmationModal();
                                "
                            >
                                <TrashIcon class="h-5" />
                            </div>

                            <Link
                                :href="route('schedule.edit', event.id)"
                                class="ml-1 flex-none self-center rounded-md bg-white px-3 py-2 font-semibold text-gray-900 opacity-0 shadow-sm ring-1 ring-inset ring-gray-300 hover:ring-gray-400 focus:opacity-100 group-hover:opacity-100"
                                >Edit<span class="sr-only"
                                    >, {{ event["title"] }}</span
                                ></Link
                            >
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </Layout>
</template>
