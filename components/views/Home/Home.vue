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
        <home-offers 
        v-bind:text="text"
         ref="OffersComponent"></home-offers>
      </div>
    </transition>

    <transition name="flash" appear>
      <div>
        <home-content
                v-for="(block, index) in content" :block="block"
                :class="index % 2 == 1 ? 'left-side' : 'right-side'">
        </home-content>
      </div>
    </transition>
  </div>

</template>
<script type="text/babel">
import { mapGetters } from "vuex";
import Slider from "./HomeSlider.vue";
import loader from "../../loader.vue";
import HomeOffers from "./HomeOffers.vue";
import HomeContent from "./HomeContent.vue";
import {
  scrollToElement,
  boundedChunksWithMutations
} from "../../../js/helper";

export default {
  name: "Home",
  props: ["defines"],
  components: {
    slider: Slider,
    loader: loader,
    HomeOffers,
    HomeContent
  },
  head: {
    // To use "this" in the component, it is necessary to return the object through a function
    title: function() {
      return {
        inner: this.$route.meta.site_title,
        separator: " "
      };
    }
  },
  computed: {
    ...mapGetters({
      slides: "getHomeSlides",
      offers: "getHomeOffers",
      content: "getHomeContent",
      text: "getHomeText"
    })
  },
  data() {
    return {
      slidesArrived: "loader",
      showRestContent: false
    };
  },
  created() {
    let ID = this.defines.homePage;
    this.$store.dispatch("fetchDataPage", {
      ID,
      chunks: boundedChunksWithMutations(ID)
    });
    this.$store.dispatch({
      ID,
      type: "fetchContentSite",
      setterType: "setHomeText"
    });
  },
  watch: {
    slidesArrived: {
      handler: function(val, oldVal) {
        if (val === "slider") {
          setTimeout(() => {
            this.showRestContent = true;
          }, 1000);
        }
      },
      deep: true
    }
  }
};
</script>
