<script setup lang="ts">
import { defineProps, toRefs } from "vue";
import { InertiaForm } from "@inertiajs/vue3";
import _ from "lodash";

const props = defineProps<{
    id: string;
    label?: string;
    model: InertiaForm<unknown>;
    error?: string;
    disabled?: boolean;
    readonly?: boolean;
    classList?: string;
    options: Array<string>;
    selected?: string;
    handleClickOnDisabled?: Function;
}>();

const {
    id,
    label,
    model,
    error,
    disabled,
    readonly,
    classList,
    options,
    handleClickOnDisabled,
} = toRefs(props);

const getClassList = () => {
    const baseClassList =
        "block w-full rounded-md border-0 py-1.5 shadow-sm ring-1 ring-inset focus:ring-2 focus:ring-inset sm:max-w-xs sm:text-sm sm:leading-6";
    const errorClass =
        "text-red-900 ring-red-300 placeholder:text-red-300 focus:ring-red-500";
    const notErrorClass =
        "text-gray-900 ring-gray-300 placeholder:text-gray-400 focus:ring-indigo-60";
    const disabledClass = " pointer-events-none";

    let result =
        baseClassList +
        (disabled.value ? disabledClass : "") +
        " " +
        (error.value ? errorClass : notErrorClass);

    if (classList.value) result = result + " " + classList.value;

    return result;
};
</script>

<template>
    <div @click="disabled ? handleClickOnDisabled(id) : ''">
        <label
            v-if="!label"
            :for="id"
            class="block text-sm font-medium leading-6 text-gray-900"
            >{{ label }}</label
        >
        <div>
            <select
                id="day"
                name="day"
                autocomplete="day"
                :class="getClassList()"
                v-model="model[id]"
                @change="() => (!!error ? model?.clearErrors(<never>id) : '')"
                v-bind:disabled="disabled"
            >
                <option v-for="option in options" :value="option">
                    {{ _.capitalize(option) }}
                </option>
            </select>
        </div>
        <p v-if="error" class="mt-2 text-sm text-red-600" :id="id + '-error'">
            {{ error }}
        </p>
    </div>
</template>
