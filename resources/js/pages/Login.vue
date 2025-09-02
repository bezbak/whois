<script setup>
import { ref } from 'vue'
import axios from 'axios'

const email = ref('')
const password = ref('')
const busy = ref(false)
const error = ref('')

async function submit() {
  busy.value = true
  error.value = ''
  try {
    const { data } = await axios.post('/api/login', {
      email: email.value, password: password.value
    })
    localStorage.setItem('token', data.token)
    axios.defaults.headers.common['Authorization'] = `Bearer ${data.token}`
    window.location.href = '/'
  } catch (e) {
    error.value = e?.response?.data?.message || 'Login error'
  } finally {
    busy.value = false
  }
}
</script>

<template>
  <div style="max-width:480px;">
    <h1>Login</h1>
    <div style="display:grid; gap:8px;">
      <input v-model="email" placeholder="Email">
      <input v-model="password" type="password" placeholder="Password">
      <button @click="submit" :disabled="busy">Sign in</button>
      <div v-if="error" style="color:#b91c1c">{{ error }}</div>
    </div>
  </div>
</template>

<style scoped>
input { padding:8px; border-radius:6px; border:1px solid #e5e7eb; }
button { padding:8px 12px; border-radius:6px; }
</style>
