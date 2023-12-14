<template>
  <section class="flex justify-center py-10">
    <div class="card w-full sm:max-w-[1000px] h-[400px]">
      <div class="relative">
        <img src="../../public/uploads/export.png" class="object-cover w-full rounded-t-3xl h-[200px]" alt="Futur Logo">
        <div class="absolute left-6 top-24">
          <div class="w-32 h-32 border-4 border-white rounded-full overflow-hidden">
            <img src="../../public/uploads/portrait.png" class="object-cover w-full h-full" alt="Profile Picture">
          </div>
        </div>
      </div>
      <div class="p-4 mt-3">
      <h2 class="text-xl font-bold">{{ user.firstname }} {{ user.lastname }}</h2>
      <p>Email: {{ user.email }}</p>
    </div>
    </div>
  </section>
</template>

<script setup lang="ts">
const props = defineProps({
  user: Object
})
</script>
