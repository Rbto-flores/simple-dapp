<script setup>
const model = defineModel({
    type: null,
    required: true,
});
defineProps({
    type: {
        type: String,
        default: "text",
    },
    label: {
        type: String,
        required: true,
    },
    value: String,
    message: String,
});
</script>

<template>
    <div class="mb-6">
        <label>{{ label }}</label>
        <input :type="type" v-model="model" :class="{ '!ring-red-500': message }" />
        <small v-if="message" class="error">{{ message }}</small>
    </div>
</template>
