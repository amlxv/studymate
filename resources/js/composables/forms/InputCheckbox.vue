<script setup lang="ts">
import { defineProps, toRefs } from "vue";
import { InertiaForm } from "@inertiajs/vue3";

const props = defineProps<{
    id: string;
    label: string;
    model: InertiaForm<unknown>;
}>();

const { id, label, model } = toRefs(props);
</script>

<template>
    <div class="flex items-center">
        <input
            :id="id"
            v-model="model[id]"
            type="checkbox"
            class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-600"
        />

        <label :for="id" class="ml-3 block text-sm leading-6 text-gray-700">{{
            label
        }}</label>
    </div>
</template>
