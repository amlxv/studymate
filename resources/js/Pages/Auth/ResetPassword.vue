<script lang="ts" setup>
import queryString from "query-string";
import { router, useForm } from "@inertiajs/vue3";

const { pathname, search } = new URL(window.location.toString());
const token = pathname.split("/").reverse()[0];
const params = queryString.parse(search);

const resetPasswordForm = useForm({
    token: token,
    email: params.email,
    password: null,
    password_confirmation: null,
});
</script>

<template>
    <div>Reset password for: {{ params.email }}</div>

    <form
        @submit.prevent="
            resetPasswordForm.post($route('password.update', { token: token }))
        "
        class="grid gap-2"
    >
        <div>
            <label for="password" class="mr-2">Password:</label>
            <input
                id="password"
                v-model="resetPasswordForm.password"
                type="password"
            />
        </div>

        <div>
            <label for="password_confirmation" class="mr-2"
                >Confirm Password:</label
            >
            <input
                id="password_confirmation"
                v-model="resetPasswordForm.password_confirmation"
                type="password"
            />
            <p class="text-red-500" v-if="resetPasswordForm.errors.password">
                {{ resetPasswordForm.errors.password }}
            </p>
        </div>

        <p class="text-red-500" v-if="resetPasswordForm.errors.email">
            {{ resetPasswordForm.errors.email }}
        </p>

        <div>
            <button
                class="mr-2 border border-gray-700 p-1"
                @click="router.visit('/')"
                type="button"
            >
                Cancel
            </button>
            <button type="submit" class="border border-gray-700 p-1">
                Submit
            </button>
        </div>
    </form>
</template>
