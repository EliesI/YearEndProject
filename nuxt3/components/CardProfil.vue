<template>
    <div class="card max-w-[500px] max-h-[400px]">
      <div class="relative">
        <img src="../public/uploads/export.png" class="object-cover w-full rounded-t-3xl h-[200px]" alt="Futur Logo">
        <div class="absolute inset-0 flex justify-center mt-28">
          <div class="w-32 h-32 border-4 border-white rounded-full overflow-hidden">
            <img src="../public/uploads/portrait.png" class="object-cover w-full h-full" alt="Profile Picture">
          </div>
        </div>
      </div>
      <div class="p-4">
        <p>Page du profil ID: {{ $route.params.id }}</p>
      </div>
    </div>
</template>  