<script setup>
import { ref } from 'vue'
import api from '../plugins/axios'
import { useRouter } from 'vue-router' // not using router, just window.location

const name = ref('')
const email = ref('')
const password = ref('')
const busy = ref(false)
const error = ref('')

async function submit() {
  busy.value = true
  error.value = ''
  try {
    const { data } = await api.post('/register', {
      name:name.value, email: email.value, password: password.value
    })
    localStorage.setItem('token', data.token)
    window.location.href = '/'
  } catch (e) {
    error.value = e?.response?.data?.message || (e?.response?.data?.errors ? JSON.stringify(e.response.data.errors) : 'Error')
  } finally {
    busy.value = false
  }
}
</script>

<template>
  <div style="max-width:480px;">
    <h1>Register</h1>
    <div style="display:grid; gap:8px;">
      <input v-model="name" placeholder="Name">
      <input v-model="email" placeholder="Email">
      <input v-model="password" type="password" placeholder="Password">
      <button @click="submit" :disabled="busy">Sign up</button>
      <div v-if="error" style="color:#b91c1c">{{ error }}</div>
    </div>
  </div>
</template>

<style scoped>
input { padding:8px; border-radius:6px; border:1px solid #e5e7eb; }
button { padding:8px 12px; border-radius:6px; }
</style>
