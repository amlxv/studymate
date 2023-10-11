<script setup lang="ts">
import { defineProps, toRefs } from "vue";
import type { Type } from "@/types/common";

const props = defineProps<{
    label?: string;
    type: Type;
    disabled?: boolean;
    onClick?: Function;
    customClass?: string;
}>();

const { label, disabled, onClick, customClass, type } = toRefs(props);

const commonButtonStyles = [
    {
        type: "successful",
        style: "",
    },
    {
        type: "info",
        style: "",
    },
    {
        type: "warning",
        style: "flex w-full justify-center rounded-md border border-red-300 px-3 py-1.5 text-sm leading-6 text-red-400 shadow-sm transition-colors hover:bg-red-50 hover:text-red-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-red-600",
    },
    {
        type: "error",
        style: "",
    },
];
</script>

<template>
    <button
        :disabled="disabled"
        :class="commonButtonStyles.find((btn) => btn.type === type).style"
        @click="onClick"
        type="button"
    >
        {{ label ?? "Button" }}
    </button>
</template>
