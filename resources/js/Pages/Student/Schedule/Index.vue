<script setup lang="ts">
import Layout from "@/layouts/Layout.vue";
import { Link } from "@inertiajs/vue3";
</script>

<template>
    <Layout>
        <div class="flex justify-between">
            <h1 class="mb-6 text-xl font-bold">Your schedule</h1>
            <Link
                :href="$route('schedule.create')"
                class="text-sm text-blue-500"
            >
                New schedule
            </Link>
        </div>

        <div>No items found. Please add a schedule</div>
    </Layout>
</template>
