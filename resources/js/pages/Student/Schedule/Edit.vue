<script setup lang="ts">
import moment from "moment";
import { computed } from "vue";
import { useForm, Link, usePage, router } from "@inertiajs/vue3";
import Layout from "@/layouts/Layout.vue";
import SubmitButton from "@/composables/buttons/SubmitButton.vue";
import SectionHeading from "@/composables/heading/SectionHeading.vue";
import DetailsForm from "@/components/schedules/DetailsForm.vue";
import TypeTabs from "@/components/schedules/TypeTabs.vue";
import CommonButton from "@/composables/buttons/CommonButton.vue";

const page = usePage();
const schedule = page.props.schedule;

const form = useForm({
    type: schedule?.type,
    title: schedule?.title,
    description: schedule?.description,
    date: schedule?.date ?? moment().format("YYYY-MM-DD"),
    time_start: schedule?.time_start ?? moment().format("HH:00"),
    time_end: schedule?.time_end ?? moment().add(1, "hour").format("HH:00"),
    day: schedule?.day ?? moment().format("dddd").toLowerCase(),
    remind: !!schedule?.remind,
});

const type = computed({
    get: () => form.type,
    set: (value: string) => {
        form.type = value;
    },
});
</script>

<template>
    <Layout>
        <form
            @submit.prevent="
                form.put(route('schedule.update', schedule?.id), {
                    preserveScroll: true,
                })
            "
        >
            <div class="space-y-12">
                <div class="">
                    <SectionHeading
                        title="Edit Schedule"
                        description="The new information will be updated."
                    >
                        <div class="flex space-x-2">
                            <div
                                @click="
                                    () =>
                                        router.delete(
                                            route(
                                                'schedule.destroy',
                                                schedule?.id,
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

                            <Link :href="route('schedule.index')">
                                <CommonButton type="warning" label="Cancel" />
                            </Link>
                        </div>
                    </SectionHeading>

                    <TypeTabs
                        :type="type"
                        @type-change="(val) => (type = val)"
                    />
                </div>

                <DetailsForm :form="form" :type="type" />
            </div>

            <div class="mt-6 flex items-center justify-end gap-x-6">
                <div>
                    <SubmitButton label="Update" />
                </div>
            </div>
        </form>
    </Layout>
</template>
