<script setup lang="ts">
import moment from "moment";
import { computed } from "vue";
import { useForm, Link } from "@inertiajs/vue3";
import Layout from "@/layouts/Layout.vue";
import SubmitButton from "@/composables/buttons/SubmitButton.vue";
import SectionHeading from "@/composables/heading/SectionHeading.vue";
import DetailsForm from "@/components/schedules/DetailsForm.vue";
import TypeTabs from "@/components/schedules/TypeTabs.vue";
import CommonButton from "@/composables/buttons/CommonButton.vue";

const form = useForm({
    type: "class",
    title: "",
    description: "",
    date: moment().format("YYYY-MM-DD"),
    time_start: moment().format("HH:00"),
    time_end: moment().add(1, "hour").format("HH:00"),
    day: moment().format("dddd").toLowerCase(),
    remind: false,
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
                form.post(route('schedule.store'), { preserveScroll: true })
            "
        >
            <div class="space-y-12">
                <div class="">
                    <SectionHeading
                        title="New Schedule"
                        description="This information will be added into your
                                schedule."
                    >
                        <Link :href="route('schedule.index')">
                            <CommonButton type="warning" label="Cancel" />
                        </Link>
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
                    <SubmitButton :disabled="form.processing" />
                </div>
            </div>
        </form>
    </Layout>
</template>
