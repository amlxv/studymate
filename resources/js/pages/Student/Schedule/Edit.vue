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
import { QuestionMarkCircleIcon } from "@heroicons/vue/24/outline";
import QuickGuide from "@/composables/modals/QuickGuide.vue";
import ScheduleEditGuide from "@/components/guides/ScheduleEditGuide.vue";
import { ref } from "vue";

const page = usePage();
const schedule = page.props.schedule;
const isQuickGuideModalOpen = ref(false);

const form = useForm({
    type: schedule?.type,
    title: schedule?.title,
    description: schedule?.description,
    date: schedule?.date ?? moment().format("YYYY-MM-DD"),
    time_start: schedule?.time_start ?? moment().add(1, "hour").format("HH:00"),
    time_end: schedule?.time_end ?? null,
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

                        <template v-slot:helpButton>
                            <QuickGuide
                                :open="isQuickGuideModalOpen"
                                @close="isQuickGuideModalOpen = false"
                                title="Edit Schedule"
                            >
                                <ScheduleEditGuide />
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
