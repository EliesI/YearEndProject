import { defineStore } from 'pinia'
import { ref} from 'vue'

export const useUserStore = defineStore({
  id: 'user-store',
  state: () => ({
    isLoggedIn: ref(false)
  }),
  getters: {},
  actions: {
    checkLoginStatus() {
      this.isLoggedIn = process.client ? !!localStorage.getItem('userToken') : false
    },
    login(token: string) {
      if (process.client) {
        localStorage.setItem('userToken', token)
        this.isLoggedIn = true
      }
    },
    logout() {
      if (process.client) {
        localStorage.removeItem('userToken')
        this.isLoggedIn = false
      }
    }
  }
})
