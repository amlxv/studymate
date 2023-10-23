<script setup lang="ts">
import queryString from "query-string";
import { indexOf } from "lodash";
import { computed, onMounted, ref, toRefs } from "vue";
import { useForm, Link, usePage, router } from "@inertiajs/vue3";
import Layout from "@/layouts/Layout.vue";
import TypeTabs from "@/components/schedules/TypeTabs.vue";
import BulkSchedules from "@/components/schedules/BulkSchedules.vue";
import SectionHeading from "@/composables/heading/SectionHeading.vue";
import CommonButton from "@/composables/buttons/CommonButton.vue";
import SelectOption from "@/composables/forms/SelectOption.vue";
import Paginator from "@/composables/nav/Paginator.vue";
import { months, days } from "@/composables/etc/schedules";

const page = usePage();
const scheduleType = ref("class");
const { classes, activities } = toRefs(page.props);

const { search } = new URL(window.location.toString());
const params = queryString.parse(search);

const type = computed({
    get: () => scheduleType.value,
    set: (value: string) => {
        scheduleType.value = value;
    },
});

const form = useForm({
    day: "all",
    month: "all",
});

const handleDayChange = (day) => {
    let href = new URL(window.location.href);
    href.searchParams.set("day", day);

    if (day === "all") {
        href.searchParams.delete("day");
    }

    router.get(href);
};

const handleMonthChange = (month) => {
    let href = new URL(window.location.href);
    href.searchParams.set("month", indexOf(months, month).toString());

    if (month === "all") {
        href.searchParams.delete("month");
    }

    router.get(href);
};

const handleTypeChange = (newType) => {
    type.value = newType;

    let href = new URL(window.location.href);
    href.searchParams.set("type", newType);

    router.get(href);
};

const getPreviousUrl = (classes, activities) => {
    let href = new URL(window.location.href);

    if (type.value === "class") {
        href.searchParams.set(
            "page",
            (classes?.current_page != 1
                ? classes?.current_page - 1
                : 1
            ).toString(),
        );

        return href.toString();
    }

    if (type.value === "activity") {
        href.searchParams.set(
            "page",
            (activities?.current_page != 1
                ? activities?.current_page - 1
                : 1
            ).toString(),
        );

        return href.toString();
    }
};

const getNextUrl = (classes, activities) => {
    let href = new URL(window.location.href);

    if (type.value === "class") {
        href.searchParams.set(
            "page",
            (classes?.current_page != classes.last_page
                ? classes?.current_page + 1
                : classes.last_page
            ).toString(),
        );

        return href.toString();
    }

    if (type.value === "activity") {
        href.searchParams.set(
            "page",
            (activities?.current_page != activities.last_page
                ? activities?.current_page + 1
                : activities.last_page
            ).toString(),
        );

        return href.toString();
    }
};

onMounted(() => {
    if ("type" in params) {
        scheduleType.value = params.type;
    }

    if ("day" in params) {
        form.day = params.day;
    }

    if ("month" in params) {
        form.month = months[params.month];
    }
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
                        title="All Schedules"
                        description="Find out what your past, ongoing and future schedules."
                    >
                        <Link :href="route('schedule.index')">
                            <CommonButton type="warning" label="Back" />
                        </Link>
                    </SectionHeading>

                    <div class="flex items-center justify-between align-middle">
                        <TypeTabs
                            :type="type"
                            @type-change="(val) => handleTypeChange(val)"
                        />

                        <div class="mt-6">
                            <SelectOption
                                v-if="type == 'class'"
                                id="day"
                                :options="days"
                                :model="form"
                                @input="handleDayChange($event.target.value)"
                            />
                            <SelectOption
                                v-if="type == 'activity'"
                                id="month"
                                :options="months"
                                :model="form"
                                @input="handleMonthChange($event.target.value)"
                            />
                        </div>
                    </div>
                </div>

                <BulkSchedules
                    :classes="classes"
                    :activities="activities"
                    :type="type"
                    :form="form"
                />
            </div>

            <Paginator
                :total="type == 'class' ? classes.total : activities.total"
                :previous-url="getPreviousUrl(classes, activities)"
                :from="type == 'class' ? classes.from : activities.from"
                :to="type == 'class' ? classes.to : activities.to"
                :next-url="getNextUrl(classes, activities)"
            />
        </form>
    </Layout>
</template>
