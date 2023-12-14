<template>
  <div class="flex justify-center">
    <div class="w-full sm:w-1/2 px-3">
      <ProfilSection v-if="user" :user="user" />
      <ProfilToComplete />
    </div>
    <div class="hidden sm:block w-1/5">
      <ProfilSection v-if="user" :user="user" />
    </div>
  </div>
</template>
  
<script setup lang="ts">
import { ref, onMounted } from 'vue'
import axios from 'axios'
import { useRoute } from 'vue-router'
import ProfilSection from '~/components/profil/ProfilSection.vue'
import ProfilToComplete from '~/components/profil/ProfilToComplete.vue'

const route = useRoute()
const user = ref(null)

onMounted(async () => {
  const id = route.params.id
  const token = 'Bearer ' + localStorage.getItem('userToken');
  const response = await axios.get(`https://127.0.0.1:8000/api/users/${id}`, {
    headers: { Authorization: token }
  })
  user.value = response.data
})

</script>
