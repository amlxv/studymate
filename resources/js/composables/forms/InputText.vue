<script setup lang="ts">
import { defineProps, FunctionalComponent, toRefs } from "vue";
import { InertiaForm } from "@inertiajs/vue3";
import {
    EnvelopeIcon,
    ExclamationCircleIcon,
    KeyIcon,
    LockClosedIcon,
    IdentificationIcon,
} from "@heroicons/vue/20/solid";
import _ from "lodash";

type InputType = "text" | "password" | "email" | "number" | "date" | "time";
type CommonInput = {
    id: string;
    icon: FunctionalComponent;
    type: string;
    label: string;
};

const props = defineProps<{
    id: string;
    label?: string;
    type?: InputType;
    icon?: FunctionalComponent;
    placeholder?: string;
    model: InertiaForm<unknown>;
    error?: string;
    disabled?: boolean;
    readonly?: boolean;
    classList?: string;
}>();

const {
    id,
    label,
    type,
    icon,
    placeholder,
    model,
    error,
    disabled,
    readonly,
    classList,
} = toRefs(props);

const commonInputs: CommonInput[] = [
    { id: "email", icon: EnvelopeIcon, type: "email", label: "Email address" },
    {
        id: "password",
        icon: KeyIcon,
        type: "password",
        label: "Password",
    },
    {
        id: "password_confirmation",
        icon: LockClosedIcon,
        type: "password",
        label: "Confirm Password",
    },
    {
        id: "name",
        icon: IdentificationIcon,
        type: "text",
        label: "Name",
    },
];

const getInputType = (): InputType => {
    return (
        <InputType>(
            _.find(commonInputs, (input) => input.id === id.value)?.type
        ) ??
        (type?.value || "text")
    );
};

const getInputIcon = (): FunctionalComponent | null => {
    const iconComponent =
        icon?.value ??
        (_.find(commonInputs, (input) => input.id === id.value)?.icon || null);

    return iconComponent ?? iconComponent?.({}, undefined);
};

const getInputLabel = () => {
    return (
        label?.value ??
        _.find(commonInputs, (input) => input.id === id.value)?.label ??
        null
    );
};

const getClassList = () => {
    const baseClassList =
        "block w-full rounded-md border-0 py-1.5 ring-1 ring-inset focus:ring-2 focus:ring-inset sm:text-sm sm:leading-6";
    const errorClass =
        "text-red-900 ring-red-300 placeholder:text-red-300 focus:ring-red-500";
    const notErrorClass =
        "text-gray-900 ring-gray-300 placeholder:text-gray-400 focus:ring-indigo-60";

    let result =
        baseClassList + " " + (error.value ? errorClass : notErrorClass);

    if (getInputIcon()) result = result + " " + "pl-10";
    if (classList.value) result = result + " " + classList.value;

    return result;
};
</script>

<template>
    <div>
        <label
            v-if="!!getInputLabel()"
            :for="id"
            class="block text-sm font-medium leading-6 text-gray-900"
            >{{ getInputLabel() }}</label
        >
        <div
            :class="
                !!getInputIcon()
                    ? 'relative mt-2 rounded-md shadow-sm'
                    : 'mt-2 flex rounded-md  shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600 sm:max-w-md'
            "
        >
            <div
                v-if="!!getInputIcon()"
                class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3"
            >
                <component
                    v-if="!!getInputIcon()"
                    :is="getInputIcon()"
                    class="h-5 w-5 text-gray-400"
                    aria-hidden="true"
                />
            </div>
            <input
                :type="getInputType()"
                :name="id"
                :id="id"
                :class="getClassList()"
                :placeholder="placeholder"
                :aria-invalid="!!error"
                :aria-describedby="error ? id + '-error' : id"
                v-model="model[id]"
                @input="model?.clearErrors(<never>id)"
                v-bind:readonly="readonly"
                v-bind:disabled="disabled"
            />
            <div
                v-if="error && !!getInputIcon()"
                class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3"
            >
                <ExclamationCircleIcon
                    class="h-5 w-5 text-red-500"
                    aria-hidden="true"
                />
            </div>
        </div>
        <p v-if="error" class="mt-2 text-sm text-red-600" :id="id + '-error'">
            {{ error }}
        </p>
    </div>
</template>
