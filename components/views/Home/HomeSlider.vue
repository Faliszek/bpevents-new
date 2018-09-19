<template>
  <div id="slider" :class="{ 'unvisible' : !sliderLoaded }">
    <div id="progress-bar" class="progress-bar"></div>
    <swiper :options="swiperOption" ref="mySwiper">
      <swiper-slide v-for="(slide, index) in slides" key="index" class="home-slide">
        <!--<div class="slide-img img-responsive" :style="{ backgroundImage: 'url(' + slide.slide_img.url + ')' }" ></div>-->
        <div class="slide-img img-responsive"  :style="{ 'background-image': 'url(' + slide.slide_img.url + ')' }"/>
        <div class="mask"></div>
        <div class="slide-content">
          <h1 class="slide-content__title page__title">{{ slide.slide_title }}</h1>
          <p class="slide-content__text" v-html="slide.slide_text"></p>
          <home-slider-btn key="index" :slide="slide"></home-slider-btn>
        </div>
      </swiper-slide>
    </swiper>
    <i class="arrow-prev icon-angle-left"></i>
    <i class="arrow-next icon-angle-right"></i>
    <div id="main-arrow-down" class="arrow-wrap">
      <i class="icon-angle-down"></i>
    </div>
  </div>
</template>
<script type="text/babel">
  import {mapGetters} from 'vuex';
  import {swiper, swiperSlide} from 'vue-awesome-swiper'
  import HomeSliderBtn  from './HomeSliderBtn.vue';
  import {scrollToElement} from '../../../js/helper';


  export default{
    name: 'slider',
    props: ['slides', 'slidesArrived'],
    components: {
      swiper,
      swiperSlide,
      HomeSliderBtn
    },
    data() {
      return {
        swiperOption: {
          mousewheelControl: true,
          observeParents: true,
          nextButton: '.arrow-next',
          prevButton: '.arrow-prev',
          speed: 500,
          loop: false,
          autoplay: 4000,
          direction: 'horizontal',
          watchSlidesProgress: true,
        },
        swiperSlides: [],
        windowH: Math.max(document.documentElement.clientHeight, window.innerHeight || 0) + 'px',
        sliderLoaded: false,
      }
    },
    created(){
      this.setSlider();
    },
    updated(){
      this.setSlider();
    },
    mounted() {
      this.attachArrowEvent();
      this.$el.style.height = this.windowH;
    },
    methods: {
      setSlider(){
        this.swiperSlides = this.slides;
        this.$emit('slides-arrived');
        setTimeout(() => {
          this.sliderLoaded = true
        }, 500)
      },
      attachArrowEvent(){
        document.getElementById('main-arrow-down').addEventListener('click', (e) => {
          let el = document.querySelector('.offer-block');
          scrollToElement(el, 500)
        })
      }
    }
  }
</script>
