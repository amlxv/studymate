<script setup lang="ts">
import { ref, watch } from "vue";
import { router, useForm } from "@inertiajs/vue3";
import { Course } from "@/types/common";
import Layout from "@/layouts/Layout.vue";
import SectionHeading from "@/composables/heading/SectionHeading.vue";
import InputForm from "@/components/settings/InputForm.vue";
import SlideOverForm from "@/composables/slide-overs/SlideOverForm.vue";
import IndexTable from "@/components/settings/IndexTable.vue";
import DeleteConfirmation from "@/composables/modals/DeleteConfirmation.vue";
import { getRoute } from "@/composables/etc/utils";
import EmptyState from "@/composables/notifications/EmptyState.vue";
import { PlusIcon } from "@heroicons/vue/20/solid";

const selectedItem = ref(null);
const slideOverFormOpen = ref(false);
const slideOverFormMode = ref(null);
const isDeleteConfirmationModalOpen = ref(false);

const form = useForm({
    id: null,
    email: null,
    username: null,
    time_before: null,
    custom_message: null,
});

watch(selectedItem, () => {
    form.clearErrors();
    form.email = selectedItem.value?.email;
    form.username = selectedItem.value?.username;
    form.time_before = selectedItem.value?.time_before;
    form.custom_message = selectedItem.value?.custom_message;
});

const handleFormSubmit = () => {
    const options = {
        onSuccess: () => {
            slideOverFormOpen.value = false;
        },
    };

    if (slideOverFormMode.value === "edit") {
        form.put(
            getRoute("admin.setting.update").replace(
                /{.+}/,
                selectedItem.value?.id,
            ),
            options,
        );
    } else {
        form.post(getRoute("admin.setting.store"), options);
    }
};

const handleEdit = (course: Course) => {
    selectedItem.value = course;
    slideOverFormMode.value = "edit";
    slideOverFormOpen.value = true;
};

const handleDelete = (path: string) => {
    router.delete(path);
    isDeleteConfirmationModalOpen.value = false;
};
</script>

<template>
    <Layout>
        <DeleteConfirmation
            :open="isDeleteConfirmationModalOpen"
            @close="isDeleteConfirmationModalOpen = false"
            @delete="
                handleDelete(route('admin.setting.destroy', selectedItem.id))
            "
        />

        <SlideOverForm
            :on-submit="handleFormSubmit"
            :title="
                slideOverFormMode === 'create' ? 'New Setting' : 'Edit Setting'
            "
            :description="
                slideOverFormMode === 'create'
                    ? 'Get started by filling in the information below to create new setting for the user.'
                    : 'Fill in the form with new information to update the setting for the user.'
            "
            :open="slideOverFormOpen"
            @close="slideOverFormOpen = false"
        >
            <InputForm :form="form" />
        </SlideOverForm>

        <SectionHeading
            title="Setting"
            description="The section where you can the student setting."
        >
            <button
                @click="
                    selectedItem = null;
                    slideOverFormOpen = true;
                    slideOverFormMode = 'create';
                "
                type="button"
                class="inline-flex items-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
            >
                Create
            </button>

            <template v-slot:disclosureTitle>
                Tips: Read how to modify the custom message.
            </template>

            <template v-slot:disclosureContent>
                <div class="w-1/2">
                    There are several keywords with a unique pattern that have
                    been reserved for mentioning schedule information. When you
                    use those keywords, they will be replaced with the actual
                    schedule details before the reminder is sent to you.

                    <ul class="ml-4 mt-4 list-disc">
                        <li class="mb-2.5">
                            <span class="rounded bg-gray-200 p-1 text-gray-700"
                                >{title}</span
                            >
                            — The schedule title that has been set.
                        </li>
                        <li class="mb-2.5">
                            <span class="rounded bg-gray-200 p-1 text-gray-700"
                                >{description}</span
                            >
                            — The schedule description that has been set.
                        </li>
                        <li class="mb-2.5">
                            <span class="rounded bg-gray-200 p-1 text-gray-700"
                                >{day}</span
                            >
                            — If exist, the schedule day that has been set.
                        </li>
                        <li class="mb-2.5">
                            <span class="rounded bg-gray-200 p-1 text-gray-700"
                                >{date}</span
                            >
                            — If exist, the schedule date that has been set.
                        </li>
                        <li class="mb-2.5">
                            <span class="rounded bg-gray-200 p-1 text-gray-700"
                                >{time_start}</span
                            >
                            — The schedule start time that has been set.
                        </li>
                        <li class="mb-2.5">
                            <span class="rounded bg-gray-200 p-1 text-gray-700"
                                >{time_end}</span
                            >
                            — The schedule end time that has been set.
                        </li>
                    </ul>
                </div>
            </template>
        </SectionHeading>

        <div
            class="px-4 transition-all duration-700 sm:px-6 lg:px-8"
            :class="{ ' -translate-x-1/4': slideOverFormOpen }"
        >
            <div class="mt-8 flow-root">
                <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div
                        class="inline-block min-w-full py-2 align-middle"
                        v-if="$page.props.settings.length != 0"
                    >
                        <IndexTable
                            :settings="$page.props.settings"
                            :on-edit="(setting) => handleEdit(setting)"
                            :on-delete="
                                (setting) => {
                                    selectedItem = setting;
                                    isDeleteConfirmationModalOpen = true;
                                }
                            "
                        />
                    </div>
                    <div
                        v-else
                        class="flex h-[50vh] items-center justify-center"
                    >
                        <EmptyState>
                            <template v-slot:description>
                                No students have updated their setting yet.
                                <br />
                                Let's help them manage the preference now!
                            </template>

                            <template v-slot:fallback>
                                <button
                                    @click="
                                        selectedItem = null;
                                        slideOverFormOpen = true;
                                        slideOverFormMode = 'create';
                                    "
                                    type="button"
                                    class="inline-flex items-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                                >
                                    <PlusIcon
                                        class="-ml-0.5 mr-1.5 h-5 w-5"
                                        aria-hidden="true"
                                    />
                                    New Course
                                </button>
                            </template>
                        </EmptyState>
                    </div>
                </div>
            </div>
        </div>
    </Layout>
</template>
