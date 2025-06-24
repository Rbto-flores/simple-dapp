<script setup>
import { ref } from 'vue'
import axios from 'axios'
import { router } from '@inertiajs/vue3'
const error = ref('')

const digits = ref(['', '', '', '', '', ''])
const inputs = ref([])

function onInput(e, i) {
    const val = e.target.value.replace(/\D/g, '').slice(0, 1)
    digits.value[i] = val

    if (val && i < inputs.value.length - 1) {
        inputs.value[i + 1].focus()
    }
}

function onBackspace(e, i) {
    if (e.key === 'Backspace' && !digits.value[i] && i > 0) {
        inputs.value[i - 1].focus()
    }
}

async function verifyCode() {
  error.value = ''
  try {
    await axios.post('/user/confirmed-two-factor-authentication', { code: digits.value.join('') })
    // Success! You can redirect or show a success message
    error.value = ''
    alert('¡Autenticación en dos pasos activada!')
    // Optionally, you can redirect or reset the stepper here
    router.visit('/dashboard')
  } catch (err) {
    error.value = 'Código incorrecto. Intenta de nuevo.'
  }
}
</script>

<template>
    <div class="flex flex-col items-center justify-center h-[80vh]">
    <label for="code" class="mb-2">Introduce el código de 6 dígitos de tu app:</label>
    <div class="flex gap-2 mb-4">
        <input v-for="(digit, i) in digits" :key="i" type="text" maxlength="1" inputmode="numeric"
            class="w-12 h-12 text-center text-2xl border rounded focus:outline-none focus:ring-2 focus:ring-indigo-500"
            v-model="digits[i]" @input="onInput($event, i)" @keydown="onBackspace($event, i)" ref="inputs" />
    </div>
    <button @click="verifyCode" class="btn-primary">Verificar</button>
    <div v-if="error" class="text-red-500 mt-2">{{ error }}</div>
    </div>
</template>