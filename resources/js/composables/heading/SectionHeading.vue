<script setup lang="ts">
import { defineProps, toRefs, useSlots } from "vue";
import { Disclosure, DisclosureButton, DisclosurePanel } from "@headlessui/vue";
import { ChevronUpIcon } from "@heroicons/vue/20/solid";

type Action = {
    label: string;
    href: string;
    customClass?: string;
};

const props = defineProps<{
    title: string;
    description: string;
}>();

const { title, description } = toRefs(props);
const { disclosureTitle, disclosureContent } = useSlots();
</script>

<template>
    <div
        class="border-b border-gray-200 pb-4 transition-all"
        data-intro="Welcome to StudyMate!<br/><br/>I'll guide you through the site. This dynamic section displays helpful details for each page. The title and content change as you browse, showing relevant information."
        data-step="1"
    >
        <div class="pb-4 sm:flex sm:items-center sm:justify-between">
            <div class="flex-1">
                <div class="flex items-center gap-2">
                    <h2 class="text-base font-semibold leading-7 text-gray-900">
                        {{ title }}
                    </h2>
                    <slot name="helpButton" />
                </div>
                <p class="mt-1 text-sm leading-6 text-gray-600">
                    {{ description }}
                </p>
            </div>
            <div class="mt-3 flex items-center sm:ml-4 sm:mt-0">
                <slot />
            </div>
        </div>

        <Disclosure v-slot="{ open }" v-if="disclosureTitle">
            <DisclosureButton
                class="flex w-full justify-between rounded-lg bg-indigo-100 px-4 py-2 text-left text-sm font-medium text-indigo-900 transition-all hover:bg-indigo-200 focus:outline-none focus-visible:ring focus-visible:ring-indigo-500/75"
            >
                <span>
                    <slot name="disclosureTitle" />
                </span>
                <ChevronUpIcon
                    v-if="disclosureContent"
                    :class="open ? 'rotate-180 transform' : ''"
                    class="h-5 w-5 text-purple-500"
                />
            </DisclosureButton>

            <transition
                enter-active-class="transition duration-200 ease-in-out"
                enter-from-class="transform -translate-y-5 opacity-0"
                enter-to-class="transform translate-y-0 opacity-100"
                leave-active-class="transition duration-200 ease-in-out"
                leave-from-class="transform translate-y-0 opacity-100"
                leave-to-class="transform -translate-y-5 opacity-0"
            >
                <DisclosurePanel
                    class="px-4 pb-2 pt-4 text-sm text-gray-500"
                    v-if="disclosureContent"
                >
                    <slot name="disclosureContent" />
                </DisclosurePanel>
            </transition>
        </Disclosure>
    </div>
</template>
