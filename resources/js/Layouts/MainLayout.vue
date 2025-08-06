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

// const APP_URL = "http://localhost/Course_udemy/larazillow11/public";
</script>
