<script setup lang="ts">
import { ref } from "vue";
import { useForm, usePage } from "@inertiajs/vue3";
import Layout from "@/layouts/Layout.vue";
import SubmitButton from "@/composables/buttons/SubmitButton.vue";
import SectionHeading from "@/composables/heading/SectionHeading.vue";
import CommonButton from "@/composables/buttons/CommonButton.vue";
import InputText from "@/composables/forms/InputText.vue";
import TextArea from "@/composables/forms/TextArea.vue";
import { AtSymbolIcon } from "@heroicons/vue/20/solid";
import { ClockIcon } from "@heroicons/vue/24/outline";
import BaseIcon from "@/composables/BaseIcon.vue";
import SocialButton from "@/composables/buttons/SocialButton.vue";
import { useElementSize } from "@vueuse/core";

const page = usePage();

const isEditingMode = ref(false);
const socialButton = ref(null);
const { width: socialButtonWidth } = useElementSize(socialButton);

const form = useForm({
    _method: "put",
    username: page.props?.settings?.username,
    time_before: page.props?.settings?.time_before,
    custom_message: page.props?.settings?.custom_message,
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
                                    placeholder="amlxv"
                                    :icon="AtSymbolIcon"
                                    disabled="disabled"
                                />
                            </div>

                            <div
                                class="relative mt-5 -translate-x-1/4 opacity-0 transition-all sm:col-span-3"
                                :class="{
                                    'translate-x-0 opacity-100': isEditingMode,
                                    'pointer-events-none': !isEditingMode,
                                }"
                                :style="{ width: socialButtonWidth + 'px' }"
                            >
                                <div
                                    class="absolute bottom-0"
                                    ref="socialButton"
                                >
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
                                    class="absolute bottom-0 overflow-hidden opacity-0"
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
                                        data-auth-url="http://127.0.0.1/setting/telegram/callback"
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
                                    placeholder="10"
                                    min="10"
                                    max="60"
                                    :icon="ClockIcon"
                                    :disabled="!isEditingMode"
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
                                    placeholder="Hi, [name]! [title] will be start soon."
                                    :disabled="!isEditingMode"
                                />
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
