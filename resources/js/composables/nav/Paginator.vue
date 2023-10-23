<script setup lang="ts">
import { Link } from "@inertiajs/vue3";
import { toRefs } from "vue";

const props = defineProps<{
    from: Number;
    to: Number;
    total: Number;
    previousUrl: string;
    nextUrl: string;
}>();

const { from, to, total, previousUrl, nextUrl } = toRefs(props);
</script>

<template>
    <nav
        class="flex items-center justify-between border-t border-gray-200 bg-white px-4 py-3 pt-6 sm:px-6"
        aria-label="paginator"
    >
        <div class="hidden sm:block">
            <p class="text-sm text-gray-700">
                Showing
                {{ " " }}
                <span class="font-medium">{{ from }}</span>
                {{ " " }}
                to
                {{ " " }}
                <span class="font-medium">{{ to }}</span>
                {{ " " }}
                of
                {{ " " }}
                <span class="font-medium">{{ total }}</span>
                {{ " " }}
                results
            </p>
        </div>
        <div class="flex flex-1 justify-between sm:justify-end">
            <Link
                :href="previousUrl"
                class="relative inline-flex items-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus-visible:outline-offset-0"
                >Previous
            </Link>
            <Link
                :href="nextUrl"
                class="relative ml-3 inline-flex items-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus-visible:outline-offset-0"
                >Next
            </Link>
        </div>
    </nav>
</template>
