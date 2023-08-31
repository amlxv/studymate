<script setup lang="ts">
import { useForm } from "@inertiajs/vue3";
import InputText from "@/components/common/forms/InputText.vue";
import SubmitButton from "@/components/common/buttons/SubmitButton.vue";
import AuthSplitScreenLayout from "@/components/layouts/auth/AuthSplitScreenLayout.vue";

const form = useForm({
    name: null,
    email: null,
    password: null,
    password_confirmation: null,
});
</script>

<template>
    <AuthSplitScreenLayout
        image="https://images.unsplash.com/photo-1496917756835-20cb06e75b4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1908&q=80"
        label="Create your account"
        :callback="$route('login')"
        callback-pre-message="Already have an account?"
        callback-message="Sign in"
    >
        <template v-slot:form>
            <form
                class="space-y-6"
                @submit.prevent="
                    form.post($route('register'), { preserveScroll: true })
                "
            >
                <InputText
                    id="name"
                    :model="form"
                    placeholder="Your name"
                    :error="form.errors.name"
                />

                <InputText
                    id="email"
                    :model="form"
                    placeholder="studymate@amlxv.com"
                    :error="form.errors.email"
                />

                <InputText
                    id="password"
                    :model="form"
                    placeholder="********"
                    :error="form.errors.password"
                />

                <InputText
                    id="password_confirmation"
                    :model="form"
                    placeholder="********"
                    :error="form.errors.password_confirmation"
                />

                <SubmitButton label="Sign up" :disabled="form.processing" />
            </form>
        </template>
    </AuthSplitScreenLayout>
</template>
