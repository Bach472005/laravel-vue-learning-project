<template>
    <MainLayout>
        <div>
            You need be verified first to see this page!
        </div>
        <div>
            <Link 
                :href="route('verification.send')" 
                method="post" 
                as="button" 
                class="text-indigo-600 dark:text-indigo-400"
            >
                Resend verification email
            </Link>
        </div>
    </MainLayout>
</template>

<script setup>
import MainLayout from '@/Layouts/MainLayout.vue';
import { Link } from '@inertiajs/vue3';
</script>