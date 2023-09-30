<script setup lang="ts">
import { useForm } from "@inertiajs/vue3";
import InputText from "@/composables/forms/InputText.vue";
import SubmitButton from "@/composables/buttons/SubmitButton.vue";
import AuthSimpleLayout from "@/layouts/auth/AuthSimpleLayout.vue";

const form = useForm({
    email: null,
});
</script>

<template>
    <AuthSimpleLayout label="Account Recovery">
        <template v-slot:form>
            <form
                @submit.prevent="
                    form.post($route('password.request'), {
                        preserveScroll: true,
                    })
                "
                class="space-y-6"
            >
                <InputText
                    id="email"
                    :model="form"
                    placeholder="studymate@amlxv.com"
                    :error="form.errors.email"
                />

                <SubmitButton label="Confirm" :disabled="form.processing" />
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
