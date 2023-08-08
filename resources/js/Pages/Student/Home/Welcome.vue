<script setup lang="ts">
import { router, useForm } from "@inertiajs/vue3";

const studentForm = useForm({
    id: null,
    faculty: null,
    program: null,
    campus: null,
});
</script>

<template>
    <div>Welcome to StudyMate. Complete your profile to continue.</div>

    <div>Fill in the required details as follows:</div>

    <p class="text-sm text-red-800">
        This is just for temporary. It should be a select options
    </p>

    <form @submit.prevent="studentForm.post($route('student.store'))">
        <div class="mb-2">
            <label class="mr-3" for="id">Student ID</label>
            <input type="text" id="id" v-model="studentForm.id" />
            <p class="text-sm text-red-500" v-if="$page.props.errors.id">
                {{ $page.props.errors.id }}
            </p>
        </div>
        <div class="mb-2">
            <label class="mr-3" for="campus">Campus</label>
            <input type="text" id="campus" v-model="studentForm.campus" />
            <p class="text-sm text-red-500" v-if="$page.props.errors.campus">
                {{ $page.props.errors.campus }}
            </p>
        </div>
        <div class="mb-2">
            <label class="mr-3" for="faculty">Faculty</label>
            <input type="text" id="faculty" v-model="studentForm.faculty" />
            <p class="text-sm text-red-500" v-if="$page.props.errors.faculty">
                {{ $page.props.errors.faculty }}
            </p>
        </div>
        <div class="mb-2">
            <label class="mr-3" for="program">Program</label>
            <input type="text" id="program" v-model="studentForm.program" />
            <p class="text-sm text-red-500" v-if="$page.props.errors.program">
                {{ $page.props.errors.program }}
            </p>
        </div>

        <button type="submit" class="border border-gray-700 px-3 py-1.5">
            Submit
        </button>

        <p class="text-green-500" v-if="$page.props.flash.status">
            {{ $page.props.flash.status }}
        </p>
    </form>

    <hr class="mb-10" />
    <button
        v-if="$page.props.auth.user"
        @click="router.post($route('logout'))"
        type="submit"
    >
        Logout
    </button>
</template>
