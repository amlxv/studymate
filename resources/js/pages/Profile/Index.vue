<script setup lang="ts">
import _ from "lodash";
import { onMounted, ref } from "vue";
import queryString from "query-string";
import { useForm, usePage } from "@inertiajs/vue3";
import Layout from "@/layouts/Layout.vue";
import SubmitButton from "@/composables/buttons/SubmitButton.vue";
import SectionHeading from "@/composables/heading/SectionHeading.vue";
import CommonButton from "@/composables/buttons/CommonButton.vue";
import InputText from "@/composables/forms/InputText.vue";
import SelectOption from "@/composables/forms/SelectOption.vue";
import InputAvatar from "@/components/profiles/InputAvatar.vue";
import CustomSelectOption from "@/composables/forms/CustomSelectOption.vue";
import { AcademicCapIcon, HomeIcon } from "@heroicons/vue/24/outline";
import {
    BookOpenIcon,
    DevicePhoneMobileIcon,
    IdentificationIcon,
} from "@heroicons/vue/20/solid";

const isEditingMode = ref(false);

const page = usePage();
const props = page?.props;

const form = useForm({
    _method: "put",
    avatar: props?.user?.avatar,
    name: props?.user?.name,
    email: props?.user?.email,
    phone_number: props?.user?.phone_number,
    student_id: props?.student?.student_id,
    gender: props?.student?.gender,
    address: props?.student?.address,
    institute: props?.student?.institute,
    campus: props?.student?.campus,
    faculty: props?.student?.faculty,
    program: props?.student?.program,
});

const { pathname, search } = new URL(window.location.toString());
const params = queryString.parse(search);

const student = ref(null);

onMounted(() => {
    if ("error" in params && params.error === "missing-student-information") {
        isEditingMode.value = true;

        _.delay(
            () => student.value.scrollIntoView({ behavior: "smooth" }),
            500,
        );

        _.delay(
            () =>
                student.value.classList.add(
                    "animate__animated",
                    "animate__shakeY",
                ),
            800,
        );
    }
});
</script>

