<script setup lang="ts">
import { DialogDescription } from "@headlessui/vue";
import EnableEditButtonImage from "@images/props/enable-edit-button.png";
import ProfileInputImage from "@images/props/profile-input.png";
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
                    <img
                        class="rounded-lg"
                        :src="EnableEditButtonImage"
                        alt=""
                    />
                </div>
            </li>
            <li class="mb-10">
                <h3 class="mb-2">
                    However, even after enabling editing, some inputs may remain
                    disabled due to their <br />
                    inability to be changed. All fields are optional except
                    those within the "Student Information" <br />
                    section, which are required unless marked as "Optional" in
                    the input label.
                </h3>

                <div class="flex justify-center pt-3">
                    <img class="rounded-lg" :src="ProfileInputImage" alt="" />
                </div>
            </li>
            <li class="mb-10">
                <h3 class="mb-2">
                    Once you've made your desired changes, click the "Save"
                    button to update your settings. <br />
                    We'll handle the update automatically on our servers.
                </h3>

                <div class="flex justify-center pt-3">
                    <img class="rounded-lg" :src="SaveButtonImage" alt="" />
                </div>
            </li>
        </ol>
    </DialogDescription>
</template>
