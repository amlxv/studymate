<script setup lang="ts">
import { ref, watch } from "vue";
import { useForm, usePage } from "@inertiajs/vue3";
import { useElementSize } from "@vueuse/core";
import Layout from "@/layouts/Layout.vue";
import SubmitButton from "@/composables/buttons/SubmitButton.vue";
import SectionHeading from "@/composables/heading/SectionHeading.vue";
import CommonButton from "@/composables/buttons/CommonButton.vue";
import InputText from "@/composables/forms/InputText.vue";
import TextArea from "@/composables/forms/TextArea.vue";
import { AtSymbolIcon, ChevronUpIcon } from "@heroicons/vue/20/solid";
import { ClockIcon } from "@heroicons/vue/24/outline";
import BaseIcon from "@/composables/BaseIcon.vue";
import SocialButton from "@/composables/buttons/SocialButton.vue";
import { Disclosure, DisclosureButton, DisclosurePanel } from "@headlessui/vue";

const page = usePage();
const { origin } = new URL(window.location.toString());

const isEditingMode = ref(false);
const socialButton = ref(null);
const { width: socialButtonWidth } = useElementSize(socialButton);

const form = useForm({
    _method: "put",
    username: page.props?.settings?.username,
    time_before: page.props?.settings?.time_before,
    custom_message: page.props?.settings?.custom_message,
});

const handleOnClickOnDisabledInputEvent = (id) => {
    form.clearErrors();
    form.setError(
        id,
        'Please toggle "Enable Edit" to change this information.',
    );
};

watch(isEditingMode, () => {
    form.clearErrors();
});
</script>

