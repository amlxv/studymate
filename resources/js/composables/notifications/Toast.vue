<script setup lang="ts">
import _ from "lodash";
import { computed, watch } from "vue";
import { usePage } from "@inertiajs/vue3";
import { XMarkIcon } from "@heroicons/vue/20/solid";
import { sanitizeNotification } from "@/types/notification";

const page = usePage();

const status = computed({
    get: () => {
        const status = page.props.flash.status;
        return sanitizeNotification(status);
    },
    set: (value: null) => (page.props.flash.status = value),
});

/**
 * Automatically hide the status in X second(s)
 * when the type is not undefined.
 */
watch(
    status,
    () => {
        if (status.value?.type !== undefined) {
            setTimeout(() => {
                status.value = null;
            }, 2800);
        }
    },
    { immediate: true },
);
</script>

<template>
    <div
        aria-live="assertive"
        class="pointer-events-none fixed inset-0 z-50 flex items-end px-4 py-6 sm:items-start sm:p-6"
    >
        <div class="flex w-full flex-col items-center space-y-4 sm:items-end">
            <transition
                enter-active-class="transform ease-out duration-300 transition"
                enter-from-class="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
                enter-to-class="translate-y-0 opacity-100 sm:translate-x-0"
                leave-active-class="transition ease-in duration-100"
                leave-from-class="opacity-100"
                leave-to-class="opacity-0"
            >
                <div
                    v-if="status"
                    class="pointer-events-auto w-full max-w-sm overflow-hidden rounded-lg bg-white shadow-lg ring-1 ring-black ring-opacity-5"
                >
                    <div class="p-4">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <component
                                    :is="status?.icon?.component"
                                    class="h-6 w-6"
                                    :class="status?.icon?.color"
                                    aria-hidden="true"
                                />
                            </div>
                            <div class="ml-3 w-0 flex-1 pt-0.5">
                                <p class="text-sm font-medium text-gray-900">
                                    {{ _.capitalize(status?.type) }}
                                </p>
                                <p class="mt-1 text-sm text-gray-500">
                                    {{ status?.message }}
                                </p>
                            </div>
                            <div class="ml-4 flex flex-shrink-0">
                                <button
                                    type="button"
                                    @click="status = null"
                                    class="inline-flex rounded-md bg-white text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                                >
                                    <span class="sr-only">Close</span>
                                    <XMarkIcon
                                        class="h-5 w-5"
                                        aria-hidden="true"
                                    />
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </transition>
        </div>
    </div>
</template>
