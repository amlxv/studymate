<script setup lang="ts">
import { XMarkIcon } from "@heroicons/vue/20/solid";
import { sanitizeNotification, Type } from "@/types/notifications";

const props = defineProps<{
    type: Type;
    message: string;
}>();

const status = sanitizeNotification(props.message, props.type);
console.log(status);
</script>

<template>
    <div class="rounded-md p-4" :class="status?.backgroundColor">
        <div class="flex">
            <div class="flex-shrink-0">
                <component
                    :is="status?.icon.component"
                    class="h-5 w-5"
                    :class="status?.icon.color"
                    aria-hidden="true"
                />
            </div>
            <div class="ml-3">
                <p class="text-sm font-medium" :class="status?.textColor">
                    {{ status?.message }}
                </p>
            </div>
            <div class="ml-auto pl-3">
                <div class="-mx-1.5 -my-1.5">
                    <button
                        type="button"
                        class="inline-flex rounded-md bg-gray-50 p-1.5 text-gray-500 opacity-50 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-600 focus:ring-offset-2 focus:ring-offset-gray-50"
                    >
                        <span class="sr-only">Dismiss</span>
                        <XMarkIcon class="h-5 w-5" aria-hidden="true" />
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>
