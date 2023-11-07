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

const props = defineProps<{
    form: InertiaForm<Course & { student_id?: string }>;
}>();

const { form } = toRefs(props);
</script>

<template>
    <div v-if="$page.props.auth.user.role === 'admin'" class="sm:col-span-4">
        <InputText
            id="student_id"
            :model="form"
            label="Student ID"
            placeholder="2022988117"
            :error="form?.errors?.student_id"
            :icon="UserIcon"
        />
    </div>
    <div class="sm:col-span-4">
        <InputText
            id="name"
            :model="form"
            label="Course Name"
            placeholder="Project Formulation"
            :error="form?.errors?.name"
            :icon="ClipboardDocumentIcon"
        />
    </div>

    <div class="sm:col-span-4">
        <InputText
            id="code"
            :model="form"
            label="Course Code"
            placeholder="CSP600"
            :error="form?.errors?.code"
            :icon="AtSymbolIcon"
        />
    </div>

    <div class="sm:col-span-4">
        <InputText
            id="group"
            :model="form"
            label="Group"
            placeholder="M3CS2516A"
            :error="form?.errors?.group"
            :icon="UserGroupIcon"
        />
    </div>
</template>
