<script setup lang="ts">
import moment from "moment";
import { computed } from "vue";
import { useForm, Link } from "@inertiajs/vue3";
import Layout from "@/layouts/Layout.vue";
import Button from "@/composables/buttons/Button.vue";
import InputText from "@/composables/forms/InputText.vue";
import SubmitButton from "@/composables/buttons/SubmitButton.vue";
import SelectOption from "@/composables/forms/SelectOption.vue";
import TextArea from "@/composables/forms/TextArea.vue";
import { AcademicCapIcon, CalendarIcon } from "@heroicons/vue/24/outline";
import {
    Switch,
    SwitchDescription,
    SwitchGroup,
    SwitchLabel,
} from "@headlessui/vue";

const form = useForm({
    type: "class",
    title: "",
    description: "",
    date: moment().format("YYYY-MM-DD"),
    time_start: moment().format("HH:00"),
    time_end: moment().add(1, "hour").format("HH:00"),
    day: moment().format("dddd").toLowerCase(),
    remind: false,
});

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

const type = computed({
    get: () => form.type,
    set: (value: string) => {
        form.type = value;
    },
});
</script>

<template>
    <Layout>
        <form
            @submit.prevent="
                form.post($route('schedule.store'), { preserveScroll: true })
            "
        >
            <div class="space-y-12">
                <div class="">
                    <div class="flex">
                        <div class="flex-1">
                            <h2
                                class="text-base font-semibold leading-7 text-gray-900"
                            >
                                Schedules
                            </h2>
                            <p class="mt-1 text-sm leading-6 text-gray-600">
                                This information will be added into your
                                schedule.
                            </p>
                        </div>

                        <div>
                            <Link :href="$route('schedule.index')">
                                <Button type="warning" label="Cancel" />
                            </Link>
                        </div>
                    </div>

                    <div class="mt-6">
                        <div class="sm:hidden">
                            <label for="tabs" class="sr-only"
                                >Select a tab</label
                            >
                            <select
                                id="tabs"
                                name="tabs"
                                class="block w-full rounded-md focus:border-indigo-500 focus:ring-indigo-500"
                                @change="type = $event.target.value"
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
                                <nav
                                    class="-mb-px flex space-x-8"
                                    aria-label="Tabs"
                                >
                                    <div
                                        v-for="tab in tabs"
                                        :key="tab.key"
                                        :class="[
                                            tab.key == type
                                                ? 'border-indigo-500 text-indigo-600'
                                                : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700',
                                            'group inline-flex cursor-pointer items-center border-b-2 px-1 py-4 text-sm font-medium',
                                        ]"
                                        @click="type = tab.key"
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
                </div>

                <div class="border-b border-gray-900/10 pb-12">
                    <div
                        class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6"
                    >
                        <div class="sm:col-span-4">
                            <InputText
                                id="title"
                                :model="form"
                                label="Title"
                                placeholder="Project Milestone"
                                :error="form.errors.title"
                            />
                        </div>

                        <div class="col-span-full">
                            <TextArea
                                id="description"
                                :model="form"
                                placeholder="Submit the project milestone to the supervisor."
                                :error="form.errors.description"
                            />
                        </div>

                        <div class="sm:col-span-3" v-if="type == 'class'">
                            <label
                                for="day"
                                class="block text-sm font-medium leading-6 text-gray-900"
                                >Day</label
                            >
                            <div class="mt-2">
                                <SelectOption
                                    id="day"
                                    :model="form"
                                    :error="form.errors.day"
                                    :options="[
                                        'monday',
                                        'tuesday',
                                        'wednesday',
                                        'thursday',
                                        'friday',
                                        'saturday',
                                        'sunday',
                                    ]"
                                    :selected="form.day"
                                />
                            </div>
                        </div>

                        <div
                            class="sm:col-span-2 sm:col-start-1"
                            v-if="type == 'activity'"
                        >
                            <InputText
                                id="date"
                                :model="form"
                                :error="form.errors.date"
                                label="Date"
                                type="date"
                            />
                        </div>

                        <div class="sm:col-span-2 sm:col-start-1">
                            <InputText
                                id="time_start"
                                :model="form"
                                :error="form.errors.time_start"
                                label="Time Start"
                                type="time"
                            />
                        </div>

                        <div class="sm:col-span-2">
                            <InputText
                                id="time_end"
                                :model="form"
                                :error="form.errors.time_end"
                                label="Time End"
                                type="time"
                            />
                        </div>

                        <div class="col-span-full mt-5">
                            <SwitchGroup
                                as="div"
                                class="flex items-center justify-between"
                            >
                                <span class="flex flex-grow flex-col">
                                    <SwitchLabel
                                        as="span"
                                        class="text-sm font-medium leading-6 text-gray-900"
                                        passive
                                        >Notification</SwitchLabel
                                    >
                                    <SwitchDescription
                                        as="span"
                                        class="text-sm text-gray-500"
                                        >Enable to receive the reminder for this
                                        schedule through
                                        Telegram.</SwitchDescription
                                    >
                                </span>
                                <Switch
                                    v-model="form.remind"
                                    :class="[
                                        form.remind
                                            ? 'bg-indigo-600'
                                            : 'bg-gray-200',
                                        'relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-indigo-600 focus:ring-offset-2',
                                    ]"
                                >
                                    <span
                                        aria-hidden="true"
                                        :class="[
                                            form.remind
                                                ? 'translate-x-5'
                                                : 'translate-x-0',
                                            'pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out',
                                        ]"
                                    />
                                </Switch>
                            </SwitchGroup>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-6 flex items-center justify-end gap-x-6">
                <div>
                    <SubmitButton />
                </div>
            </div>
        </form>
    </Layout>
</template>
