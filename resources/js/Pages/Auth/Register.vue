<script setup>
import { useForm } from "@inertiajs/vue3";
import TextInput from "../Components/TextInput.vue";
const form = useForm({
    name: null,
    email: null,
    password: null,
    password_confirmation: null,
    avatar: null,
    preview: null,
});

const change = (e) => {
    form.avatar = e.target.files[0];
    form.preview = URL.createObjectURL(e.target.files[0]);
};
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
            <!-- Upload Avatar -->
            <div class="grid place-items-center">
                <div class="relative w-28 h-28 rounded-full overflow-hidden border border-slate-300">
                    <label for="avatar" class="absolute inset-0 grid content-end cursor-pointer">
                        <span class="bg-white/70 pb-2 text-center">Avatar</span>
                    </label>
                    <input type="file" @input="change" id="avatar" hidden />

                    <img class="object-cover w-28 h-28" :src="form.preview ?? 'storage/avatars/default-user.jpg'" />
                </div>

                <p class="error mt-2">{{ form.errors.avatar }}</p>
            </div>
            <!-- End Upload Avatar -->
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
