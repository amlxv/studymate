<script setup lang="ts">
import { router } from "@inertiajs/vue3";
</script>

<template>
    <div>Dashboard (Verified User)</div>

    <div>You're now logged as: {{ $page.props.auth.user.role }}</div>

    <button
        v-if="$page.props.auth.user"
        @click="router.post($route('logout'))"
        type="submit"
    >
        Logout
    </button>
</template>
