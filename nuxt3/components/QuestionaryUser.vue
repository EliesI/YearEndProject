<template>
  <div class="card h-full w-full p-8">
    <form @submit.prevent="questionary">
      <Modal v-if="count === 0" @close="incrementCount">
        <h2 class="flex justify-center text-primary mb-6">
          Infos utilisateur </h2>
        <label class="label-questionnary">
          Date de naissance
        </label>
        <input v-model="birthdate" type="date" id="birthdate" class="input-questionnary" />
        <label class="label-questionnary" for="country">
          Pays
        </label>
        <select v-model="country" id="country" class="input-questionnary">
          <option v-for="country in countries" :value="country.code">
            {{ country.name }}
          </option>
        </select>
        <label class="label-questionnary">
          Adresse
        </label>
        <input v-model="address" type="text" id="address" class="input-questionnary" />
        <label class="label-questionnary">
          Ville
        </label>
        <input v-model="city" type="text" id="city" class="input-questionnary" />
        <label class="label-questionnary">
          Code postal
        </label>
        <input v-model="postal" type="text" id="postal" class="input-questionnary" />
        <label class="label-questionnary">
          Numéro de téléphone
        </label>
        <input v-model="tel" type="tel" id="tel" class="input-questionnary" />
        <div class="flex justify-end mt-3">
          <button class="button-secondary" @click="incrementCount">Suivant</button>
        </div>
      </Modal>
      <Modal v-if="count === 1" @close="incrementCount">
        <label class="label-questionnary">
          Quels sont vos compétences principales ?
        </label>
        <input v-model="skills" type="text" id="skills" class="input-questionnary" />
        <label class="label-questionnary" for="biography">
          Parle moi de toi ! 
        </label>
        <textarea v-model="biography" id="biography" class="input-questionnary" rows="4"></textarea>
        <label class="label-questionnary">
          Votre parcours professionnel
        </label>
        <input v-model="path" type="text" id="path" class="input-questionnary" />
        <label class="label-questionnary">
          Centres d'intérêts
        </label>
        <input v-model="interest" type="text" id="interest" class="input-questionnary" />
        <div class="flex justify-between mt-3">
          <button class="button-secondary" @click="decrementCount">Précédent</button>
          <button class="button-secondary" @click="incrementCount">Suivant</button>
        </div>
      </Modal>
      <Modal v-if="count === 2" @close="incrementCount">
        <div v-for="(link, index) in links" :key="index" class="mb-2">
          <label class="label-questionnary" :for="'linkTitle' + index">
            Titre du lien
          </label>
          <input v-model="link.title" :id="'linkTitle' + index" type="text" class="input-questionnary" />

          <label class="label-questionnary" :for="'linkUrl' + index">
            Lien
          </label>
          <input v-model="link.url" :id="'linkUrl' + index" type="text" class="input-questionnary" />
        </div>
        <div class="flex justify-between mb-3">
          <button class="button-delete" @click="removeLastLink" v-if="links.length > 0">Supprimer le lien</button>
          <button class="button-secondary" @click="addLink">Ajouter un lien</button>
        </div>
        <div class="flex justify-between">
          <button class="button-secondary" @click="decrementCount">Précédent</button>
        </div>
      </Modal>
    </form>
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue'

let count = ref(0)

let links = ref([])

const isValidLink = computed(() => {
  if (links.value.length === 0) return true
  const lastLink = links.value[links.value.length - 1]
  return lastLink.title !== '' && lastLink.url !== ''
})

function addLink() {
  if (isValidLink.value) {
    links.value.push({ title: '', url: '' })
  }
}

function removeLastLink() {
  links.value.pop()
}

let countries = ref([
  { name: "France", code: "FR" },
  { name: "États-Unis", code: "US" },
]);


function incrementCount() {
  console.log(count.value)
  if (count.value < 5) {
    count.value += 1
  }
}

function decrementCount() {
  if (count.value > 0) {
    count.value -= 1
  }
}
</script>