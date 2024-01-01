<script setup lang="ts">
import { DialogDescription } from "@headlessui/vue";
import CreateButtonImage from "@images/props/create-button.png";
import CourseInputImage from "@images/props/course-input.png";
import CourseReminderImage from "@images/props/course-reminder.png";
import CourseSurpriseImage from "@images/props/course-surprise-me.png";
</script>
<template>
    <DialogDescription>
        <ol
            class="list-decimal text-center text-sm leading-6 text-gray-700 md:text-left"
        >
            <li class="mb-10">
                <h3 class="mb-2">
                    This course section is only for UiTM students. Creating a
                    course here will trigger the <br />
                    system to retrieve the student's timetable from UiTM's
                    website. So you don't have to <br />
                    manually find & add each timetable for that course. Click on
                    the "Create" button to <br />add the course.
                </h3>

                <div class="flex justify-center pt-3">
                    <img class="rounded-lg" :src="CreateButtonImage" alt="" />
                </div>
            </li>
            <li class="mb-10">
                <h3 class="mb-2">
                    Clicking the "Create" button will slide out the "Create
                    Course" section. Fill in the <br />
                    required information. Note that all inputs are required
                    unless stated "Optional" next <br />
                    to the label.
                </h3>

                <div class="flex justify-center pt-3">
                    <img class="rounded-lg" :src="CourseInputImage" alt="" />
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
                    <img class="rounded-lg" :src="CourseReminderImage" alt="" />
                </div>
            </li>
            <li class="mb-10">
                <h3 class="mb-2">
                    However, if you want a faster way to do the same thing,
                    there is a "Magic Button" <br />
                    that can achieve this in one click. But note, this button
                    only works under three <br />
                    conditions: MyStudent is accessible, student information is
                    completed, and a <br />
                    Telegram account is linked.
                </h3>

                <div class="flex justify-center pt-3">
                    <img class="rounded-lg" :src="CourseSurpriseImage" alt="" />
                </div>
            </li>
        </ol>
    </DialogDescription>
</template>
