<template>
  <header>
    <div class="flex justify-between items-center bg-white z-10 p-3">
      <div class="ml-2 flex items-center">
        <NuxtLink to="/">
          <img src="../public/uploads/logo.png" alt="Futur Logo" class="w-12">
        </NuxtLink>
      </div>

      <div class="hidden md:flex bg-white rounded-3xl border border-gray p-3 h-10">
        <form action="/search" method="GET" class="flex items-center">
          <input type="text" class="mr-2">
          <button type="submit" class="bg-transparent border-none p-0">
            <img src="../assets/svg/Vector.svg" alt="Search" class="w-[16px] h-[16px]">
          </button>
        </form>
      </div>
      <div class="flex items-center">
      <button type="submit" class="md:hidden bg-transparent border-none mr-2">
        <img src="../assets/svg/Vector.svg" alt="Search" class="w-8 h-8">
      </button>
      <div class="flex items-center">
        <details v-if="isLoggedIn" class="relative">
          <summary class="list-none">
            <img src="../public/uploads/portrait.png" alt="profil picture" class="w-12 rounded-full cursor-pointer">
          </summary>
          <ul class="absolute -left-[100px] p-2 mt-2 bg-white rounded-lg shadow-md z-10">
            <li>
              <NuxtLink to="/profils/123" class="cursor-pointer text-gray-400">Mon profil</NuxtLink>
              <p class="cursor-pointer text-gray-400" @click="logout">Se déconnecter</p>
            </li>
          </ul>
        </details>
        <div v-else>
          <NuxtLink class="button-primary" to="/login">Se connecter</NuxtLink>
          <NuxtLink class="button-secondary ml-2" to="/register">Créer un compte</NuxtLink>
        </div>
      </div>
    </div>
    </div>
  </header>
</template>

<script setup lang="ts">
import { watchEffect } from 'vue'
import { useUserStore } from '~/store/user'
import { useRouter } from 'vue-router'

const userStore = useUserStore()
const router = useRouter()
let isLoggedIn = ref(false)

watchEffect(() => {
  isLoggedIn.value = userStore.isLoggedIn
})

function logout() {
  userStore.logout()
  alert('Vous avez été déconnecté.')
  router.push('/login')
}
</script>