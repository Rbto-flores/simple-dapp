<script setup>
import { useForm } from '@inertiajs/vue3'

const form = useForm({
  password: ''
})

function submit() {
  form.post(route('password.confirm.store'))
}
</script>

<template>
  <div>
    <h1>Confirma tu contraseña</h1>
    <form @submit.prevent="submit">
      <input type="password" v-model="form.password" placeholder="Contraseña" />
      <button type="submit">Confirmar</button>
    </form>
  </div>
</template>
