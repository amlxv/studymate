<script setup lang="ts">
import { defineProps } from "vue";
import { toRefs } from "vue";
import { XMarkIcon } from "@heroicons/vue/24/outline";
import {
    Dialog,
    DialogPanel,
    DialogTitle,
    TransitionChild,
    TransitionRoot,
} from "@headlessui/vue";

const props = defineProps<{
    title: string;
    description: string;
    open: boolean;
    onSubmit: Function;
}>();

const { open, form, onSubmit, title, description } = toRefs(props);
</script>

<template>
    <TransitionRoot as="template" :show="open">
        <Dialog as="div" class="relative z-50" @close="$emit('close')">
            <div class="fixed inset-0" />

            <div class="fixed inset-0 overflow-hidden">
                <div class="absolute inset-0 overflow-hidden">
                    <div
                        class="pointer-events-none fixed inset-y-0 right-0 flex max-w-full pl-10 sm:pl-16"
                    >
                        <TransitionChild
                            as="template"
                            enter="transform transition ease-in-out duration-500 sm:duration-700"
                            enter-from="translate-x-full"
                            enter-to="translate-x-0"
                            leave="transform transition ease-in-out duration-500 sm:duration-700"
                            leave-from="translate-x-0"
                            leave-to="translate-x-full"
                        >
                            <DialogPanel
                                class="pointer-events-auto w-screen max-w-md"
                            >
                                <form
                                    @submit.prevent="onSubmit"
                                    class="flex h-full flex-col divide-y divide-gray-200 bg-white shadow-xl"
                                >
                                    <div class="h-0 flex-1 overflow-y-auto">
                                        <div
                                            class="bg-indigo-700 px-4 py-6 sm:px-6"
                                        >
                                            <div
                                                class="flex items-center justify-between"
                                            >
                                                <DialogTitle
                                                    class="text-base font-semibold leading-6 text-white"
                                                >
                                                    {{ title }}
                                                </DialogTitle>
                                                <div
                                                    class="ml-3 flex h-7 items-center"
                                                >
                                                    <button
                                                        type="button"
                                                        class="rounded-md bg-indigo-700 text-indigo-200 hover:text-white focus:outline-none focus:ring-2 focus:ring-white"
                                                        @click="$emit('close')"
                                                    >
                                                        <span class="sr-only"
                                                            >Close panel</span
                                                        >
                                                        <XMarkIcon
                                                            class="h-6 w-6"
                                                            aria-hidden="true"
                                                        />
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="mt-1">
                                                <p
                                                    class="text-sm text-indigo-300"
                                                >
                                                    {{ description }}
                                                </p>
                                            </div>
                                        </div>
                                        <div
                                            class="flex flex-1 flex-col justify-between"
                                        >
                                            <div
                                                class="divide-y divide-gray-200 px-4 sm:px-6"
                                            >
                                                <div
                                                    class="space-y-5 pb-5 pt-8"
                                                >
                                                    <slot />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div
                                        class="flex flex-shrink-0 justify-end px-4 py-4"
                                    >
                                        <button
                                            type="button"
                                            class="rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50"
                                            @click="$emit('close')"
                                        >
                                            Cancel
                                        </button>
                                        <button
                                            type="submit"
                                            class="ml-4 inline-flex justify-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                                        >
                                            Save
                                        </button>
                                    </div>
                                </form>
                            </DialogPanel>
                        </TransitionChild>
                    </div>
                </div>
            </div>
        </Dialog>
    </TransitionRoot>
</template>
