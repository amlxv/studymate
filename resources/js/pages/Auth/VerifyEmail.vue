<script setup lang="ts">
import { useForm, usePage } from "@inertiajs/vue3";
import InputText from "@/composables/forms/InputText.vue";
import SubmitButton from "@/composables/buttons/SubmitButton.vue";
import AuthSimpleLayout from "@/layouts/auth/AuthSimpleLayout.vue";

const page = usePage();

const form = useForm({
    email: page.props.auth.user.email,
});
</script>

<template>
    <AuthSimpleLayout label="Verify your email">
        <template v-slot:form>
            <form
                class="space-y-6"
                @submit.prevent="
                    form.post(route('verification.send'), {
                        preserveScroll: true,
                    })
                "
            >
                <InputText id="email" :model="form" disabled="disabled" />

                <SubmitButton label="Resend" :disabled="form.processing" />
            </form>
        </template>

        <template v-slot:details>
            If you cannot find the reset link email in your
            <a
                target="_blank"
                href="#"
                class="font-semibold leading-6 text-indigo-600 hover:text-indigo-500"
                >inbox</a
            >, it is worth checking in your spam or junk mail section.
        </template>
    </AuthSimpleLayout>
</template>
