<script setup lang="ts">
import { FaceFrownIcon } from "@heroicons/vue/24/outline";
</script>

<template>
    <div class="text-center">
        <FaceFrownIcon class="mx-auto h-16 w-16 text-gray-400" />

        <h3 class="mt-3 text-xl font-semibold text-gray-900">
            <slot name="title"> Oh noo! </slot>
        </h3>
        <p class="mt-2 text-sm text-gray-500">
            <slot name="description"> Something went wrong.</slot>
        </p>
        <div class="mt-6">
            <slot name="fallback" />
        </div>
    </div>
</template>
