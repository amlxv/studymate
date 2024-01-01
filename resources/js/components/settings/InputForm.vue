<script setup lang="ts">
import { defineProps, toRefs } from "vue";
import { InertiaForm } from "@inertiajs/vue3";
import InputText from "@/composables/forms/InputText.vue";
import { AtSymbolIcon, ClockIcon } from "@heroicons/vue/20/solid";
import TextArea from "@/composables/forms/TextArea.vue";

const props = defineProps<{
    form: InertiaForm<{
        id: number;
        username?: string;
        time_before?: number;
        custom_message?: string;
        email?: string;
    }>;
}>();

const { form } = toRefs(props);
</script>

<template>
    <div class="sm:col-span-4">
        <InputText
            id="email"
            :model="form"
            :error="form?.errors?.email"
            label="Email"
            type="text"
            placeholder="e.g., student@amlxv.com"
            :icon="AtSymbolIcon"
        />
    </div>

    <div class="sm:col-span-4">
        <InputText
            id="username"
            :model="form"
            :error="form?.errors?.username"
            label="Telegram Username"
            type="text"
            placeholder="e.g., amlxv"
            :icon="AtSymbolIcon"
            disabled="disabled"
            class-list="bg-gray-200"
        />

        <p class="mt-2 text-xs text-gray-600 transition-all duration-300">
            Only the account owner can modify this information.
        </p>
    </div>
    <div class="sm:col-span-4">
        <InputText
            id="time_before"
            :model="form"
            :error="form?.errors?.time_before"
            label="Time Before"
            type="number"
            placeholder="e.g., 10"
            min="1"
            max="60"
            :icon="ClockIcon"
        />

        <p class="mt-2 text-xs text-gray-600 transition-all duration-300">
            Leave it blank to reset.
        </p>
    </div>

    <div class="sm:col-span-4">
        <TextArea
            id="custom_message"
            :model="form"
            label="Custom Message"
            description="Customize how the notification will looks like."
            placeholder="e.g., Hi, there! {title} will start soon."
        />
    </div>
</template>
