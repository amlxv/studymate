<!-- Note: Recommended icon size is 24px -->

<script setup lang="ts">
import { defineProps } from "vue";
import _ from "lodash";

import type {} from "vite/types/importMeta";
import type {} from "vite/types/importGlob";

const props = defineProps<{
    name: string;
}>();

const icons = import.meta.glob("../../../icons/*.svg", { eager: true });
const iconPattern = /^(..\/){3}icons\/(.+)\.svg$/;

const iconList = _.map(_.keys(icons), (m) => {
    return {
        name: m.toString().replace(iconPattern, "$2"),
        path: m,
    };
});

const getIconComponent = (name: string = props.name) => {
    return _.find(iconList, (icon) => icon.name === name)?.path;
};
</script>

<template>
    <component
        v-if="!!getIconComponent()"
        :is="icons[getIconComponent()]"
        class="inline-block h-6 w-6 fill-current"
    />
</template>
