<script setup>
import axios from 'axios'
import { router } from '@inertiajs/vue3'
import TwoFactorAuthenticationCodeInput from '../Components/TwoFactorAuthenticationCodeInput.vue'
import { ref } from 'vue'

const otp = ref('')
const error = ref('')

async function verifyCode() {
   error.value = ''
   try {
     await axios.post('/two-factor-challenge', { code: otp.value})
     // Success! You can redirect or show a success message
     error.value = ''
     alert('Codigo confirmado correctamente')
     router.visit('/dashboard')
   } catch (err) {
    console.log(err)
     error.value = 'Código incorrecto. Intenta de nuevo.'
   }
}
</script>

<template>
    <div class="flex flex-col items-center justify-center h-[80vh]">
    <label for="code" class="mb-2">Introduce el código de 6 dígitos de tu app:</label>
    <div class="flex gap-2 mb-4">
        <TwoFactorAuthenticationCodeInput v-model="otp" :message="error"/>
    </div>
    <button @click="verifyCode" class="btn-primary">Verificar</button>
    </div>
</template>