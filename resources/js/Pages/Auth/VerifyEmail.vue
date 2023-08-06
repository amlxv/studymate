<script setup lang="ts">
import { router } from "@inertiajs/vue3";
</script>

<template>
    <div class="text-lg">Email Verification</div>

    <div>email: {{ $page.props.auth.user.email }}</div>

    <br />

    <p>Email sent. If not receive, request new.</p>

    <button
        class="border border-gray-700"
        @click="router.post($route('verification.send'))"
    >
        Resend Email Verification
    </button>

    <div v-if="$page.props.flash.status == 'verification-link-sent'">
        A new email has been sent to your inbox.
    </div>
</template>
