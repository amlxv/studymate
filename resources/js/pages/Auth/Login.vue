<script setup lang="ts">
import { Link, useForm } from "@inertiajs/vue3";
import InputText from "@/composables/forms/InputText.vue";
import SubmitButton from "@/composables/buttons/SubmitButton.vue";
import InputCheckbox from "@/composables/forms/InputCheckbox.vue";
import AuthSplitScreenLayout from "@/layouts/auth/AuthSplitScreenLayout.vue";

const form = useForm({
    email: null,
    password: null,
    remember: false,
});
</script>

<template>
    <AuthSplitScreenLayout
        label="Sign in to your account"
        :callback="route('register')"
        callback-pre-message="Not a member?"
        callback-message="Sign up now"
    >
        <template v-slot:form>
            <form
                class="space-y-6"
                @submit.prevent="
                    form.post(route('login'), {
                        preserveScroll: true,
                    })
                "
            >
                <InputText
                    id="email"
                    label="Email address"
                    placeholder="e.g., studymate@amlxv.com"
                    :model="form"
                    :error="form.errors.email"
                />

                <InputText
                    id="password"
                    label="Password"
                    placeholder="********"
                    :model="form"
                    :error="form.errors.password"
                />

                <div class="flex items-center justify-between">
                    <InputCheckbox
                        id="remember"
                        :model="form"
                        label="Remember me"
                    />

                    <div class="text-sm leading-6">
                        <Link
                            :href="route('password.request')"
                            class="font-semibold text-indigo-600 hover:text-indigo-500"
                            >Forgot password?
                        </Link>
                    </div>
                </div>

                <div>
                    <SubmitButton label="Sign In" :disabled="form.processing" />
                </div>
            </form>
        </template>
    </AuthSplitScreenLayout>
</template>
