<script setup lang="ts">
import { defineProps } from "vue";
import { sanitizeNotification, Type } from "@/types/notification";

const props = defineProps<{
    type: Type;
    message: string;
}>();

const status = sanitizeNotification(props.message, props.type);
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
        </div>
    </div>
</template>
