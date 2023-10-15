<script setup lang="ts">
import { defineProps, toRefs } from "vue";

type Action = {
    label: string;
    href: string;
    customClass?: string;
};

const props = defineProps<{
    title: string;
    description: string;
}>();

const { title, description } = toRefs(props);
</script>

<template>
    <div
        class="border-b border-gray-200 pb-8 sm:flex sm:items-center sm:justify-between"
    >
        <div class="flex-1">
            <h2 class="text-base font-semibold leading-7 text-gray-900">
                {{ title }}
            </h2>
            <p class="mt-1 text-sm leading-6 text-gray-600">
                {{ description }}
            </p>
        </div>
        <div class="mt-3 sm:ml-4 sm:mt-0">
            <slot />
        </div>
    </div>
</template>
