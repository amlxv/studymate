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
    time_start: moment().add(1, "hour").format("HH:00"),
    time_end: null,
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

                        <template v-slot:disclosureTitle
                            >Click to learn more about creating a new schedule
                            here.
                        </template>

                        <template v-slot:disclosureContent>
                            <div class="mb-3.5">
                                <div class="mb-3.5">
                                    The schedule is split into two types: class
                                    timetables and activities. Select the type
                                    of schedule that is most suitable for your
                                    needs. <br />
                                    Below is a quick overview of the key
                                    differences between the two schedule types:
                                </div>

                                <div>Class Timetable</div>

                                <ul class="ml-8 mt-2 list-disc">
                                    <li>
                                        The schedule that repeats on a weekly
                                        basis.
                                    </li>
                                    <li>
                                        The schedule that does not contain
                                        specific dates.
                                    </li>
                                </ul>
                            </div>

                            <div>Activities</div>

                            <ul class="ml-8 mt-2 list-disc">
                                <li>
                                    The schedule that happens on a single,
                                    non-recurring occasion.
                                </li>
                                <li>
                                    The schedule that does contain specific
                                    dates.
                                </li>
                            </ul>
                        </template>
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
