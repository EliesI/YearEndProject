<template>
  <div v-if="!user.isLoggedIn">
    <Hero />
    <Images />
    <Image />
    <ImageForm />
  </div>

  <div v-else>
    <div class="flex justify-center">
      <div class="hidden sm:block w-full sm:w-[15%]">
        <ProfilSection v-if="user" :user="user" />
      </div>
      <section id="feed" class="w-full sm:w-[35%] px-3">
        <ProfilSection v-if="user" :user="user" />
        <ProfilSliderProfil/>
        <ProjectSliderProject/>
      </section>
      <div class="hidden sm:block w-[20%]">
        <ProfilSection v-if="user" :user="user" />
      </div>
    </div>
  </div>
</template>

<script>
import Hero from '~/components/section/HeroSection.vue';
import Images from '~/components/section/ImagesSection.vue';
import Image from '~/components/section/ImageSection.vue';
import ImageForm from '~/components/section/ImageFormSection.vue';
import { useUserStore } from '~/store/user'

export default {
  components: {
    Hero,
    Images,
    Image,
    ImageForm
  },
  setup() {
    const user = useUserStore();
    return { user };
  },
}
</script>