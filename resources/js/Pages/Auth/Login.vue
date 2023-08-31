<script setup lang="ts">
import { Link, useForm } from "@inertiajs/vue3";
import InputText from "@/components/common/forms/InputText.vue";
import SubmitButton from "@/components/common/buttons/SubmitButton.vue";
import InputCheckbox from "@/components/common/forms/InputCheckbox.vue";
import AuthSplitScreenLayout from "@/components/layouts/auth/AuthSplitScreenLayout.vue";

const form = useForm({
    email: null,
    password: null,
    remember: false,
});
</script>

<template>
    <AuthSplitScreenLayout
        label="Sign in to your account"
        :callback="$route('register')"
        callback-pre-message="Not a member?"
        callback-message="Sign up now"
        image="https://images.unsplash.com/photo-1496917756835-20cb06e75b4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1908&q=80"
    >
        <template v-slot:form>
            <form
                @submit.prevent="
                    form.post($route('login'), {
                        preserveScroll: true,
                    })
                "
                class="space-y-6"
            >
                <InputText
                    id="email"
                    label="Email address"
                    placeholder="studymate@amlxv.com"
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
                            :href="$route('password.request')"
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
