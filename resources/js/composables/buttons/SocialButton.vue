<script setup lang="ts">
import { defineProps } from "vue";
import _ from "lodash";

const props = defineProps<{
    id: string;
    label?: string;
    classList?: string;
    href: string;
}>();

const { id, label, classList, href } = props;

const commonSocial = [
    {
        id: "google",
        label: "Google",
        classList:
            "bg-white text-gray-900 focus-visible:outline-[#1D9BF0] border border-slate-300",
    },
    {
        id: "github",
        label: "GitHub",
        classList: "bg-[#24292F] text-white focus-visible:outline-[#24292F]",
    },
    {
        id: "telegram",
        label: "Telegram",
        classList:
            "bg-white text-gray-900 focus-visible:outline-[#1D9BF0] border border-slate-300",
    },
];

const getLabel = () => {
    return (
        _.find(commonSocial, (social) => social.id === id)?.label ??
        _.capitalize(id)
    );
};

const getClassList = () => {
    const defaultClassList =
        "bg-white text-gray-900 focus-visible:outline-[#1D9BF0] border border-slate-300";
    return (
        _.find(commonSocial, (social) => social.id === id)?.classList ??
        (classList || defaultClassList)
    );
};
</script>

<template>
    <a
        :href="href"
        class="flex w-full items-center justify-center gap-3 rounded-md px-3 py-1.5 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2"
        :class="getClassList() + ' ' + classList"
    >
        <slot name="icon" />
        <span class="text-sm font-semibold leading-6">{{ getLabel() }}</span>
    </a>
</template>
