<script setup lang="ts">
import { DialogDescription } from "@headlessui/vue";
import SwitchTypeImage from "@images/props/schedule-switch-type.png";
import FilterDropdownImage from "@images/props/schedule-filter-dropdown.png";
import SearchBarImage from "@images/props/search-bar.png";
import EditButtonImage from "@images/props/edit-button.png";
import NavigatorImage from "@images/props/navigator.png";
</script>
<template>
    <DialogDescription>
        <ol
            class="list-decimal text-center text-sm leading-6 text-gray-700 md:text-left"
        >
            <li class="mb-10">
                <h3 class="mb-2">
                    In this section, you can see all the schedules you've added,
                    categorized by schedule <br />
                    type. Switching between the types will show the schedules
                    corresponding to each <br />
                    type.
                </h3>

                <div class="flex justify-center pt-3">
                    <img class="rounded-lg" :src="SwitchTypeImage" alt="" />
                </div>
            </li>
            <li class="mb-10">
                <h3 class="mb-2">
                    You can filter the schedules to only view what you want. For
                    the class timetable, <br />
                    filter by day to see schedules on specific days. For the
                    activities schedule, filter <br />
                    by month to see schedules in a particular month.
                </h3>

                <div class="flex justify-center pt-3">
                    <img class="rounded-lg" :src="FilterDropdownImage" alt="" />
                </div>
            </li>
            <li class="mb-10">
                <h3 class="mb-2">
                    More interestingly, at the top of the screen there is a
                    search box you can use to <br />
                    find specific schedules.
                </h3>

                <div class="flex justify-center pt-3">
                    <img class="rounded-lg" :src="SearchBarImage" alt="" />
                </div>
            </li>
            <li class="mb-10">
                <h3 class="mb-2">
                    The schedules are displayed in a table. At the far right of
                    each schedule is a pencil <br />
                    icon - clicking this button allows you to edit the selected
                    schedule.
                </h3>

                <div class="flex justify-center pt-3">
                    <img class="rounded-lg" :src="EditButtonImage" alt="" />
                </div>
            </li>
            <li class="mb-10">
                <h3 class="mb-2">
                    If you have many schedules, they will be paginated to
                    prevent a crowded interface. <br />
                    To navigate between pages, use the buttons at the very
                    bottom.
                </h3>

                <div class="flex justify-center pt-3">
                    <img class="rounded-lg" :src="NavigatorImage" alt="" />
                </div>
            </li>
        </ol>
    </DialogDescription>
</template>
