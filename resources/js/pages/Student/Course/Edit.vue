<!-- Deprecated -->

<script setup lang="ts">
import { useForm, Link, usePage, router } from "@inertiajs/vue3";
import Layout from "@/layouts/Layout.vue";
import SubmitButton from "@/composables/buttons/SubmitButton.vue";
import SectionHeading from "@/composables/heading/SectionHeading.vue";
import DetailsForm from "@/components/courses/DetailsForm.vue";
import CommonButton from "@/composables/buttons/CommonButton.vue";

const page = usePage();

const form = useForm({
    name: page.props?.course?.name,
    code: page.props?.course?.code,
    group: page.props?.course?.group,
});
</script>

<template>
    <Layout>
        <form
            @submit.prevent="
                form.put(route('course.update', $page.props?.course?.id), {
                    preserveScroll: true,
                })
            "
        >
            <div class="space-y-12">
                <div class="">
                    <SectionHeading
                        title="New Course"
                        description="This information will be added into your
                                courses."
                    >
                        <div class="flex space-x-2">
                            <div
                                @click="
                                    () =>
                                        router.delete(
                                            route(
                                                'course.destroy',
                                                $page.props?.course?.id,
                                            ),
                                        )
                                "
                            >
                                <CommonButton
                                    type="warning"
                                    label="Delete"
                                    class="bg-red-600 text-white hover:bg-red-700 hover:text-white"
                                />
                            </div>

                            <Link :href="route('course.index')">
                                <CommonButton type="warning" label="Cancel" />
                            </Link>
                        </div>
                    </SectionHeading>
                </div>

                <DetailsForm :form="form" />
            </div>

            <div class="mt-6 flex items-center justify-end gap-x-6">
                <div>
                    <SubmitButton :disabled="form.processing" label="Update" />
                </div>
            </div>
        </form>
    </Layout>
</template>
