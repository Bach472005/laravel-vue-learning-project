<template>
    <MainLayout>
        <form @submit.prevent="register">
            <div class="mx-auto w-1/2">
                <div class="mt-4">
                    <label for="name" class="label">Your Name</label>
                    <input
                        type="text"
                        name="name"
                        id="name"
                        class="input"
                        v-model="form.name"
                    />
                    <div class="input-error" v-if="form.errors.email">
                        {{ form.errors.name }}
                    </div>
                </div>
                <div class="mt-4">
                    <label for="email" class="label">E-mail</label>
                    <input
                        type="text"
                        name="email"
                        id="email"
                        class="input"
                        v-model="form.email"
                    />
                    <div class="input-error" v-if="form.errors.email">
                        {{ form.errors.email }}
                    </div>
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
                    <div class="input-error" v-if="form.errors.password">
                        {{ form.errors.password }}
                    </div>
                </div>
                <div class="mt-4">
                    <label for="password_confirmation" class="label"
                        >Confirm Password</label
                    >
                    <input
                        type="password"
                        name="password_confirmation"
                        id="password_confirmation"
                        class="input"
                        v-model="form.password_confirmation"
                    />
                    <div
                        class="input-error"
                        v-if="form.errors.password_confirmation"
                    >
                        {{ form.errors.password }}
                    </div>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn-primary w-full">
                        Register
                    </button>

                    <div class="mt-2 text-center">
                        <Link
                            :href="route('login')"
                            class="text-sm text-gray-500"
                            >Already have account? Click here</Link
                        >
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
    name: null,
    email: null,
    password: null,
    password_confirmation: null,
});
const register = () => form.post(route('user-account.store'));
</script>
