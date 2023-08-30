<script setup lang="ts">
import { defineProps } from "vue";
import {
    EnvelopeIcon,
    ExclamationCircleIcon,
    KeyIcon,
    LockClosedIcon,
} from "@heroicons/vue/20/solid";

type InputType = "text" | "password" | "email" | "number";
type CommonInput = { id: string; icon: unknown; type: string };

const props = defineProps<{
    id: string;
    label?: string;
    type?: InputType;
    icon?: unknown;
    placeholder?: string;
    model?: unknown;
}>();

const commonInputs: CommonInput[] = [
    { id: "email", icon: EnvelopeIcon, type: "email" },
    {
        id: "password",
        icon: KeyIcon,
        type: "password",
    },
    {
        id: "password_confirmation",
        icon: LockClosedIcon,
        type: "password",
    },
];

const getInputType = (): InputType => {
    return <InputType>(
        (commonInputs.find((input) => props.id === input.id)?.type ??
            (props?.type || "text"))
    );
};

const getInputIcon = (): unknown | null => {
    const icon =
        commonInputs.find((input) => props.id === input.id)?.icon ??
        (props?.icon || null);

    return icon ? icon() : icon;
};
</script>

<template>
    <div>
        <label
            :for="props.id"
            class="block text-sm font-medium leading-6 text-gray-900"
            >{{ props.label }}</label
        >
        <div class="relative mt-2 rounded-md shadow-sm">
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
                :name="props.id"
                :id="props.id"
                class="block w-full rounded-md border-0 py-1.5 ring-1 ring-inset focus:ring-2 focus:ring-inset sm:text-sm sm:leading-6"
                :class="
                    (getInputIcon() ? 'pl-10 ' : ' ') +
                    ($page.props.errors[id]
                        ? 'text-red-900 ring-red-300 placeholder:text-red-300 focus:ring-red-500'
                        : 'text-gray-900 ring-gray-300 placeholder:text-gray-400 focus:ring-indigo-600')
                "
                :placeholder="props.placeholder"
                :aria-invalid="!!$page.props.errors[props.id]"
                :aria-describedby="
                    $page.props.errors[props.id] ? props.id + '-error' : id
                "
                v-model="props.model[props.id]"
            />
            <div
                v-if="$page.props.errors[props.id]"
                class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3"
            >
                <ExclamationCircleIcon
                    class="h-5 w-5 text-red-500"
                    aria-hidden="true"
                />
            </div>
        </div>
        <p
            v-if="$page.props.errors[props.id]"
            class="mt-2 text-sm text-red-600"
            :id="id + '-error'"
        >
            {{ $page.props.errors[props.id] }}
        </p>
    </div>
</template>
