<template>
    <div class="card h-full w-full p-8">
        <h1 class="flex justify-center text-primary mb-6">
            Se connecter
        </h1>
        <form @submit.prevent="login">
            <div class="mb-6">
                <label for="username" class="block text-lg font-semibold mb-2">Nom d'utilisateur</label>
                <input v-model="username" type="text" id="username"
                    class="w-full border border-gray-300 rounded-md py-2 px-4 focus:outline-none focus:ring-2 focus:ring-pastel-blue" />
            </div>
            <div class="mb-6">
                <label for="password" class="block text-lg font-semibold mb-2">Mot de passe</label>
                <input v-model="password" type="password" id="password"
                    class="w-full border border-gray-300 rounded-md py-2 px-4 focus:outline-none focus:ring-2 focus:ring-pastel-blue" />
            </div>
            <div>
                <button type="submit" class="button-secondary">Se connecter</button>
            </div>
        </form>
    </div>
</template>

<script setup lang="ts">
import { ref } from 'vue'
import axios from 'axios'
import { useUserStore } from '~/store/user'
import { useRouter } from 'vue-router'

const userStore = useUserStore()
const username = ref('')
const password = ref('')
const router = useRouter()

async function login() {
    try {
        const response = await axios.post('https://127.0.0.1:8000/api/login', {
            username: username.value,
            password: password.value
        })
        if (response.status === 200) {
            userStore.login(response.data.token)
            router.push('/')
        } else {
            alert('Identifiants incorrects.')
        }
    } catch (error) {
        console.error(error)
    }
}
</script>