<template>
    <div class=" mx-auto w-full">
        <header class="drak:bg-gray-700 w-full border-b border-gray-200 bg-white dark:border-gray-700">
            <div class="container mx-auto ">
                <nav class="flex items-center justify-between p-4">
                    <div class="text-lg font-medium">
                        <Link :href="route('listing.index')">Listings</Link>
                    </div>
                    <div class="text-xl text-indigo-600 dark:text-indigo-800">
                        <Link :href="route('listing.index')">LaraZillow</Link>
                    </div>

                    <div class="flex items-center gap-4" v-if="user">
                        <Link :href="route('notification.index')" class="text-gray-500 relative pr-2 py-2 text-lg">
                            🔔
                            <div v-if="notificationCount" class="absolute right-0 top-0 w-5 h-5 bg-red-700 dark:bg-red-400 text-white font-medium border border-white dark:border-gray-900 rounded-full text-xs text-center">
                                {{ notificationCount }}
                            </div>
                        </Link>
                        <Link class="text-sm text-gray-500" :href="route('realtor.listing.index')">
                            {{ user.name }}
                        </Link>
                        <Link :href="route('realtor.listing.create')" class="btn-primary">+ New Listing</Link>
                        <Link :href="route('login.destroy')" method="delete" class="btn btn-danger">Logout</Link>
                    </div>
                    <div v-else class="flex items-center gap-2">
                        <Link :href="route('user-account.create')">Register</Link>
                        <Link :href="route('login')">Sign-In</Link>
                    </div>
                </nav>
            </div>
        </header>

        <main class="container mx-auto w-full p-4">
            <div v-if="flashSuccess" class="success text">
                {{ flashSuccess }}
            </div>
            <slot>Default</slot>
        </main>
    </div>
</template>

<script setup>
import { computed } from "vue";
import { Link, usePage } from "@inertiajs/vue3";

const page = usePage();
const flashSuccess = computed(() => page.props.flash.success);
const user = computed(() => page.props.user);
const notificationCount = computed(
    () => Math.min(page.props.user.notificationCount, 9),
)
// const APP_URL = "http://localhost/Course_udemy/larazillow11/public";
</script>
