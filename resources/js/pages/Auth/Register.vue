<script setup lang="ts">
import { useForm } from "@inertiajs/vue3";
import InputText from "@/composables/forms/InputText.vue";
import SubmitButton from "@/composables/buttons/SubmitButton.vue";
import AuthSplitScreenLayout from "@/layouts/auth/AuthSplitScreenLayout.vue";

const form = useForm({
    name: null,
    email: null,
    password: null,
    password_confirmation: null,
});
</script>

<template>
    <AuthSplitScreenLayout
        label="Create your account"
        :callback="route('login')"
        callback-pre-message="Already have an account?"
        callback-message="Sign in"
    >
        <template v-slot:form>
            <form
                class="space-y-6"
                @submit.prevent="
                    form.post(route('register'), { preserveScroll: true })
                "
            >
                <InputText
                    id="name"
                    :model="form"
                    placeholder="e.g., Your name"
                    :error="form.errors.name"
                />

                <InputText
                    id="email"
                    :model="form"
                    placeholder="e.g., studymate@amlxv.com"
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
