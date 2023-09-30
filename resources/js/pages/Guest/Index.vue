<script setup lang="ts">
import { Link, usePage } from "@inertiajs/vue3";

const page = usePage();
</script>

<template>
    <div class="px-10 py-3">
        <ul class="list-disc">
            <li>
                <Link :href="$route('register')">Sign Up</Link>
            </li>
            <li>
                <Link :href="$route('login')">Sign In</Link>
            </li>
            <li>
                <Link :href="$route('password.request')">Forgot Password</Link>
            </li>
        </ul>
    </div>
</template>
