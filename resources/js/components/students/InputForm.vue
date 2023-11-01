<script setup lang="ts">
import { defineProps, toRefs } from "vue";
import { InertiaForm } from "@inertiajs/vue3";
import { Student } from "@/types/common";
import InputText from "@/composables/forms/InputText.vue";
import { AtSymbolIcon, HomeModernIcon } from "@heroicons/vue/20/solid";
import InputAvatar from "@/components/profiles/InputAvatar.vue";
import SelectOption from "@/composables/forms/SelectOption.vue";
import TextArea from "@/composables/forms/TextArea.vue";
import {
    AcademicCapIcon,
    HomeIcon,
    PhoneIcon,
} from "@heroicons/vue/24/outline";

const props = defineProps<{
    form: InertiaForm<Student>;
}>();

const { form } = toRefs(props);
</script>

<template>
    <div class="col-span-full">
        <InputAvatar :form="form" id="avatar" />
    </div>

    <div class="sm:col-span-4">
        <InputText
            id="name"
            :model="form"
            label="Name"
            placeholder="amlxv"
            :error="form?.errors?.name"
        />
    </div>

    <div class="sm:col-span-4">
        <InputText
            id="email"
            :model="form"
            label="Email address"
            placeholder="me@amlxv.com"
            :error="form?.errors?.email"
        />
    </div>

    <div class="sm:col-span-4">
        <InputText
            id="password"
            :model="form"
            label="Password"
            placeholder="********"
            :error="form?.errors?.password"
        />
    </div>

    <div class="h-2 border-b"></div>

    <div class="sm:col-span-4">
        <InputText
            id="student_id"
            :model="form"
            label="Student ID"
            placeholder="2022988117"
            :error="form?.errors?.student_id"
            :icon="AtSymbolIcon"
        />
    </div>

    <div class="sm:col-span-4">
        <InputText
            id="faculty"
            :model="form"
            label="Faculty"
            placeholder="College of Computers, Information & Mathematics"
            :error="form?.errors?.faculty"
            :icon="HomeModernIcon"
        />
    </div>

    <div class="sm:col-span-4">
        <InputText
            id="campus"
            :model="form"
            label="Campus"
            placeholder="Jasin, Melaka"
            :error="form?.errors?.campus"
            :icon="HomeIcon"
        />
    </div>

    <div class="sm:col-span-4">
        <InputText
            id="program"
            :model="form"
            label="Program"
            placeholder="CS251"
            :error="form?.errors?.program"
            :icon="AcademicCapIcon"
        />
    </div>

    <div class="h-2 border-b"></div>

    <div class="sm:col-span-4">
        <InputText
            id="phone_number"
            :model="form"
            label="Phone Number"
            placeholder="60168000782"
            :error="form?.errors?.phone_number"
            :icon="PhoneIcon"
        />
    </div>

    <div class="col-span-full">
        <label
            for="gender"
            class="mb-2 block text-sm font-medium leading-6 text-gray-900"
            >Gender</label
        >

        <SelectOption
            :options="['male', 'female']"
            :model="form"
            id="gender"
            label="Gender"
        />
    </div>

    <div class="sm:col-span-4">
        <TextArea
            id="address"
            :model="form"
            label="Address"
            placeholder="Jasin, Melaka"
            :error="form?.errors?.address"
            description="Optionally provide the student address."
        />
    </div>
</template>
