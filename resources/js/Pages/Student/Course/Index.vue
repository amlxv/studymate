<script setup lang="ts">
import { router, Link } from "@inertiajs/vue3";
</script>

<template>
    <div>Your Courses</div>

    <ul class="mt-10 border border-gray-700">
        <li>
            <Link :href="$route('course.index')">Manage Course</Link>
        </li>
    </ul>

    <hr class="mt-5" />
    <button
        class="border border-gray-700 bg-red-900 px-3 py-1.5"
        v-if="$page.props.auth.user"
        @click="router.post($route('logout'))"
        type="submit"
    >
        Logout
    </button>
</template>
