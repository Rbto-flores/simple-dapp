<!-- components/OtpInput.vue -->
<script setup>
import { ref, watch, computed } from 'vue'

const props = defineProps({
  length: {
    type: Number,
    default: 6,
  },
  label: {
    type: String,
    required: false,
  },
  modelValue: {
    type: String,
    default: '',
  },
  message: {
    type: String,
    default: '',
  },
})

const emit = defineEmits(['update:modelValue'])

const digits = ref(Array(props.length).fill(''))
const inputs = ref([])

watch(() => props.modelValue, (newVal) => {
  if (newVal.length === props.length) {
    digits.value = newVal.split('')
  }
}, { immediate: true })


watch(digits, (newDigits) => {
  const code = newDigits.join('')
  emit('update:modelValue', code)
}, { deep: true })


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
</script>

<template>
  <div class="mb-6">
    <label v-if="label" class="block mb-2 text-center">{{ label }}</label>
    <div class="flex gap-2">
      <input
        v-for="(digit, i) in digits"
        :key="i"
        type="text"
        maxlength="1"
        inputmode="numeric"
        class="w-12 h-12 text-center text-2xl border rounded focus:outline-none focus:ring-2 focus:ring-indigo-500"
        v-model="digits[i]"
        @input="onInput($event, i)"
        @keydown="onBackspace($event, i)"
        ref="inputs"
      />
    </div>
    <small v-if="message" class="text-red-600 block text-center">{{ message }}</small>
  </div>
</template>
