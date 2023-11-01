<script setup lang="ts">
import { onMounted, ref, toRaw, toRefs } from "vue";
import { UserCircleIcon } from "@heroicons/vue/24/solid";
import { InertiaForm } from "@inertiajs/vue3";
import { getImagePath } from "@/composables/etc/utils";

const props = defineProps<{
    id: string;
    label?: string;
    form: InertiaForm<{ avatar: File }>;
    error?: string;
    disabled?: boolean;
    readonly?: boolean;
    iconClass?: string;
}>();

const { id, label, form, error, disabled, readonly, iconClass } = toRefs(props);

const avatarPreviewURL = ref(null);

const setImagePreviewURL = (file) => {
    avatarPreviewURL.value = URL.createObjectURL(file);
};

onMounted(() => {
    if (form.value[id.value]) {
        avatarPreviewURL.value = toRaw(form.value[id.value]);
        avatarPreviewURL.value = getImagePath(avatarPreviewURL.value);
        form.value[id.value] = null;
    }
});
</script>

<template>
    <label class="block text-sm font-medium leading-6 text-gray-900">{{
        label ?? "Avatar"
    }}</label>
    <div class="mt-2 flex flex-col items-center gap-y-4">
        <div>
            <UserCircleIcon
                v-if="!form[id] && !avatarPreviewURL"
                class="h-12 w-12 text-gray-300"
                :class="iconClass"
                aria-hidden="true"
            />

            <img
                class="h-12 w-12 rounded-full"
                :class="iconClass"
                v-if="form[id] || avatarPreviewURL"
                :src="avatarPreviewURL"
                alt="User's avatar"
            />
        </div>

        <label
            type="button"
            :for="id"
            class="block cursor-pointer rounded-md bg-white px-2.5 py-1.5 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 transition-all duration-300 hover:bg-gray-50"
            :class="{
                '-mb-10 -translate-y-10 opacity-0': disabled,
                'opacity-100': !disabled,
            }"
        >
            Choose
        </label>

        <p v-if="error" class="text-sm text-red-600" :id="id + '-error'">
            {{ error }}
        </p>

        <input
            type="file"
            :id="id"
            class="hidden"
            @input="
                form[id] = $event.target.files[0];
                setImagePreviewURL(form[id]);
                form.clearErrors(<never>id);
            "
            v-bind:readonly="readonly"
            v-bind:disabled="disabled"
            accept="image/png,image/jpeg,image/jpg"
        />
    </div>
</template>
