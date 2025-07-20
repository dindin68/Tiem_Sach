<div x-data="{
        currentSlide: 0,
        slides: [
    '/storage/banner1.png',
    '/storage/banner2.png',
    '/storage/banner3.png'
],

        next() {
            this.currentSlide = (this.currentSlide + 1) % this.slides.length
        },
        prev() {
            this.currentSlide = (this.currentSlide - 1 + this.slides.length) % this.slides.length
        },
        init() {
            setInterval(() => this.next(), 5000); // Tự chuyển sau 5s
        }
    }" x-init="init" class="relative w-full h-64 sm:h-96 overflow-hidden rounded-2xl shadow-lg">
    <!-- Slides -->
    <template x-for="(slide, index) in slides" :key="index">
        <div x-show="currentSlide === index" x-transition class="absolute inset-0 w-full h-full bg-cover bg-center"
            :style="'background-image: url(' + slide + ')'"></div>
    </template>

    <!-- Buttons -->
    <button @click="prev"
        class="absolute left-3 top-1/2 -translate-y-1/2 bg-white/70 hover:bg-white text-gray-800 rounded-full p-2 shadow">
        &#8592;
    </button>
    <button @click="next"
        class="absolute right-3 top-1/2 -translate-y-1/2 bg-white/70 hover:bg-white text-gray-800 rounded-full p-2 shadow">
        &#8594;
    </button>

    <!-- Dots -->
    <div class="absolute bottom-3 left-1/2 transform -translate-x-1/2 flex space-x-2">
        <template x-for="(slide, index) in slides" :key="index">
            <div class="w-3 h-3 rounded-full" :class="currentSlide === index ? 'bg-white' : 'bg-gray-400'"></div>
        </template>
    </div>
</div>