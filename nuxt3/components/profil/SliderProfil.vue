<template>
    <div class="w-full max-h-[300px] py-10 overflow-hidden">
        <Swiper :modules="[SwiperAutoplay, SwiperEffectCreative]" :slides-per-view="2" :loop="true" :effect="'creative'"
            :autoplay="{
                delay: 8000,
                disableOnInteraction: true,
            }" :creative-effect="{
    prev: {
        shadow: false,
        translate: ['-20%', 0, -1],
    },
    next: {
        translate: ['100%', 0, 0],
    },
}">
            <SwiperSlide>
                <CardProfil />
            </SwiperSlide>
            <SwiperSlide>
                <CardProfil />
            </SwiperSlide>
            <SwiperSlide>
                <CardProfil />
            </SwiperSlide>
            <SwiperSlide>
                <CardProfil />
            </SwiperSlide>
        </Swiper>
    </div>
</template>