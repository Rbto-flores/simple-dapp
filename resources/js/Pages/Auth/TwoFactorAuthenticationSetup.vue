<script setup>
import axios from 'axios'
import { ref } from 'vue'
import { router } from '@inertiajs/vue3'
import TwoFactorAuthenticationCodeInput from '../Components/TwoFactorAuthenticationCodeInput.vue'

const step = ref(1)
const qrCode = ref(null)
const recoveryCodes = ref([])
const error = ref('')
const otp = ref('')

async function goToStep2() {
  error.value = ''
  try {
    await axios.post('/user/two-factor-authentication')
    const qrRes = await axios.get('/user/two-factor-qr-code')
    qrCode.value = qrRes.data.svg
    const codesRes = await axios.get('/user/two-factor-recovery-codes')
    recoveryCodes.value = codesRes.data
    step.value = 2
  } catch (err) {
    error.value = 'Error al activar 2FA'
  }
}

async function verifyCode() {
  console.log(otp.value)
  error.value = ''
  try {
    await axios.post('/user/confirmed-two-factor-authentication', { code: otp.value })
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
    <h1 class="text-2xl font-bold mb-4">Activa la autenticación en dos pasos</h1>

    <!-- Step 1: Introduction -->
    <div v-if="step === 1">
      <p class="text-center text-gray-500">
        Para continuar debes activar la autenticación en dos pasos y necesitaras una app como Google Authenticator o
        Microsoft Authenticator.<br>
        Descárgala en tu teléfono antes de continuar.
      </p>
      <button @click="goToStep2" class="btn-primary">Proceder</button>

    </div>

    <!-- Step 2: Show QR and Recovery Codes -->
    <div v-else-if="step === 2" class="w-full flex flex-col items-center">
      <div v-if="qrCode" class="my-4 flex justify-center w-full">
        <div v-html="qrCode" />
      </div>
      <h2 class="text-center text-gray-500 w-1/2">
        Anotas los siguiente Códigos de recuperación para poder acceder a tu cuenta si pierdas el acceso a tu
        dispositivo:
      </h2>
      <ul class="list-disc list-inside mt-5">
        <li v-for="code in recoveryCodes" :key="code">{{ code }}</li>
      </ul>
      <button class="btn-primary" @click="step = 3">Continuar</button>
    </div>

    <!-- Step 3: Confirm Authenticator Code -->
    <div v-else-if="step === 3">
      <div class="flex gap-2 mb-4">
        <TwoFactorAuthenticationCodeInput v-model="otp" :message="error" />
      </div>
      <button @click="verifyCode" class="btn-primary">Verificar</button>
    </div>
  </div>
</template>
