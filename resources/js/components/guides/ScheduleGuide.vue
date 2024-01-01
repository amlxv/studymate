<script setup lang="ts">
import { DialogDescription } from "@headlessui/vue";
import { Link } from "@inertiajs/vue3";
import TimetableImage from "@images/props/schedule-timetable.png";
import CreateButtonImage from "@images/props/create-button.png";
import ViewAllImage from "@images/props/schedule-view-all.png";
import DetailsImage from "@images/props/schedule-details.png";
import ViewMoreImage from "@images/props/schedule-view-more.png";
</script>
<template>
    <DialogDescription>
        <ol
            class="list-decimal text-center text-sm leading-6 text-gray-700 md:text-left"
        >
            <li class="mb-10">
                <h3 class="mb-2">
                    The schedules shown here are only for the current month. But
                    you may not see them <br />
                    if you don't yet have a schedule.
                    <Link class="text-blue-500" :href="route('schedule.create')"
                        >Add a new one now!
                    </Link>
                </h3>

                <div class="flex justify-center pt-3">
                    <img class="rounded-lg" :src="TimetableImage" alt="" />
                </div>
            </li>
            <li class="mb-10">
                <h3 class="mb-2">
                    To create a new schedule, you can also click the "Create"
                    button on the top right of
                    <br />
                    the screen.
                </h3>

                <div class="flex justify-center pt-3">
                    <img class="rounded-lg" :src="CreateButtonImage" alt="" />
                </div>
            </li>
            <li class="mb-10">
                <h3 class="mb-2">
                    As mentioned before, you can only see the schedules for the
                    current month in this <br />
                    section. However, if you want to view all the schedules
                    you've added, click the <br />
                    "View all" button next to the "Create" button.
                </h3>

                <div class="flex justify-center pt-3">
                    <img class="rounded-lg" :src="ViewAllImage" alt="" />
                </div>
            </li>
            <li class="mb-10">
                <h3 class="mb-2">
                    You can see more details about each schedule. Simply click
                    on a schedule and the <br />
                    details will appear.
                </h3>

                <div class="flex justify-center pt-3">
                    <img class="rounded-lg" :src="DetailsImage" alt="" />
                </div>
            </li>
            <li class="mb-10">
                <h3 class="mb-2">
                    The section for each day can only show two schedules. If
                    there are more, you may <br />
                    see a "View more" button to see all the schedules for that
                    day. Clicking the button <br />
                    will take you to a page where you can view all the schedules
                    on that date.
                </h3>

                <div class="flex justify-center pt-3">
                    <img class="rounded-lg" :src="ViewMoreImage" alt="" />
                </div>
            </li>
        </ol>
    </DialogDescription>
</template>
