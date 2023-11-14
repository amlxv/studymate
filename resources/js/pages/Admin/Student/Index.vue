<script setup lang="ts">
import Layout from "@/layouts/Layout.vue";
import { computed, ComputedRef, ref, watch } from "vue";
import { InertiaForm, router, useForm, usePage } from "@inertiajs/vue3";
import { Student, Paginator as PaginatorType } from "@/types/common";
import { getRoute } from "@/composables/etc/utils";
import SectionHeading from "@/composables/heading/SectionHeading.vue";
import InputForm from "@/components/students/InputForm.vue";
import SlideOverForm from "@/composables/slide-overs/SlideOverForm.vue";
import IndexTable from "@/components/students/IndexTable.vue";
import Paginator from "@/composables/nav/Paginator.vue";
import DeleteConfirmation from "@/composables/modals/DeleteConfirmation.vue";

const page = usePage();
const students: ComputedRef<PaginatorType<Student>> = computed(
    () => page?.props?.students as PaginatorType<Student>,
);

const selectedItem = ref(null);
const slideOverFormOpen = ref(false);
const slideOverFormMode = ref(null);
const isDeleteConfirmationModalOpen = ref(false);

const form: InertiaForm<Student & { _method: "POST" | "PUT" }> = useForm({
    _method: null,
    name: null,
    email: null,
    password: null,
    phone_number: null,
    avatar: null,
    student_id: null,
    gender: "male",
    address: null,
    faculty: null,
    campus: null,
    program: null,
});

const handleFormSubmit = () => {
    const options = {
        onSuccess: () => {
            slideOverFormOpen.value = false;
        },
    };

    if (slideOverFormMode.value === "edit") {
        form._method = "PUT";
        form.post(
            getRoute("admin.student.update").replace(
                /{.+}/,
                selectedItem.value?.id,
            ),
            options,
        );
    } else {
        form._method = "POST";
        form.post(getRoute("admin.student.store"), options);
    }
};

const handleEdit = (student: Student) => {
    selectedItem.value = student;
    slideOverFormMode.value = "edit";
    slideOverFormOpen.value = true;
};

const handleDelete = (path: string) => {
    router.delete(path);
    isDeleteConfirmationModalOpen.value = false;
};

watch(selectedItem, () => {
    form.clearErrors();
    form.name = selectedItem.value?.name;
    form.email = selectedItem.value?.email;
    form.password = selectedItem.value?.password;
    form.phone_number = selectedItem.value?.phone_number;
    form.avatar = selectedItem.value?.avatar;
    form.student_id = selectedItem.value?.student_id;
    form.gender = selectedItem.value?.gender;
    form.address = selectedItem.value?.address;
    form.faculty = selectedItem.value?.faculty;
    form.campus = selectedItem.value?.campus;
    form.program = selectedItem.value?.program;
});
</script>

<template>
    <Layout>
        <DeleteConfirmation
            :open="isDeleteConfirmationModalOpen"
            @close="isDeleteConfirmationModalOpen = false"
            @delete="
                handleDelete(route('admin.student.destroy', selectedItem.id))
            "
        />

        <SlideOverForm
            :on-submit="handleFormSubmit"
            :title="
                slideOverFormMode === 'create' ? 'New Student' : 'Edit Student'
            "
            :description="
                slideOverFormMode === 'create'
                    ? 'Get started by filling in the information below to create a new student.'
                    : 'Fill in the form with new information to update the student information.'
            "
            :open="slideOverFormOpen"
            @close="slideOverFormOpen = false"
        >
            <InputForm :form="form" />
        </SlideOverForm>

        <SectionHeading
            title="Students"
            description="Manage all registered student in this section."
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

        <div class="mt-8 flow-root px-4">
            <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div
                    class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8"
                >
                    <IndexTable
                        :students="students?.data as Student[]"
                        :on-edit="(student) => handleEdit(student)"
                        :on-delete="
                            (student) => {
                                selectedItem = student;
                                isDeleteConfirmationModalOpen = true;
                            }
                        "
                    />
                </div>
                <Paginator
                    :total="students?.total"
                    :previous-url="students?.prev_page_url ?? ''"
                    :from="students?.from"
                    :to="students?.to"
                    :next-url="students?.next_page_url ?? ''"
                />
            </div>
        </div>
    </Layout>
</template>
