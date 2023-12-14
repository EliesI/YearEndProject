<template>
    <div class="card h-full w-full p-8">
        <h1 class="flex justify-center text-primary mb-6">
            Créer un compte</h1>
        <form @submit.prevent="register">
            <div class="mb-6">
                <label for="login" class="block text-lg font-semibold mb-2">Pseudonyme</label>
                <input v-model="login" type="text" id="login"
                    class="w-full border border-gray-300 rounded-md py-2 px-4 focus:outline-none focus:ring-2 focus:ring-pastel-blue" />
            </div>
            <div class="flex gap-2">
                <div class="mb-6 w-full">
                    <label for="lastName" class="block text-lg font-semibold mb-2">Nom</label>
                    <input v-model="lastName" type="text" id="lastName"
                        class="w-full border border-gray-300 rounded-md py-2 px-4 focus:outline-none focus:ring-2 focus:ring-pastel-blue" />
                </div>
                <div class="mb-6 w-full">
                    <label for="firstName" class="block text-lg font-semibold mb-2">Prénom</label>
                    <input v-model="firstName" type="text" id="firstName"
                        class="w-full border border-gray-300 rounded-md py-2 px-4 focus:outline-none focus:ring-2 focus:ring-pastel-blue" />
                </div>
            </div>
            <div class="mb-6">
                <label for="email" class="block text-lg font-semibold mb-2">Adresse e-mail</label>
                <input v-model="email" type="email" id="email"
                    class="w-full border border-gray-300 rounded-md py-2 px-4 focus:outline-none focus:ring-2 focus:ring-pastel-blue" />
            </div>
            <div class="mb-6">
                <label for="password" class="block text-lg font-semibold mb-2">Mot de passe</label>
                <input v-model="password" type="password" id="password"
                    class="w-full border border-gray-300 rounded-md py-2 px-4 focus:outline-none focus:ring-2 focus:ring-pastel-blue" />
            </div>
            <div class="mb-6">
                <label for="confirmPassword" class="block text-lg font-semibold mb-2">Confirmer le mot de passe</label>
                <input v-model="confirmPassword" type="password" id="confirmPassword"
                    class="w-full border border-gray-300 rounded-md py-2 px-4 focus:outline-none focus:ring-2 focus:ring-pastel-blue" />
            </div>
            <div>
                <button type="submit" class="button-secondary">S'inscrire</button>
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
const router = useRouter()

const login = ref('')
const firstName = ref('')
const lastName = ref('')
const email = ref('')
const password = ref('')
const confirmPassword = ref('')

async function register() {
    if (password.value !== confirmPassword.value) {
        alert('Les mots de passe ne correspondent pas.')
        return
    }
    try {
        const response = await axios.post('https://127.0.0.1:8000/api/register', {
            login: login.value,
            firstname: firstName.value,
            lastname: lastName.value,
            email: email.value,
            password: password.value
        })
        if (response.status === 200) {
            try {
                const loginResponse = await axios.post('https://127.0.0.1:8000/api/login', {
                    username: login.value,
                    password: password.value
                })
                if (loginResponse.status === 200) {
                    userStore.login(loginResponse.data.token)
                    router.push('/')
                } else {
                }
            } catch (loginError) {
                console.error(loginError)
            }
        } else {
        }
    } catch (error) {
        console.error(error)
    }
}
</script>