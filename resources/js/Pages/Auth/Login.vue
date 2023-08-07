<script setup lang="ts">
import { useForm, router } from "@inertiajs/vue3";

const loginForm = useForm({
    email: null,
    password: null,
});
</script>

<template>
    <form @submit.prevent="loginForm.post($route('login'))" class="grid gap-2">
        <div class="text-2xl">Login</div>

        <div>
            <label for="email" class="mr-2">Email:</label>
            <input id="email" v-model="loginForm.email" />
            <p class="text-red-500" v-if="loginForm.errors.email">
                {{ loginForm.errors.email }}
            </p>
        </div>

        <div>
            <label for="password" class="mr-2">Password:</label>
            <input id="password" v-model="loginForm.password" type="password" />
            <p class="text-red-500" v-if="loginForm.errors.password">
                {{ loginForm.errors.password }}
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

        <!--        Create component for flash message checking for the status entries      -->
        <p class="text-green-500" v-if="$page.props.flash.status">
            {{ $page.props.flash.status }}
        </p>

        <hr />

        <div>
            <a
                :href="
                    $route('social-provider.redirect', {
                        provider: 'google',
                    })
                "
                type="button"
                class="rounded border border-gray-700 px-3 py-1.5"
            >
                Sign in with Google
            </a>
        </div>
    </form>
</template>
