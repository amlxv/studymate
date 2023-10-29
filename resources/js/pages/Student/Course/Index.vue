<script setup lang="ts">
import { ref, watch } from "vue";
import { router, useForm } from "@inertiajs/vue3";
import { Ziggy } from "@/ziggy";
import { Course } from "@/types/common";
import Layout from "@/layouts/Layout.vue";
import SectionHeading from "@/composables/heading/SectionHeading.vue";
import InputForm from "@/components/courses/InputForm.vue";
import SlideOverForm from "@/composables/slide-overs/SlideOverForm.vue";
import IndexTable from "@/components/courses/IndexTable.vue";
import DeleteConfirmation from "@/composables/modals/DeleteConfirmation.vue";

const selectedItem = ref(null);
const slideOverFormOpen = ref(false);
const slideOverFormMode = ref(null);
const isDeleteConfirmationModalOpen = ref(false);

const form = useForm({
    id: null,
    name: null,
    code: null,
    group: null,
});

watch(selectedItem, () => {
    form.clearErrors();
    form.name = selectedItem.value?.name;
    form.code = selectedItem.value?.code;
    form.group = selectedItem.value?.group;
});

const handleFormSubmit = () => {
    const options = {
        onSuccess: () => {
            slideOverFormOpen.value = false;
        },
    };

    if (slideOverFormMode.value === "edit") {
        form.put(
            Ziggy.routes["course.update"].uri.replace(
                /{.+}/,
                selectedItem.value?.id,
            ),
            options,
        );
    } else {
        form.post(Ziggy.routes["course.store"].uri, options);
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
            @delete="handleDelete(route('course.destroy', selectedItem.id))"
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
            @slide-over-form-close="slideOverFormOpen = false"
        >
            <InputForm :form="form" />
        </SlideOverForm>

        <SectionHeading
            title="Courses"
            description="The section where you can manage the courses."
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
