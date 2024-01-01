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
import { QuestionMarkCircleIcon } from "@heroicons/vue/24/outline";
import QuickGuide from "@/composables/modals/QuickGuide.vue";
import ScheduleCreateGuide from "@/components/guides/ScheduleCreateGuide.vue";
import { ref } from "vue";

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

const isQuickGuideModalOpen = ref(false);

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

                        <template v-slot:helpButton>
                            <QuickGuide
                                :open="isQuickGuideModalOpen"
                                @close="isQuickGuideModalOpen = false"
                                title="New Schedule"
                            >
                                <ScheduleCreateGuide />
                            </QuickGuide>
                            <button
                                @click="isQuickGuideModalOpen = true"
                                type="button"
                            >
                                <QuestionMarkCircleIcon
                                    class="animate__animated animate__rubberBand h-5 w-5 opacity-70"
                                />
                            </button>
                        </template>

                        <template v-slot:disclosureTitle
                            >Click to learn more about creating a new schedule
                            here.
                        </template>

                        <template v-slot:disclosureContent>
                            <div class="mb-3.5">
                                <ul class="ml-5 list-disc">
                                    <li>
                                        The "Time End" is made optional. Some
                                        events does not have the end time.
                                    </li>
                                    <li>
                                        The Telegram account integration is
                                        required to enable the reminder options.
                                    </li>
                                    <li>
                                        Enabling the reminder will make the
                                        system send the reminder before the
                                        event starts.
                                    </li>
                                    <li>
                                        To save time, you can just add which
                                        courses you're taking
                                        <Link
                                            :href="route('course.index')"
                                            class="text-blue-500"
                                            >here
                                        </Link>
                                        . We'll automatically collect your data
                                        from iCress and MyStudent.
                                    </li>
                                </ul>
                            </div>
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
