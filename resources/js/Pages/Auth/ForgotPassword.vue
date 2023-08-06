<script setup lang="ts">
import { useForm, router } from "@inertiajs/vue3";

const forgotPasswordForm = useForm({
    email: null,
});
</script>

<template>
    <form
        @submit.prevent="forgotPasswordForm.post($route('password.request'))"
        class="grid gap-2"
    >
        <div class="text-2xl">Forgot Password</div>

        <div>
            <label for="email" class="mr-2">Email:</label>
            <input id="email" v-model="forgotPasswordForm.email" />
            <p class="text-red-500" v-if="forgotPasswordForm.errors.email">
                {{ forgotPasswordForm.errors.email }}
            </p>
        </div>

        <div>
            <button
                class="mr-2 border border-gray-700 p-1"
                @click="router.visit('/')"
                type="button"
            >
                Go back
            </button>
            <button type="submit" class="border border-gray-700 p-1">
                Submit
            </button>

            <p v-if="$page.props.flash.status">
                {{ $page.props.flash.status }}
            </p>
        </div>
    </form>
</template>
