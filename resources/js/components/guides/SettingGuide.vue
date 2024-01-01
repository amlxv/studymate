<script setup lang="ts">
import { DialogDescription } from "@headlessui/vue";
import EditButtonImage from "@images/props/enable-edit-button.png";
import TelegramButtonImage from "@images/props/telegram-button.png";
import TimeBeforeImage from "@images/props/setting-time-before.png";
import SaveButtonImage from "@images/props/save-button.png";
</script>
<template>
    <DialogDescription>
        <ol
            class="list-decimal text-center text-sm leading-6 text-gray-700 md:text-left"
        >
            <li class="mb-10">
                <h3 class="mb-2">
                    In order to prevent accidental changes to the information,
                    all inputs are disabled by <br />
                    default. To make any changes, click the "Enable Edit" button
                    to enable editing.
                </h3>

                <div class="flex justify-center pt-3">
                    <img class="rounded-lg" :src="EditButtonImage" alt="" />
                </div>
            </li>
            <li class="mb-10">
                <h3 class="mb-2">
                    Link your StudyMate account with Telegram to receive handy
                    reminders for upcoming <br />
                    tasks and deadlines. Just click the "Telegram" button. Note
                    that it might take a <br />
                    few moments for the button to become clickable as it
                    retrieves a secure link <br />
                    from Telegram.
                </h3>

                <div class="flex justify-center pt-3">
                    <img class="rounded-lg" :src="TelegramButtonImage" alt="" />
                </div>
            </li>
            <li class="mb-10">
                <h3 class="mb-2">
                    Feel free to adjust the settings to receive reminders
                    exactly how you like them. These <br />
                    settings will apply to all of your schedules. Just keep in
                    mind: Changing the "time before" <br />
                    setting will create a new reminder job, so you might receive
                    multiple notifications for <br />
                    previously scheduled tasks (one based on the original time,
                    and one based on the <br />
                    new time).
                </h3>

                <div class="flex justify-center pt-3">
                    <img class="rounded-lg" :src="TimeBeforeImage" alt="" />
                </div>
            </li>
            <li class="mb-10">
                <h3 class="mb-2">
                    Once you've made your desired changes, click the "Save"
                    button to update your settings. <br />
                    No need to worry about saving the Telegram link as we'll
                    handle that automatically on our <br />
                    servers.
                </h3>

                <div class="flex justify-center pt-3">
                    <img class="rounded-lg" :src="SaveButtonImage" alt="" />
                </div>
            </li>
        </ol>
    </DialogDescription>
</template>
