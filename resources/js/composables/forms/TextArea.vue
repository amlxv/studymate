<script setup lang="ts">
import { defineProps, toRefs } from "vue";
import { InertiaForm } from "@inertiajs/vue3";

const props = defineProps<{
    id: string;
    label?: string;
    placeholder?: string;
    model: InertiaForm<unknown>;
    error?: string;
    disabled?: boolean;
    readonly?: boolean;
    classList?: string;
    description?: string;
    handleClickOnDisabled?: Function;
}>();

const {
    id,
    label,
    placeholder,
    model,
    error,
    disabled,
    readonly,
    classList,
    handleClickOnDisabled,
} = toRefs(props);
</script>

<template>
    <div @click="disabled ? handleClickOnDisabled(id) : ''">
        <label
            for="description"
            class="block text-sm font-medium leading-6 text-gray-900"
            >{{ label ?? "Description" }}
        </label>
        <div class="mt-2">
            <textarea
                :id="id"
                :name="id"
                rows="5"
                class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                :class="
                    (error
                        ? 'text-red-900 ring-red-300 placeholder:text-red-300 focus:ring-red-500'
                        : '') + (disabled ? 'pointer-events-none' : '')
                "
                v-model="model[id]"
                v-bind:readonly="readonly"
                v-bind:disabled="disabled"
                :placeholder="placeholder"
                :aria-invalid="!!error"
                :aria-describedby="error ? id + '-error' : id"
                @input="model?.clearErrors(<never>id)"
            />
        </div>
        <p class="mt-3 text-sm leading-6 text-gray-600" v-if="!error">
            {{ description ?? "Write a few sentences about this task." }}
        </p>

        <p v-if="error" class="mt-2 text-sm text-red-600">
            {{ error }}
        </p>
    </div>
</template>