<template>
    <Layout>
        <form
            @submit.prevent="
                form.post(
                    route('setting.update', $page.props?.auth?.user?.id),
                    {
                        preserveScroll: true,
                        onSuccess: () => {
                            isEditingMode = false;
                        },
                    },
                )
            "
        >
            <div class="space-y-12">
                <SectionHeading
                    title="Settings"
                    description="The section where you can see all settings you can modify."
                >
                    <CommonButton
                        type="warning"
                        :label="
                            isEditingMode ? 'Disable Editing' : 'Enable Edit'
                        "
                        @click="isEditingMode = !isEditingMode"
                        :class="
                            isEditingMode
                                ? 'bg-red-600 text-white hover:bg-red-700 hover:text-white'
                                : null
                        "
                    />
                </SectionHeading>

                <div class="space-y-12">
                    <div
                        class="pb-12"
                        :class="{
                            'border-b border-gray-900/10': isEditingMode,
                        }"
                    >
                        <div
                            class="mt-1 grid grid-cols-1 justify-center gap-x-6 gap-y-8 sm:grid-cols-6"
                        >
                            <div class="sm:col-span-3">
                                <InputText
                                    id="username"
                                    :model="form"
                                    :error="form?.errors?.username"
                                    label="Telegram Username"
                                    type="text"
                                    placeholder="e.g., amlxv"
                                    :icon="AtSymbolIcon"
                                    disabled="disabled"
                                    class-list="bg-gray-200"
                                />

                                <p
                                    class="mt-2 text-sm text-gray-600 transition-all duration-300"
                                >
                                    The account cannot be manually changed.
                                    Click the Telegram button to re-link the
                                    account to Telegram.
                                </p>
                            </div>

                            <div
                                class="relative mt-5 -translate-x-1/4 opacity-0 transition-all sm:col-span-3"
                                :class="{
                                    'translate-x-0 opacity-100': isEditingMode,
                                    'pointer-events-none': !isEditingMode,
                                }"
                                :style="{ width: socialButtonWidth + 'px' }"
                            >
                                <div class="absolute top-3" ref="socialButton">
                                    <SocialButton
                                        id="telegram"
                                        href="#"
                                        class-list="text-[#29b6f6] border-[#29b6f6]"
                                    >
                                        <template v-slot:icon>
                                            <BaseIcon name="telegram" />
                                        </template>
                                    </SocialButton>
                                </div>

                                <div
                                    class="absolute top-3 overflow-hidden opacity-0"
                                    :style="{ width: socialButtonWidth + 'px' }"
                                >
                                    <component
                                        is="script"
                                        async
                                        src="https://telegram.org/js/telegram-widget.js?22"
                                        data-telegram-login="studymate_amlxv_bot"
                                        data-size="large"
                                        data-radius="14"
                                        data-userpic="false"
                                        :data-auth-url="`${origin}/setting/telegram/callback`"
                                        data-request-access="write"
                                    ></component>
                                </div>
                            </div>

                            <div class="sm:col-span-3 sm:col-start-1">
                                <InputText
                                    id="time_before"
                                    :model="form"
                                    :error="form?.errors?.time_before"
                                    label="Time Before"
                                    type="number"
                                    placeholder="e.g., 10"
                                    min="10"
                                    max="60"
                                    :icon="ClockIcon"
                                    :disabled="!isEditingMode"
                                    :handle-click-on-disabled="
                                        (id) =>
                                            handleOnClickOnDisabledInputEvent(
                                                id,
                                            )
                                    "
                                />

                                <p
                                    class="mt-2 text-sm text-gray-600 transition-all duration-300"
                                >
                                    In minutes, set how long the notification
                                    should be sent ahead of time.
                                </p>
                            </div>

                            <div class="sm:col-span-3 sm:col-start-1">
                                <TextArea
                                    id="custom_message"
                                    :model="form"
                                    label="Custom Message"
                                    description="Customize how the notification will looks like."
                                    placeholder="e.g., Hi, there! {title} will start soon."
                                    :error="form?.errors?.custom_message"
                                    :disabled="!isEditingMode"
                                    :handle-click-on-disabled="
                                        (id) =>
                                            handleOnClickOnDisabledInputEvent(
                                                id,
                                            )
                                    "
                                />

                                <div class="mt-4" v-if="isEditingMode">
                                    <Disclosure v-slot="{ open }">
                                        <DisclosureButton
                                            class="flex w-full justify-between rounded-lg bg-indigo-100 px-4 py-2 text-left text-sm font-medium text-indigo-900 hover:bg-indigo-200 focus:outline-none focus-visible:ring focus-visible:ring-indigo-500/75"
                                        >
                                            <span
                                                >How to use the schedule
                                                information in custom
                                                message?</span
                                            >
                                            <ChevronUpIcon
                                                :class="
                                                    open
                                                        ? 'rotate-180 transform'
                                                        : ''
                                                "
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
                                            >
                                                There are several keywords with
                                                a unique pattern that have been
                                                reserved for mentioning schedule
                                                information. When you use those
                                                keywords, they will be replaced
                                                with the actual schedule details
                                                before the reminder is sent to
                                                you.

                                                <ul class="ml-4 mt-4 list-disc">
                                                    <li class="mb-2.5">
                                                        <span
                                                            class="rounded bg-gray-200 p-1 text-gray-700"
                                                            >{title}</span
                                                        >
                                                        — The schedule title
                                                        that has been set.
                                                    </li>
                                                    <li class="mb-2.5">
                                                        <span
                                                            class="rounded bg-gray-200 p-1 text-gray-700"
                                                            >{description}</span
                                                        >
                                                        — The schedule
                                                        description that has
                                                        been set.
                                                    </li>
                                                    <li class="mb-2.5">
                                                        <span
                                                            class="rounded bg-gray-200 p-1 text-gray-700"
                                                            >{day}</span
                                                        >
                                                        — If exist, the schedule
                                                        day that has been set.
                                                    </li>
                                                    <li class="mb-2.5">
                                                        <span
                                                            class="rounded bg-gray-200 p-1 text-gray-700"
                                                            >{date}</span
                                                        >
                                                        — If exist, the schedule
                                                        date that has been set.
                                                    </li>
                                                    <li class="mb-2.5">
                                                        <span
                                                            class="rounded bg-gray-200 p-1 text-gray-700"
                                                            >{time_start}</span
                                                        >
                                                        — The schedule start
                                                        time that has been set.
                                                    </li>
                                                    <li class="mb-2.5">
                                                        <span
                                                            class="rounded bg-gray-200 p-1 text-gray-700"
                                                            >{time_end}</span
                                                        >
                                                        — If exist, The schedule
                                                        end time that has been
                                                        set.
                                                    </li>
                                                </ul>
                                            </DisclosurePanel>
                                        </transition>
                                    </Disclosure>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div
                class="mt-6 flex items-center justify-end gap-x-6 transition-all duration-300"
                :class="{
                    'pointer-events-none -mb-6 opacity-0': !isEditingMode,
                    'opacity-100': isEditingMode,
                }"
            >
                <div>
                    <SubmitButton label="Save" />
                </div>
            </div>
        </form>
    </Layout>
</template>
