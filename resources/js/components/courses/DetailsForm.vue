<script setup lang="ts">
import { toRefs } from "vue";
import { InertiaForm } from "@inertiajs/vue3";
import InputText from "@/composables/forms/InputText.vue";
import {
    ClipboardDocumentIcon,
    AtSymbolIcon,
    UserGroupIcon,
} from "@heroicons/vue/20/solid";

type Details = {
    name: string;
    code: string;
    group: string;
};

const props = defineProps<{
    form: InertiaForm<Details>;
}>();

const { form } = toRefs(props);
</script>

<template>
    <div class="border-b border-gray-900/10 pb-12">
        <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
            <div class="sm:col-span-4">
                <InputText
                    id="name"
                    :model="form"
                    label="Name"
                    placeholder="Project"
                    :error="form?.errors?.name"
                    :icon="ClipboardDocumentIcon"
                />
            </div>

            <div class="sm:col-span-4">
                <InputText
                    id="code"
                    :model="form"
                    label="Code"
                    placeholder="CSP650"
                    :error="form?.errors?.code"
                    :icon="AtSymbolIcon"
                />
            </div>

            <div class="sm:col-span-4">
                <InputText
                    id="group"
                    :model="form"
                    label="Group"
                    placeholder="M3CS2516A"
                    :error="form?.errors?.group"
                    :icon="UserGroupIcon"
                />
            </div>
        </div>
    </div>
</template>
