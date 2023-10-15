<script setup lang="ts">
import { defineProps } from "vue";
import { Link } from "@inertiajs/vue3";
import { Menu, MenuButton, MenuItem, MenuItems } from "@headlessui/vue";
import { ChevronDownIcon } from "@heroicons/vue/20/solid";
import { UserNavigation } from "@/types/layout";

const props = defineProps<{
    userNavigations: UserNavigation[];
}>();
</script>

<template>
    <Menu as="div" class="relative">
        <MenuButton class="-m-1.5 flex items-center p-1.5">
            <span class="sr-only">Open user menu</span>
            <img
                class="h-8 w-8 rounded-full bg-gray-50"
                src="https://avatars.githubusercontent.com/u/34534953?v=4"
                alt=""
            />
            <span class="hidden lg:flex lg:items-center">
                <span
                    class="ml-4 text-sm font-semibold leading-6 text-gray-900"
                    aria-hidden="true"
                    >{{ $page.props.auth.user.name }}</span
                >
                <ChevronDownIcon
                    class="ml-2 h-5 w-5 text-gray-400"
                    aria-hidden="true"
                />
            </span>
        </MenuButton>
        <transition
            enter-active-class="transition ease-out duration-100"
            enter-from-class="transform opacity-0 scale-95"
            enter-to-class="transform opacity-100 scale-100"
            leave-active-class="transition ease-in duration-75"
            leave-from-class="transform opacity-100 scale-100"
            leave-to-class="transform opacity-0 scale-95"
        >
            <MenuItems
                class="absolute right-0 z-10 mt-2.5 w-32 origin-top-right rounded-md bg-white py-2 shadow-lg ring-1 ring-gray-900/5 focus:outline-none"
            >
                <MenuItem
                    v-for="item in userNavigations"
                    :key="item.name"
                    v-slot="{ active }"
                >
                    <Link
                        :href="route(item.href)"
                        :class="[
                            active ? 'bg-gray-50' : '',
                            'block px-3 py-1 text-sm leading-6 text-gray-900',
                        ]"
                        >{{ item.name }}
                    </Link>
                </MenuItem>

                <Link
                    :href="route('logout')"
                    method="post"
                    type="button"
                    :as="'button'"
                    class="block px-3 py-1 text-sm leading-6 text-gray-900"
                    >Logout
                </Link>
            </MenuItems>
        </transition>
    </Menu>
</template>
