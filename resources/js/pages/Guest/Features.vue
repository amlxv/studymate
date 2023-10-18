<script setup lang="ts">
import {
    BellAlertIcon,
    CalendarDaysIcon,
    FingerPrintIcon,
    RectangleStackIcon,
} from "@heroicons/vue/24/outline";

const features = [
    {
        name: "Class Timetable",
        description:
            "Stay on top of your clas timetable with just a few taps. Our passionately designed system integrated with iCress.",
        icon: CalendarDaysIcon,
    },
    {
        name: "Activity Management",
        description:
            "Never forget quizzes, exams, or due dates again. Just let the our system logs all your key dates in one place.",
        icon: RectangleStackIcon,
    },
    {
        name: "Schedule Reminder",
        description:
            "Never miss a class or activity again - our system notifies you ahead of time so you stay on top of your schedule.",
        icon: BellAlertIcon,
    },
    {
        name: "Advanced Security",
        description:
            "Student information is securely stored in our servers, protected by unique email and password logins for each user.",
        icon: FingerPrintIcon,
    },
];
</script>

<template>
    <div
        id="features"
        class="mx-auto flex min-h-screen max-w-7xl flex-col justify-center px-6 lg:px-8"
    >
        <div class="mx-auto max-w-2xl lg:text-center">
            <h2 class="text-base font-semibold leading-7 text-indigo-600">
                StudyMate
            </h2>
            <p
                class="mt-2 text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl"
            >
                For students, by a student.
            </p>
            <p class="mt-6 text-lg leading-8 text-gray-600">
                Easily schedule classes, study sessions, activities, and more.
                Get reminders on your phone so you never miss an assignment.
            </p>
        </div>
        <div class="mx-auto mt-16 max-w-2xl sm:mt-20 lg:mt-24 lg:max-w-4xl">
            <dl
                class="grid max-w-xl grid-cols-1 gap-x-8 gap-y-10 lg:max-w-none lg:grid-cols-2 lg:gap-y-16"
            >
                <div
                    v-for="feature in features"
                    :key="feature.name"
                    class="relative pl-16"
                >
                    <dt class="text-base font-semibold leading-7 text-gray-900">
                        <div
                            class="absolute left-0 top-0 flex h-10 w-10 items-center justify-center rounded-lg bg-indigo-600"
                        >
                            <component
                                :is="feature.icon"
                                class="h-6 w-6 text-white"
                                aria-hidden="true"
                            />
                        </div>
                        {{ feature.name }}
                    </dt>
                    <dd class="mt-2 text-base leading-7 text-gray-600">
                        {{ feature.description }}
                    </dd>
                </div>
            </dl>
        </div>
    </div>
</template>
