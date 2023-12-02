<script setup lang="ts">
import { defineProps, toRefs } from "vue";
import { InertiaForm } from "@inertiajs/vue3";
import { Course } from "@/types/common";
import InputText from "@/composables/forms/InputText.vue";
import {
    AtSymbolIcon,
    ClipboardDocumentIcon,
    UserGroupIcon,
    UserIcon,
} from "@heroicons/vue/20/solid";
import {
    Switch,
    SwitchDescription,
    SwitchGroup,
    SwitchLabel,
} from "@headlessui/vue";

const props = defineProps<{
    form: InertiaForm<Course & { remind: boolean; student_id?: string }>;
}>();

const { form } = toRefs(props);
</script>

<template>
    <div v-if="$page.props.auth.user.role === 'admin'" class="sm:col-span-4">
        <InputText
            id="student_id"
            :model="form"
            label="Student ID"
            placeholder="e.g., 2022988117"
            :error="form?.errors?.student_id"
            :icon="UserIcon"
        />
    </div>
    <div class="sm:col-span-4">
        <InputText
            id="name"
            :model="form"
            label="Course Name"
            placeholder="e.g., Project"
            :error="form?.errors?.name"
            :icon="ClipboardDocumentIcon"
        />
    </div>

    <div class="sm:col-span-4">
        <InputText
            id="code"
            :model="form"
            label="Course Code"
            placeholder="e.g., CSP650"
            :error="form?.errors?.code"
            :icon="AtSymbolIcon"
        />
    </div>

    <div class="sm:col-span-4">
        <InputText
            id="group"
            :model="form"
            label="Group"
            placeholder="e.g., M3CS2516A"
            :error="form?.errors?.group"
            :icon="UserGroupIcon"
        />
    </div>

    <div class="sm:col-span-4">
        <SwitchGroup as="div" class="flex items-center justify-between gap-8">
            <span class="flex flex-grow flex-col">
                <SwitchLabel
                    as="span"
                    class="text-sm font-medium leading-6 text-gray-900"
                    passive
                    >Enable Reminder</SwitchLabel
                >
                <SwitchDescription as="span" class="mt-1 text-sm text-gray-500"
                    >Please connect your Telegram account in the account
                    settings before enabling this option.</SwitchDescription
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
                        form?.remind ? 'translate-x-5' : 'translate-x-0',
                        'pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out',
                    ]"
                />
            </Switch>
        </SwitchGroup>
    </div>
</template>
