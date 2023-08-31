<script setup lang="ts">
import { defineProps, toRefs } from "vue";

const props = defineProps<{
    label?: string;
    disabled?: boolean;
}>();

const { label, disabled } = toRefs(props);
</script>

<template>
    <button
        :disabled="disabled"
        type="submit"
        class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
    >
        {{ label ?? "Submit" }}
    </button>
</template>
