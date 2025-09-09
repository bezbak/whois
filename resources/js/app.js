import { createApp } from 'vue'
import Register from './pages/Register.vue'
import Login from './pages/Login.vue'
import DomainChecker from './pages/DomainChecker.vue'

if (document.getElementById('register-app')) {
  createApp(Register).mount('#register-app')
}
if (document.getElementById('login-app')) {
  createApp(Login).mount('#login-app')
}
if (document.getElementById('domain-app')) {
  createApp(DomainChecker).mount('#domain-app') 
}
