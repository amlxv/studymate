<script setup lang="ts">
import { useForm } from "@inertiajs/vue3";
import { Link } from "@inertiajs/vue3";
import queryString from "query-string";
import InputText from "@/components/common/forms/InputText.vue";
import SubmitButton from "@/components/common/buttons/SubmitButton.vue";
import AuthSimpleLayout from "@/components/layouts/auth/AuthSimpleLayout.vue";

const { pathname, search } = new URL(window.location.toString());
const token = pathname.split("/").reverse()[0];
const params = queryString.parse(search);

const form = useForm({
    token: token,
    email: params.email,
    password: null,
    password_confirmation: null,
});
</script>

<template>
    <AuthSimpleLayout label="Reset Password">
        <template v-slot:form>
            <form
                class="space-y-6"
                @submit.prevent="
                    form.post($route('password.update', { token: token }), {
                        preserveScroll: true,
                    })
                "
            >
                <InputText
                    id="password"
                    :model="form"
                    label="New Password"
                    placeholder="********"
                    :error="form.errors.password"
                />
                <InputText
                    id="password_confirmation"
                    :model="form"
                    placeholder="********"
                    :error="form.errors.password_confirmation"
                />

                <SubmitButton label="Reset" :disabled="form.processing" />
            </form>
        </template>

        <template v-slot:details>
            Remember your password?
            {{ " " }}
            <Link
                target="_blank"
                :href="$route('login')"
                class="font-semibold leading-6 text-indigo-600 hover:text-indigo-500"
                >Sign in
            </Link>
        </template>
    </AuthSimpleLayout>
</template>
