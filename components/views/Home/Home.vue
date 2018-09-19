<!--suppress ALL -->
<template>
  <div id="home" class="content page__content" v-cloak>
    <section id="home-slider" class="home-slider home__slider">
      <transition name="flash" mode="out-in">
        <component
          :is="slidesArrived"
          :slides-arrived="slidesArrived = 'slider'"
          :slides="slides">
        </component>
      </transition>
    </section>
    <transition name="flash" appear>
      <div>
        <home-offers v-show="showRestContent" ref="OffersComponent"></home-offers>
      </div>
    </transition>

    <transition name="flash" appear>
      <div>
        <home-content
                v-show="showRestContent"
                v-for="(block, index) in content" :block="block"
                :class="index%2 == 1 ? 'left-side' : 'right-side'" key="index">
        </home-content>
      </div>
    </transition>
  </div>

</template>
<script type="text/babel">
  import {mapGetters} from 'vuex';
  import Slider from './HomeSlider.vue';
  import loader from '../../loader.vue';
  import HomeOffers from './HomeOffers.vue';
  import HomeContent from './HomeContent.vue';
  import {scrollToElement, boundedChunksWithMutations} from '../../../js/helper';


  export default{
    name: 'Home',
    props: ['defines'],
    components: {
      'slider': Slider,
      'loader': loader,
      HomeOffers,
      HomeContent,
    },
    head: {
      // To use "this" in the component, it is necessary to return the object through a function
      title: function () {
        return {
          inner: this.$route.meta.site_title,
          separator: ' ',
        }
      },
      meta: function () {
        return [
          {name: 'description', content: this.$route.meta.desc},
          {name: 'title', content: this.$route.meta.title}
        ]
      }
    },
    computed: {
      ...mapGetters({
        slides: 'getHomeSlides',
        offers: 'getHomeOffers',
        content: 'getHomeContent',
      })
    },
    data(){
      return {
        slidesArrived: 'loader',
        showRestContent: false,
      }
    },
    created(){
      let ID = this.defines.homePage;
      this.$store.dispatch(
          'fetchDataPage',
          {ID, chunks: boundedChunksWithMutations(ID)}
      )
    },
    watch: {
      slidesArrived: {
        handler: function (val, oldVal) {
          if (val === 'slider') {
            setTimeout(() => {
              this.showRestContent = true
            }, 1000)
          }
        },
        deep: true
      }
    }
  }
</script>
