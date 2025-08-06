<template>
    <MainLayout>
        <form @submit.prevent="login">
            <div class="mx-auto w-1/2">
                <div class="mt-4">
                    <label for="email" class="label">E-mail</label>
                    <input
                        type="text"
                        name="email"
                        id="email"
                        class="input"
                        v-model="form.email"
                    />
                    <div class="input-error" v-if="form.errors.email">{{ form.errors.email }}</div>
                </div>
                <div class="mt-4">
                    <label for="password" class="label">Password</label>
                    <input
                        type="password"
                        name="password"
                        id="password"
                        class="input"
                        v-model="form.password"
                    />
                    <div class="input-error" v-if="form.errors.password">{{ form.errors.password }}</div>
                </div>
                <div class="mt-4">
                    <button type="submit" class="btn-primary w-full">
                        Login
                    </button>
                    <div class="mt-2 text-center">
                        <Link :href="route('user-account.create')" class="text-sm text-gray-500">Need an account? Click here</Link>
                    </div>
                </div>
            </div>
        </form>
    </MainLayout>
</template>

<script setup>
import MainLayout from '@/Layouts/MainLayout.vue';
import { Link, useForm } from '@inertiajs/vue3';
const form = useForm({
    email: null,
    password: null,
});
const login = () => form.post(route('login.store'));
</script>
