<!-- Deprecated -->

<script setup lang="ts">
import { useForm, Link } from "@inertiajs/vue3";
import Layout from "@/layouts/Layout.vue";
import SubmitButton from "@/composables/buttons/SubmitButton.vue";
import SectionHeading from "@/composables/heading/SectionHeading.vue";
import DetailsForm from "@/components/courses/DetailsForm.vue";
import CommonButton from "@/composables/buttons/CommonButton.vue";

const form = useForm({
    name: null,
    code: null,
    group: null,
});
</script>

<template>
    <Layout>
        <form
            @submit.prevent="
                form.post(route('course.store'), { preserveScroll: true })
            "
        >
            <div class="space-y-12">
                <div class="">
                    <SectionHeading
                        title="New Course"
                        description="This information will be added into your
                                courses."
                    >
                        <Link :href="route('course.index')">
                            <CommonButton type="warning" label="Cancel" />
                        </Link>
                    </SectionHeading>
                </div>

                <DetailsForm :form="form" />
            </div>

            <div class="mt-6 flex items-center justify-end gap-x-6">
                <div>
                    <SubmitButton :disabled="form.processing" />
                </div>
            </div>
        </form>
    </Layout>
</template>
