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
        </SectionHeading>

        <div
            class="px-4 transition-all duration-700 sm:px-6 lg:px-8"
            :class="{ ' -translate-x-1/4': slideOverFormOpen }"
        >
            <div class="mt-8 flow-root">
                <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="inline-block min-w-full py-2 align-middle">
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
                </div>
            </div>
        </div>
    </Layout>
</template>
