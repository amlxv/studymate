<script setup lang="ts">
import { useForm, router } from "@inertiajs/vue3";

const registerForm = useForm({
    name: null,
    email: null,
    password: null,
    password_confirmation: null,
});
</script>

<template>
    <form
        @submit.prevent="registerForm.post($route('register'))"
        class="grid gap-2"
    >
        <div class="text-2xl">Register</div>
        <div>
            <label for="name" class="mr-2">Name:</label>
            <input id="name" v-model="registerForm.name" />
            <p class="text-red-500" v-if="registerForm.errors.name">
                {{ registerForm.errors.name }}
            </p>
        </div>

        <div>
            <label for="email" class="mr-2">Email:</label>
            <input id="email" v-model="registerForm.email" />
            <p class="text-red-500" v-if="registerForm.errors.email">
                {{ registerForm.errors.email }}
            </p>
        </div>

        <div>
            <label for="password" class="mr-2">Password:</label>
            <input
                id="password"
                v-model="registerForm.password"
                type="password"
            />
        </div>

        <div>
            <label for="password_confirmation" class="mr-2"
                >Confirm Password:</label
            >
            <input
                id="password_confirmation"
                v-model="registerForm.password_confirmation"
                type="password"
            />
            <p class="text-red-500" v-if="registerForm.errors.password">
                {{ registerForm.errors.password }}
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
        </div>
    </form>
</template>
