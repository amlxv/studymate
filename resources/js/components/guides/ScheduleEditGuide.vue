<script setup lang="ts">
import { DialogDescription } from "@headlessui/vue";
import SwitchTypeImage from "@images/props/schedule-switch-type.png";
import InputOptionalImage from "@images/props/schedule-input-optional.png";
import InputSelectDayImage from "@images/props/schedule-select-day.png";
import NotificationImage from "@images/props/schedule-notification.png";
import UpdateButtonImage from "@images/props/update-button.png";
</script>
<template>
    <DialogDescription>
        <ol
            class="list-decimal text-center text-sm leading-6 text-gray-700 md:text-left"
        >
            <li class="mb-10">
                <h3 class="mb-2">
                    First, determine if you want to change to a "Class
                    Timetable" or "Activities" schedule. <br />
                    Switching the type changes the information required for
                    each. For more details, <br />
                    you can read the explanation at the bottom of this button.
                </h3>

                <div class="flex justify-center pt-3">
                    <img class="rounded-lg" :src="SwitchTypeImage" alt="" />
                </div>
            </li>
            <li class="mb-10">
                <h3 class="mb-2">
                    Edit the schedule's information as needed. Note that all
                    inputs are required unless the <br />
                    word "Optional" appears after the input's label.
                </h3>

                <div class="flex justify-center pt-3">
                    <img class="rounded-lg" :src="InputOptionalImage" alt="" />
                </div>
            </li>
            <li class="mb-10">
                <h3 class="mb-2">
                    As mentioned before, the required information changes based
                    on the schedule <br />
                    type selected. For example, you cannot select a day when the
                    type is set to <br />
                    "Activities".
                </h3>

                <div class="flex justify-center pt-3">
                    <img class="rounded-lg" :src="InputSelectDayImage" alt="" />
                </div>
            </li>
            <li class="mb-10">
                <h3 class="mb-2">
                    If you want to receive a reminder before the schedule
                    occurs, feel free to turn on <br />
                    this option. However, remember you first need to link your
                    StudyMate account with <br />
                    Telegram to use this feature.
                </h3>

                <div class="flex justify-center pt-3">
                    <img class="rounded-lg" :src="NotificationImage" alt="" />
                </div>
            </li>
            <li class="mb-10">
                <h3 class="mb-2">
                    Well, you're on the final step now. Hit the "Update" button
                    to save this schedule.
                </h3>

                <div class="flex justify-center pt-3">
                    <img class="rounded-lg" :src="UpdateButtonImage" alt="" />
                </div>
            </li>
        </ol>
    </DialogDescription>
</template>
