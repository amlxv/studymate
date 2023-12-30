<script setup lang="ts">
import { toRefs } from "vue";
import {
    Switch,
    SwitchDescription,
    SwitchGroup,
    SwitchLabel,
} from "@headlessui/vue";
import { InertiaForm } from "@inertiajs/vue3";
import InputText from "@/composables/forms/InputText.vue";
import SelectOption from "@/composables/forms/SelectOption.vue";
import TextArea from "@/composables/forms/TextArea.vue";

type Details = {
    email?: string;
    title: string;
    description: string;
    day: string;
    date: string;
    time_start: string;
    time_end?: string;
    remind: boolean;
    type?: unknown;
};

const props = defineProps<{
    form: InertiaForm<Details>;
    type: string;
}>();

const { form, type } = toRefs(props);
</script>

<template>
    <div class="border-b border-gray-900/10 pb-12">
        <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
            <div class="text-sm text-gray-700 sm:col-span-4">
                <div class="-mt-4 rounded-lg bg-indigo-50 px-5 py-6 shadow">
                    <div v-if="type == 'class'">
                        <div>What is the "Class Timetable"?</div>
                        <ul class="ml-8 mt-2 list-disc">
                            <li>
                                The schedule that repeats on a weekly basis.
                            </li>
                            <li>
                                The schedule that does not contain a specific
                                date.
                            </li>
                            <li>
                                You can only choose the day for when the event
                                will occur.
                            </li>
                        </ul>
                    </div>
                    <div v-if="type == 'activity'">
                        <div>What is the "Activities"?</div>

                        <ul class="ml-8 mt-2 list-disc">
                            <li>
                                The schedule that happens on a single,
                                non-recurring occasion.
                            </li>
                            <li>
                                The schedule that does contain a specific date.
                            </li>
                            <li>
                                You can only choose the date for when the event
                                will occur.
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div
                class="sm:col-span-4"
                v-if="$page.url.startsWith('/admin/schedule/create')"
            >
                <InputText
                    id="email"
                    :model="form"
                    label="Email"
                    placeholder="e.g., student@amlxv.com"
                    :error="form?.errors?.email"
                />
            </div>

            <div class="sm:col-span-4">
                <InputText
                    id="title"
                    :model="form"
                    label="Title"
                    placeholder="e.g., Project Milestone"
                    :error="form?.errors?.title"
                />
            </div>

            <div class="col-span-full">
                <TextArea
                    id="description"
                    :model="form"
                    placeholder="e.g., Submit the project milestone to the supervisor."
                    :error="form?.errors?.description"
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
                        :error="form?.errors?.day"
                        :options="[
                            'monday',
                            'tuesday',
                            'wednesday',
                            'thursday',
                            'friday',
                            'saturday',
                            'sunday',
                        ]"
                        :selected="form?.day"
                    />
                </div>
            </div>

            <div class="sm:col-span-2 sm:col-start-1" v-if="type == 'activity'">
                <InputText
                    id="date"
                    :model="form"
                    :error="form?.errors?.date"
                    label="Date"
                    type="date"
                />
            </div>

            <div class="sm:col-span-2 sm:col-start-1">
                <InputText
                    id="time_start"
                    :model="form"
                    :error="form?.errors?.time_start"
                    label="Time Start"
                    type="time"
                />
            </div>

            <div class="sm:col-span-2">
                <InputText
                    id="time_end"
                    :model="form"
                    :error="form?.errors?.time_end"
                    label="Time End (Optional)"
                    type="time"
                />
            </div>

            <div class="col-span-full mt-5">
                <SwitchGroup as="div" class="flex items-center justify-between">
                    <span class="mr-6 flex flex-grow flex-col md:mr-auto">
                        <SwitchLabel
                            as="span"
                            class="text-sm font-medium leading-6 text-gray-900"
                            passive
                            >Notification</SwitchLabel
                        >
                        <SwitchDescription
                            as="span"
                            class="text-sm text-gray-500"
                            >Enable to receive the reminder for this schedule
                            through Telegram.</SwitchDescription
                        >
                    </span>
                    <Switch
                        v-model="form.remind"
                        :class="[
                            form?.remind ? 'bg-indigo-600' : 'bg-gray-200',
                            'relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-indigo-600 focus:ring-offset-2',
                        ]"
                    >
                        <span
                            aria-hidden="true"
                            :class="[
                                form?.remind
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
</template>
