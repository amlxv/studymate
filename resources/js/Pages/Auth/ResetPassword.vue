<script setup lang="ts">
import { useForm } from "@inertiajs/vue3";
import queryString from "query-string";

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
    <div
        class="flex min-h-full flex-1 flex-col justify-center px-6 py-12 lg:px-8"
    >
        <div class="sm:mx-auto sm:w-full sm:max-w-sm">
            <img
                class="mx-auto h-10 w-auto"
                src="https://i.imgur.com/Lgce8Ha.png"
                alt="StudyMate"
            />
            <h2
                class="mt-10 text-center text-2xl font-bold leading-9 tracking-tight text-gray-900"
            >
                Reset Password
            </h2>
        </div>

        <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
            <form
                @submit.prevent="
                    form.post($route('password.update', { token: token }))
                "
                class="space-y-6"
            >
                <div>
                    <label
                        for="password"
                        class="block text-sm font-medium leading-6 text-gray-900"
                        >New Password</label
                    >
                    <div class="mt-2">
                        <input
                            id="password"
                            v-model="form.password"
                            type="password"
                            autocomplete="password"
                            required
                            class="block w-full rounded-md border-0 py-1.5 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                        />
                    </div>
                </div>

                <div>
                    <label
                        for="password_confirmation"
                        class="block text-sm font-medium leading-6 text-gray-900"
                        >Confirm Password</label
                    >
                    <div class="mt-2">
                        <input
                            id="password_confirmation"
                            v-model="form.password_confirmation"
                            type="password"
                            autocomplete="password_confirmation"
                            required
                            class="block w-full rounded-md border-0 py-1.5 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                        />
                    </div>
                </div>

                <div>
                    <button
                        type="submit"
                        class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                    >
                        Reset
                    </button>
                </div>
            </form>

            <p class="mt-10 text-center text-sm text-gray-500">
                Need help?
                {{ " " }}
                <a
                    target="_blank"
                    href="mailto:support@amlxv.com?subject=StudyMate: Account Recovery"
                    class="font-semibold leading-6 text-indigo-600 hover:text-indigo-500"
                    >Contact us</a
                >
            </p>
        </div>
    </div>

    <!--    <div v-if="$page.props.flash.status">-->
    <!--        {{ $page.props.flash.status }}-->
    <!--    </div>-->
</template>
