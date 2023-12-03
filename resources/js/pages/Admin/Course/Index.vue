<script setup lang="ts">
import { ref, watch } from "vue";
import { router, useForm } from "@inertiajs/vue3";
import { Course } from "@/types/common";
import Layout from "@/layouts/Layout.vue";
import SectionHeading from "@/composables/heading/SectionHeading.vue";
import InputForm from "@/components/courses/InputForm.vue";
import SlideOverForm from "@/composables/slide-overs/SlideOverForm.vue";
import IndexTable from "@/components/courses/IndexTable.vue";
import DeleteConfirmation from "@/composables/modals/DeleteConfirmation.vue";
import { getRoute } from "@/composables/etc/utils";

const selectedItem = ref(null);
const slideOverFormOpen = ref(false);
const slideOverFormMode = ref(null);
const isDeleteConfirmationModalOpen = ref(false);

const form = useForm({
    id: null,
    name: null,
    code: null,
    group: null,
    student_id: null,
    remind: false,
});

watch(selectedItem, () => {
    form.clearErrors();
    form.id = selectedItem.value?.id;
    form.name = selectedItem.value?.name;
    form.code = selectedItem.value?.code;
    form.group = selectedItem.value?.group;
    form.student_id = selectedItem.value?.student?.student_id;
});

const handleFormSubmit = () => {
    const options = {
        onSuccess: () => {
            slideOverFormOpen.value = false;
        },
    };

    if (slideOverFormMode.value === "edit") {
        form.put(
            getRoute("admin.course.update").replace(
                /{.+}/,
                selectedItem.value?.id,
            ),
            options,
        );
    } else {
        form.post(getRoute("admin.course.store"), options);
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
                handleDelete(route('admin.course.destroy', selectedItem.id))
            "
        />

        <SlideOverForm
            :on-submit="handleFormSubmit"
            :title="
                slideOverFormMode === 'create' ? 'New Course' : 'Edit Course'
            "
            :description="
                slideOverFormMode === 'create'
                    ? 'Get started by filling in the information below to create your new course.'
                    : 'Fill in the form with new information to update the course as you wish.'
            "
            :open="slideOverFormOpen"
            @close="slideOverFormOpen = false"
        >
            <InputForm :form="form" />
        </SlideOverForm>

        <SectionHeading
            title="Courses"
            description="Manage the courses in this section."
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

            <template v-slot:disclosureTitle
                >Click to learn more about the courses section here.
            </template>

            <template v-slot:disclosureContent>
                <div class="mb-3.5">
                    <div>StudyMate will use information such:</div>

                    <ul class="ml-8 mt-2 list-disc">
                        <li>Student ID</li>
                        <li>Campus</li>
                        <li>Faculty</li>
                        <li>Program</li>
                        <li>Course Information</li>
                        <li>Group</li>
                        <li>Telegram (if reminder enabled)</li>
                    </ul>
                </div>

                <div>To retrieve the timetable from UiTM's websites:</div>

                <ul class="ml-8 mt-2 list-disc">
                    <li>
                        <a
                            class="text-blue-600"
                            href="https://simsweb4.uitm.edu.my/estudent/class_timetable/index.htm"
                            >iCress</a
                        >
                    </li>
                    <li>
                        <a
                            class="text-blue-600"
                            href="https://mystudent.uitm.edu.my/timetable"
                            >MyStudent</a
                        >
                    </li>
                </ul>
            </template>
        </SectionHeading>

        <div
            class="px-4 transition-all duration-700 sm:px-6 lg:px-8"
            :class="{ ' -translate-x-1/4': slideOverFormOpen }"
        >
            <div class="mt-8 flow-root">
                <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="inline-block min-w-full py-2 align-middle">
                        <IndexTable
                            :courses="$page.props.courses as Course[]"
                            :on-edit="(course) => handleEdit(course)"
                            :on-delete="
                                (course) => {
                                    selectedItem = course;
                                    isDeleteConfirmationModalOpen = true;
                                }
                            "
                        />
                    </div>
                </div>
            </div>
        </div>
    </Layout>
</template>
