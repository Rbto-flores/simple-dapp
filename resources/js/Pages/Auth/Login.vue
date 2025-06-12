<script setup>
import { useForm } from '@inertiajs/vue3';
import TextInput from '../Components/TextInput.vue';
const form = useForm({
    email: null,
    password: null,
    remember: null,
});

const submit = () => {
    form.post(route('login'), {
        onError: () => form.reset('password', 'remember'),
    });
};
</script>
<template>

    <Head title="Login" />
    <h1 class="title">Login</h1>
    <div class="w-2/4 mx-auto">
        <form @submit.prevent="submit">
            <TextInput label="email" v-model="form.email" type="email" :message="form.errors.email" />
            <TextInput label="password" v-model="form.password" type="password" :message="form.errors.password" />
            <div class="flex items-center justify-between mb-2">
                <div class="flex items-center gap-2">
                    <input type="checkbox" v-model="form.remember" id="remember" />
                    <label for="remember">Remember me</label>
                </div>
                <p class="text-slate-600">
                    Need and account? <a :href="route('register')" class="text-link">register</a>
                </p>
            </div>
            <div>

                <button class="primary-btn" :disabled="form.processing">
                    {{ form.processing ? "Login..." : "Login" }}
                </button>
            </div>
        </form>

    </div>
</template>
