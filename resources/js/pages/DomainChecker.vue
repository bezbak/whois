<script setup>
import { ref } from 'vue'
import api from '../plugins/axios'


const raw = ref('')
const items = ref([])
const adding = ref('')
const addMsg = ref('')
const addError = ref('')

function parseDomains(input) {
  return [...new Set(
    input.split(/[\n,]+/)
      .map(s => s.trim().toLowerCase())
      .filter(Boolean)
  )]
}

async function checkAll() {
  const list = parseDomains(raw.value)
  items.value = list.map(d => ({ domain: d, status: 'pending', message:'Checking...', expires_at: null, loading: true, error: null }))

  await Promise.allSettled(items.value.map(async (row) => {
    try {
      const { data } = await api.post('/domains/check', { domain: row.domain })
      Object.assign(row, data.data, { loading: false })
    } catch (e) {
      row.loading = false
      row.status = 'error'
      row.error = e?.response?.data?.message || 'Request failed'
    }
  }))
}

async function addDomain() {
  addMsg.value = ''
  addError.value = ''
  if (!adding.value) return
  try {
    const payload = { name: adding.value }
    await api.post('/domains', payload)
    addMsg.value = 'Saved'
    const list = await api.get('/domains')
    console.log(list.data)
  } catch (e) {
    addError.value = e?.response?.data?.message || (e?.response?.data?.errors ? JSON.stringify(e.response.data.errors) : 'Error')
  }
}
</script>


<template>
  <main>
    <h1>Domain Availability Checker</h1>

    <section style="margin-bottom:16px;">
      <div>
        <strong>Instructions:</strong> Login/Register first. Then paste domains (comma or newline) and click "Check".
      </div>
      <div style="margin-top:8px;">
        <textarea v-model="raw" rows="6" style="width:100%;"></textarea>
      </div>
      <div style="margin-top:8px;">
        <button @click="checkAll">Check domains</button>
      </div>
    </section>

    <section v-if="items.length" style="margin-top:12px;">
      <h2>Results</h2>
      <div v-for="row in items" :key="row.domain" style="border:1px solid #e5e7eb; padding:10px; margin-bottom:6px; display:flex; justify-content:space-between;">
        <div>
          <div style="font-weight:600;">{{ row.domain }}</div>
          <div v-if="row.status==='taken'">Expires: {{ row.expires_at }}</div>
          <div v-if="row.status==='invalid'" style="color:#b91c1c;">Invalid domain</div>
          <div v-if="row.error" style="color:#b91c1c;">{{ row.error }}</div>
          <div v-if="row.message && !row.error">{{ row.message }}</div>
        </div>
        <div>
          <span v-if="row.loading">⏳</span>
          <span v-else-if="row.status==='available'">✅ Available</span>
          <span v-else-if="row.status==='taken'">❌ Taken</span>
          <span v-else-if="row.status==='invalid'">⚠️ Invalid</span>
        </div>
      </div>
    </section>

    <section style="margin-top:24px; border-top:1px dashed #ddd; padding-top:12px;">
      <h3>Add domain to DB</h3>
      <div style="display:flex; gap:8px;">
        <input v-model="adding" placeholder="domain.com">
        <button @click="addDomain">Add</button>
      </div>
      <div v-if="addMsg" style="color:green">{{ addMsg }}</div>
      <div v-if="addError" style="color:red">{{ addError }}</div>
    </section>
  </main>
</template>

<style scoped>
textarea { padding:8px; border-radius:8px; border:1px solid #e5e7eb; }
input { padding:8px; border-radius:8px; border:1px solid #e5e7eb; }
button { padding:8px 12px; border-radius:8px; }
</style>