<template>
    <Layout>
        <form
            @submit.prevent="
                form.post(route('profile.update', $page.props.user.id), {
                    preserveScroll: true,
                    onSuccess: () => {
                        isEditingMode = false;
                    },
                })
            "
        >
            <div class="space-y-12">
                <SectionHeading
                    title="Profile"
                    description="This information will be displayed publicly so be careful what you share."
                >
                    <CommonButton
                        type="warning"
                        :label="
                            isEditingMode ? 'Disable Editing' : 'Enable Edit'
                        "
                        @click="isEditingMode = !isEditingMode"
                        :class="
                            isEditingMode
                                ? 'bg-red-600 text-white hover:bg-red-700 hover:text-white'
                                : null
                        "
                    />
                </SectionHeading>

                <div class="space-y-12">
                    <div class="border-b border-gray-900/10 pb-12">
                        <div
                            class="mt-1 flex grid grid-cols-1 justify-center gap-x-6 gap-y-8 sm:grid-cols-6"
                        >
                            <div class="col-span-full">
                                <InputAvatar
                                    :form="form"
                                    id="avatar"
                                    :error="form?.errors?.avatar"
                                    :disabled="!isEditingMode"
                                    icon-class="h-32 w-32"
                                />
                            </div>

                            <div class="sm:col-span-4">
                                <InputText
                                    id="name"
                                    :model="form"
                                    :error="form?.errors?.name"
                                    label="Name"
                                    type="text"
                                    placeholder="e.g: amlxv"
                                    :disabled="!isEditingMode"
                                />
                            </div>

                            <div class="sm:col-span-4">
                                <InputText
                                    id="email"
                                    :model="form"
                                    :error="form?.errors?.email"
                                    label="Email Address"
                                    type="email"
                                    placeholder="e.g: studymate@amlxv.com"
                                    disabled="disabled"
                                />

                                <p
                                    class="mt-2 text-xs text-gray-600 transition-all duration-300"
                                    :class="{
                                        '-mb-6 opacity-0': !isEditingMode,
                                        'opacity-100': isEditingMode,
                                    }"
                                >
                                    The email address cannot be change.
                                </p>
                            </div>

                            <div class="sm:col-span-3">
                                <InputText
                                    id="phone_number"
                                    :model="form"
                                    :error="form?.errors?.phone_number"
                                    label="Phone Number"
                                    type="text"
                                    :icon="DevicePhoneMobileIcon"
                                    placeholder="e.g: +60168000782"
                                    :disabled="!isEditingMode"
                                />
                            </div>

                            <div v-if="$page.props.user.role == 'student'">
                                <label
                                    for="gender"
                                    class="block text-sm font-medium leading-6 text-gray-900"
                                    >Gender</label
                                >

                                <div class="mt-2">
                                    <SelectOption
                                        id="gender"
                                        :model="form"
                                        :error="form?.errors?.gender"
                                        :options="['male', 'female']"
                                        :selected="form?.gender"
                                        :disabled="!isEditingMode"
                                    />
                                </div>
                            </div>

                            <div
                                class="sm:col-span-4 sm:col-start-1"
                                v-if="$page.props.user.role == 'student'"
                            >
                                <InputText
                                    id="address"
                                    :model="form"
                                    :error="form?.errors?.address"
                                    label="Address"
                                    type="text"
                                    :icon="HomeIcon"
                                    placeholder="e.g: Kota Bharu, Kelantan"
                                    :disabled="!isEditingMode"
                                />
                            </div>
                        </div>
                    </div>

                    <div
                        ref="student"
                        class="pb-12"
                        :class="
                            isEditingMode ? 'border-b border-gray-900/10' : null
                        "
                        v-if="$page.props.user.role == 'student'"
                    >
                        <h2
                            class="text-base font-semibold leading-7 text-gray-900"
                        >
                            Student Information
                        </h2>
                        <p class="mt-1 text-sm leading-6 text-gray-600">
                            These information are required to enjoy the UiTM
                            Timetable's features.
                        </p>

                        <div
                            class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6"
                        >
                            <div class="sm:col-span-4">
                                <InputText
                                    id="student_id"
                                    :model="form"
                                    :error="form?.errors?.student_id"
                                    label="Student ID"
                                    type="text"
                                    placeholder="e.g: 2022988117"
                                    :icon="IdentificationIcon"
                                    :disabled="!isEditingMode"
                                />
                            </div>

                            <div class="hidden sm:col-span-4">
                                <InputText
                                    id="institute"
                                    :model="form"
                                    :error="form?.errors?.institute"
                                    label="Institute"
                                    type="text"
                                    placeholder="e.g: Universiti Teknologi MARA"
                                    :icon="AcademicCapIcon"
                                    :disabled="!isEditingMode"
                                />
                            </div>

                            <div class="sm:col-span-4">
                                <CustomSelectOption
                                    :model="form"
                                    :items="props?.campuses"
                                    :disabled="!isEditingMode"
                                    id="campus"
                                    label="Campus"
                                    :display-text="
                                        form?.campus?.name ??
                                        _.find(
                                            <Array<unknown & { id: number }>>(
                                                props?.campuses
                                            ),
                                            {
                                                id: parseInt(form.campus),
                                            },
                                        )?.name ??
                                        'Select the campus name'
                                    "
                                />
                            </div>

                            <div class="sm:col-span-4">
                                <CustomSelectOption
                                    :model="form"
                                    :items="props?.faculties"
                                    :disabled="!isEditingMode"
                                    id="faculty"
                                    :label="
                                        'Faculty ' +
                                        (form.campus?.code === 'B'
                                            ? ' - (Required)'
                                            : ' - (Optional)')
                                    "
                                    :display-text="
                                        form?.faculty?.name ??
                                        _.find(
                                            <Array<unknown & { id: number }>>(
                                                props?.faculties
                                            ),
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
                                    :error="form?.errors?.program"
                                    label="Program"
                                    type="text"
                                    placeholder="e.g: CS251"
                                    :icon="BookOpenIcon"
                                    :disabled="!isEditingMode"
                                />
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div
                class="mt-6 flex items-center justify-end gap-x-6 transition-all duration-300"
                :class="{
                    'pointer-events-none -mb-6 opacity-0': !isEditingMode,
                    'opacity-100': isEditingMode,
                }"
            >
                <div>
                    <SubmitButton label="Save" />
                </div>
            </div>
        </form>
    </Layout>
</template>
