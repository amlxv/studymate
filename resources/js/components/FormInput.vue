<script setup lang="ts">
import { defineProps, FunctionalComponent, toRefs } from "vue";
import {
    EnvelopeIcon,
    ExclamationCircleIcon,
    KeyIcon,
    LockClosedIcon,
} from "@heroicons/vue/20/solid";
import { InertiaForm } from "@inertiajs/vue3";

type InputType = "text" | "password" | "email" | "number";
type CommonInput = { id: string; icon: FunctionalComponent; type: string };

const props = defineProps<{
    id: string;
    label?: string;
    type?: InputType;
    icon?: FunctionalComponent;
    placeholder?: string;
    model: InertiaForm<unknown>;
    error?: string;
}>();

const { id, label, type, icon, placeholder, model, error } = toRefs(props);

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
        (commonInputs.find((input) => id.value === input.id)?.type ??
            (type?.value || "text"))
    );
};

const getInputIcon = (): FunctionalComponent | null => {
    const iconComponent =
        commonInputs.find((input) => id.value === input.id)?.icon ??
        (icon?.value || null);

    return iconComponent ? iconComponent({}, undefined) : icon.value;
};
</script>

<template>
    <div>
        <label
            :for="id"
            class="block text-sm font-medium leading-6 text-gray-900"
            >{{ label }}</label
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
                :name="id"
                :id="id"
                class="block w-full rounded-md border-0 py-1.5 ring-1 ring-inset focus:ring-2 focus:ring-inset sm:text-sm sm:leading-6"
                :class="
                    (getInputIcon() ? 'pl-10 ' : ' ') +
                    (error
                        ? 'text-red-900 ring-red-300 placeholder:text-red-300 focus:ring-red-500'
                        : 'text-gray-900 ring-gray-300 placeholder:text-gray-400 focus:ring-indigo-600')
                "
                :placeholder="placeholder"
                :aria-invalid="!!error"
                :aria-describedby="error ? id + '-error' : id"
                v-model="model[id]"
                @input="model?.clearErrors()"
            />
            <div
                v-if="error"
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
