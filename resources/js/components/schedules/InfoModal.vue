<script setup lang="ts">
import { defineProps, toRefs } from "vue";
import { Link } from "@inertiajs/vue3";
import {
    Dialog,
    DialogPanel,
    DialogTitle,
    TransitionChild,
    TransitionRoot,
} from "@headlessui/vue";
import { XMarkIcon } from "@heroicons/vue/24/outline";
import { ClockIcon } from "@heroicons/vue/24/solid";

const props = defineProps<{
    open: boolean;
    event?: unknown;
}>();

const { open, event } = toRefs(props);
</script>

<template>
    <TransitionRoot as="template" :show="open">
        <Dialog
            as="div"
            class="relative z-50 hidden md:block"
            @close="$emit('close')"
        >
            <TransitionChild
                as="template"
                enter="ease-out duration-300"
                enter-from="opacity-0"
                enter-to="opacity-100"
                leave="ease-in duration-200"
                leave-from="opacity-100"
                leave-to="opacity-0"
            >
                <div
                    class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"
                />
            </TransitionChild>

            <div class="fixed inset-0 z-10 overflow-y-auto">
                <div
                    class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0"
                >
                    <TransitionChild
                        as="template"
                        enter="ease-out duration-300"
                        enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                        enter-to="opacity-100 translate-y-0 sm:scale-100"
                        leave="ease-in duration-200"
                        leave-from="opacity-100 translate-y-0 sm:scale-100"
                        leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    >
                        <DialogPanel
                            class="relative transform overflow-hidden rounded-lg bg-white px-4 pb-4 pt-5 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg sm:p-6"
                        >
                            <div
                                class="absolute right-0 top-0 hidden pr-4 pt-4 sm:block"
                            >
                                <button
                                    type="button"
                                    class="rounded-md bg-white text-gray-400 transition-all hover:text-gray-500 hover:ring-2 hover:ring-indigo-500 hover:ring-offset-2 focus:outline-none"
                                    @click="$emit('close')"
                                >
                                    <span class="sr-only">Close</span>
                                    <XMarkIcon
                                        class="h-6 w-6"
                                        aria-hidden="true"
                                    />
                                </button>
                            </div>
                            <div class="sm:flex sm:items-start">
                                <div
                                    class="mt-4 text-center sm:ml-4 sm:mt-0 sm:text-left"
                                >
                                    <DialogTitle
                                        as="h3"
                                        class="text-base font-semibold leading-6 text-gray-900"
                                    >
                                        {{ event?.["title"] }}
                                    </DialogTitle>

                                    <p class="mt-1 block text-xs text-gray-500">
                                        <ClockIcon
                                            class="inline h-4 w-4"
                                        ></ClockIcon>
                                        {{
                                            event?.["time_start"]
                                                .toString()
                                                .slice(0, 5)
                                        }}
                                    </p>
                                    <div class="mt-4">
                                        <div
                                            class="whitespace-pre-line text-sm text-gray-500"
                                        >
                                            {{ event?.["description"] }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div
                                class="mt-5 justify-between pl-4 sm:flex sm:flex-row-reverse"
                            >
                                <div class="sm:flex sm:flex-row-reverse">
                                    <Link
                                        :href="
                                            $route(
                                                'schedule.edit',
                                                event?.['id'],
                                            )
                                        "
                                        type="button"
                                        class="mt-3 inline-flex w-full cursor-pointer justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto"
                                    >
                                        Edit
                                    </Link>
                                </div>

                                <p class="mt-4 block text-xs text-gray-400">
                                    This event will be ended at
                                    {{
                                        event?.["time_end"]
                                            .toString()
                                            .slice(0, 5)
                                    }}
                                </p>
                            </div>
                        </DialogPanel>
                    </TransitionChild>
                </div>
            </div>
        </Dialog>
    </TransitionRoot>
</template>
