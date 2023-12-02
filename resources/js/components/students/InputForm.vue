<script setup lang="ts">
import _ from "lodash";
import { defineProps, toRefs } from "vue";
import { InertiaForm } from "@inertiajs/vue3";
import { Student } from "@/types/common";
import InputText from "@/composables/forms/InputText.vue";
import CustomSelectOption from "@/composables/forms/CustomSelectOption.vue";
import { AtSymbolIcon } from "@heroicons/vue/20/solid";
import InputAvatar from "@/components/profiles/InputAvatar.vue";
import SelectOption from "@/composables/forms/SelectOption.vue";
import TextArea from "@/composables/forms/TextArea.vue";
import { AcademicCapIcon, PhoneIcon } from "@heroicons/vue/24/outline";

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
            placeholder="e.g., amlxv"
            :error="form?.errors?.name"
        />
    </div>

    <div class="sm:col-span-4">
        <InputText
            id="email"
            :model="form"
            label="Email address"
            placeholder="e.g., me@amlxv.com"
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
            placeholder="e.g., 2022988117"
            :error="form?.errors?.student_id"
            :icon="AtSymbolIcon"
        />
    </div>

    <div class="sm:col-span-4">
        <CustomSelectOption
            :model="form"
            :items="$page.props?.campuses"
            id="campus"
            label="Campus"
            :display-text="
                form?.campus?.name ??
                _.find(<Array<unknown & { id: number }>>$page.props?.campuses, {
                    id: parseInt(form.campus),
                })?.name ??
                'Select the campus name'
            "
        />
    </div>

    <div class="sm:col-span-4">
        <CustomSelectOption
            :model="form"
            :items="$page.props?.faculties"
            id="faculty"
            :label="
                'Faculty ' +
                (form.campus?.code === 'B' ? ' - (Required)' : ' - (Optional)')
            "
            :display-text="
                form?.faculty?.name ??
                _.find(
                    <Array<unknown & { id: number }>>$page.props?.faculties,
                    {
                        id: parseInt(form.faculty),
                    },
                )?.name ??
                'Select the faculty name'
            "
        />
    </div>

    <div class="sm:col-span-4">
        <InputText
            id="program"
            :model="form"
            label="Program"
            placeholder="e.g., CS251"
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
            placeholder="e.g., +60168000782"
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
            placeholder="e.g., Jasin, Melaka"
            :error="form?.errors?.address"
            description="Optionally provide the student address."
        />
    </div>
</template>
