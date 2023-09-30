<script setup lang="ts" xmlns="http://www.w3.org/1999/html">
import Layout from "@/layouts/Layout.vue";
import { Link, useForm } from "@inertiajs/vue3";
import SubmitButton from "@/composables/buttons/SubmitButton.vue";
import _ from "lodash";

const form = useForm({
    type: null,
    title: null,
    description: null,
    date: null,
    time_start: null,
    time_end: null,
    day_id: null,
    remind: false,
});
</script>

<template>
    <Layout>
        <div class="flex justify-between">
            <h1 class="mb-6 text-xl font-bold">New schedule</h1>
            <Link :href="$route('schedule.index')" class="text-sm text-red-500">
                Cancel
            </Link>
        </div>

        <div>
            <form @submit.prevent="form.post($route('schedule.store'))">
                <!-- Type -->
                <div class="my-4">
                    <div class="mb-2">Type</div>

                    <input
                        type="radio"
                        name="type"
                        id="class"
                        value="class"
                        v-model="form.type"
                        required
                    />
                    <label for="class" class="ml-2">Class</label>

                    <span class="inline-block w-4" />

                    <input
                        type="radio"
                        name="type"
                        id="activity"
                        value="activity"
                        v-model="form.type"
                    />
                    <label for="activity" class="ml-2">Activity</label>

                    <p
                        class="mt-4 text-sm text-red-500"
                        v-if="form.errors.type"
                    >
                        {{ form.errors.type }}
                    </p>

                    <p
                        class="mt-4 w-fit rounded-lg border border-dashed border-red-500 p-4 text-sm"
                        v-if="form.type === 'class'"
                    >
                        This is for fixed schedule normally used for timetable.
                        It will repeat every week on chosen day. <br />
                        <br />
                        TL;DR: Repeat every week.
                    </p>

                    <p
                        class="mt-4 w-fit rounded-lg border border-dashed border-red-500 p-4 text-sm"
                        v-if="form.type === 'activity'"
                    >
                        This is for flexible schedule. You can choose the date
                        when this activity will occur. <br />
                        <br />
                        TL;DR: Only once.
                    </p>
                </div>

                <!-- Title -->
                <div class="my-4">
                    <label for="title" class="mb-2 block">Title</label>

                    <input
                        class="rounded-lg"
                        type="text"
                        name="title"
                        id="title"
                        v-model="form.title"
                        required
                    />

                    <p
                        class="mt-4 text-sm text-red-500"
                        v-if="form.errors.title"
                    >
                        {{ form.errors.title }}
                    </p>
                </div>

                <!-- Description -->
                <div class="my-4">
                    <label for="description" class="mb-2 block"
                        >Description</label
                    >

                    <input
                        class="rounded-lg"
                        type="text"
                        name="description"
                        id="description"
                        v-model="form.description"
                        required
                    />

                    <p
                        class="mt-4 text-sm text-red-500"
                        v-if="form.errors.description"
                    >
                        {{ form.errors.description }}
                    </p>
                </div>

                <!-- Date (But only available if the TYPE is ACTIVITY)-->
                <div class="my-4" v-if="form.type === 'activity'">
                    <label for="date" class="mb-2 block">Date</label>

                    <input
                        class="rounded-lg"
                        type="date"
                        name="date"
                        id="date"
                        v-model="form.date"
                        required
                    />

                    <p class="ml-4 inline text-xs text-red-400">
                        * This is only available for activity schedule
                    </p>

                    <p
                        class="mt-4 text-sm text-red-500"
                        v-if="form.errors.date"
                    >
                        {{ form.errors.date }}
                    </p>
                </div>

                <!-- Day (But only available if the TYPE is CLASS)-->
                <div class="my-4" v-if="form.type === 'class'">
                    <label for="day" class="mb-2 block">Day</label>

                    <select v-model="form.day_id" class="rounded-lg">
                        <option v-for="day in $page.props.days" :value="day.id">
                            {{ _.capitalize(day.name) }}
                        </option>
                    </select>

                    <p class="ml-4 inline text-xs text-red-400">
                        * This is only available for class schedule
                    </p>

                    <p
                        class="mt-4 text-sm text-red-500"
                        v-if="form.errors.day_id"
                    >
                        {{ form.errors.day_id }}
                    </p>
                </div>

                <!-- Time Start -->
                <div class="my-4">
                    <label for="time_start" class="mb-2 block"
                        >Time (Start)</label
                    >

                    <input
                        class="rounded-lg"
                        type="time"
                        name="time_start"
                        id="time_start"
                        v-model="form.time_start"
                        required
                    />

                    <p
                        class="mt-4 text-sm text-red-500"
                        v-if="form.errors.time_start"
                    >
                        {{ form.errors.time_start }}
                    </p>
                </div>

                <!-- Time End -->
                <div class="my-4">
                    <label for="time_end" class="mb-2 block">Time (End)</label>

                    <input
                        class="rounded-lg"
                        type="time"
                        name="time_end"
                        id="time_end"
                        v-model="form.time_end"
                        required
                    />

                    <p
                        class="mt-4 text-sm text-red-500"
                        v-if="form.errors.time_end"
                    >
                        {{ form.errors.time_end }}
                    </p>
                </div>

                <!-- Remind -->
                <div class="my-4">
                    <div class="mb-2">Do you want to get reminder?</div>

                    <input
                        class="rounded"
                        type="checkbox"
                        name="remind"
                        id="remind"
                        v-model="form.remind"
                    />

                    <label for="remind" class="ml-4">Yes</label>

                    <p
                        class="mt-4 text-sm text-red-500"
                        v-if="form.errors.remind"
                    >
                        {{ form.errors.remind }}
                    </p>
                </div>

                <div class="mt-5 w-64">
                    <SubmitButton />
                </div>
            </form>
        </div>
    </Layout>
</template>
