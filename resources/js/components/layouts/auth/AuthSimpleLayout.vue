<script setup lang="ts">
import { defineProps } from "vue";

const props = defineProps<{
    label: string;
}>();
</script>

<template>
    <div
        class="flex min-h-full flex-1 flex-col justify-center px-6 py-12 lg:px-8"
    >
        <div class="sm:mx-auto sm:w-full sm:max-w-sm">
            <img
                class="mx-auto h-10 w-auto"
                src="https://i.imgur.com/Lgce8Ha.png"
                alt="StudyMate"
            />
            <h2
                class="mt-10 text-center text-2xl font-bold leading-9 tracking-tight text-gray-900"
            >
                {{ label }}
            </h2>
        </div>

        <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
            <slot name="form" />

            <p class="mt-10 text-center text-sm text-gray-500">
                <slot name="details" />
            </p>
        </div>
    </div>
</template>
