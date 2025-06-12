<script setup>
import { useForm } from "@inertiajs/vue3";
import TextInput from "../Components/TextInput.vue";
const form = useForm({
    name: null,
    email: null,
    password: null,
    password_confirmation: null,
});

const submit = () => {
    form.post(route("register"), {
        preserveScroll: true,
        onSuccess: () => {
            form.reset();
        },
        onError: () => {
            form.reset("password", "password_confirmation");
        },
    });
};
</script>

<template>

    <Head :title="` | Register`" />
    <h1 class="title">Register Page</h1>
    <div class="w-2/4 mx-auto">
        <form @submit.prevent="submit">
            <TextInput label="name" v-model="form.name" :message="form.errors.name" />
            <TextInput label="email" v-model="form.email" type="email" :message="form.errors.email" />
            <TextInput label="password" v-model="form.password" type="password" :message="form.errors.password" />
            <TextInput label="password confirmation" v-model="form.password_confirmation" type="password"
                :message="form.errors.password_confirmation" />
            <div>
                <p class="text-slate-600 mb-2">
                    Already have an account? <a :href="route('login')" class="text-link">Login</a>
                </p>
                <button class="primary-btn" :disabled="form.processing">
                    {{ form.processing ? "Registering..." : "Register" }}
                </button>
            </div>
        </form>
    </div>
</template>
