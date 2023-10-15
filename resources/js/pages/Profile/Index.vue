<script setup lang="ts">
import { ref } from "vue";
import { useForm, usePage } from "@inertiajs/vue3";
import Layout from "@/layouts/Layout.vue";
import SubmitButton from "@/composables/buttons/SubmitButton.vue";
import SectionHeading from "@/composables/heading/SectionHeading.vue";
import CommonButton from "@/composables/buttons/CommonButton.vue";
import InputText from "@/composables/forms/InputText.vue";
import SelectOption from "@/composables/forms/SelectOption.vue";
import InputAvatar from "@/components/profiles/InputAvatar.vue";
import {
    BookmarkSquareIcon,
    BookOpenIcon,
    DevicePhoneMobileIcon,
    HomeModernIcon,
    IdentificationIcon,
} from "@heroicons/vue/20/solid";
import { AcademicCapIcon, HomeIcon } from "@heroicons/vue/24/outline";

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
</script>

<template>
    <Layout>
        <form
            @submit.prevent="
                form.post(route('profile.update', $page.props.user.id), {
                    preserveScroll: true,
                    onFinish: () => {
                        isEditingMode = false;
                    },
                })
            "
        >
            <div class="space-y-12">
                <SectionHeading
                    title="Profile"
                    description="This information may will be displayed publicly so
                                be careful what you share."
                >
                    <CommonButton
                        type="warning"
                        :label="
                            isEditingMode ? 'Disable Editing' : 'Edit Profile'
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
                            class="mt-1 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6"
                        >
                            <div class="col-span-full">
                                <InputAvatar
                                    :form="form"
                                    id="avatar"
                                    :error="form?.errors?.avatar"
                                    :disabled="!isEditingMode"
                                />
                            </div>

                            <div class="sm:col-span-4">
                                <InputText
                                    id="name"
                                    :model="form"
                                    :error="form?.errors?.name"
                                    label="Name"
                                    type="text"
                                    placeholder="amlxv"
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
                                    placeholder="studymate@amlxv.com"
                                    disabled="disabled"
                                />

                                <p
                                    class="mt-2 text-xs text-gray-600"
                                    v-if="isEditingMode"
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
                                    placeholder="+60168000782"
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
                                    placeholder="Kota Bharu, Kelantan"
                                    :disabled="!isEditingMode"
                                />
                            </div>
                        </div>
                    </div>

                    <div
                        id="student"
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
                            The information collected may be used to improve our
                            system.
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
                                    placeholder="2022988117"
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
                                    placeholder="Universiti Teknologi MARA"
                                    :icon="AcademicCapIcon"
                                    :disabled="!isEditingMode"
                                />
                            </div>

                            <div class="sm:col-span-4">
                                <InputText
                                    id="campus"
                                    :model="form"
                                    :error="form?.errors?.campus"
                                    label="Campus"
                                    type="text"
                                    placeholder="Jasin, Melaka"
                                    :icon="HomeModernIcon"
                                    :disabled="!isEditingMode"
                                />
                            </div>

                            <div class="sm:col-span-4">
                                <InputText
                                    id="faculty"
                                    :model="form"
                                    :error="form?.errors?.faculty"
                                    label="Faculty"
                                    type="text"
                                    placeholder="College of Computers, Information's & Mathematics"
                                    :icon="BookmarkSquareIcon"
                                    :disabled="!isEditingMode"
                                />
                            </div>

                            <div class="sm:col-span-4">
                                <InputText
                                    id="program"
                                    :model="form"
                                    :error="form?.errors?.program"
                                    label="Program"
                                    type="text"
                                    placeholder="CS251"
                                    :icon="BookOpenIcon"
                                    :disabled="!isEditingMode"
                                />
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div
                class="mt-6 flex items-center justify-end gap-x-6"
                v-if="isEditingMode"
            >
                <div>
                    <SubmitButton />
                </div>
            </div>
        </form>
    </Layout>
</template>
