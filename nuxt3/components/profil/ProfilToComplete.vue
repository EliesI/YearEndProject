<template>
    <section class="text-center py-10 px-3">
      <h1 class="text-4xl font-bold mb-4">Complétez votre profil</h1>
      <h2 class="text-xl text-gray-600 mb-8">Répondez à notre questionnaire court pour enrichir votre profil</h2>
      <button class="button-primary" @click="showQuestionnaire = true; count.value = 0">Remplir le questionnaire</button>
    </section>
    <div v-if="showQuestionnaire">
      <QuestionaryUser />
    </div>
  </template>
  
  <script>
  export default {
    data() {
      return {
        showQuestionnaire: false,
      }
    },
  }
  </script>
  