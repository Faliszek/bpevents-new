<template>
  <section id="references" class="refs page__content">
    <page-title :title="title"></page-title>

    <div class="container">

      <div class="row content-row">
                <article v-html="text"></article>
            </div>
      <div class="row refs__row">
        <i class="arrow-prev icon-angle-left"></i>
        <div id="refs" class="clearfix refs__slider" v-show="showSlider">
          <swiper :options="swiperOption" ref="refsSwiper">
            <swiper-slide v-for="(reference, index) in refs" key="index" class="refs__slide">
              <reference-single
                :reference="reference"
                key="index"></reference-single>
            </swiper-slide>
          </swiper>

        </div>
        <i class="arrow-next icon-angle-right"></i>
      </div>

      <div class="row btn-row">
        <a class="main-button facebook-button" :href="facebookLink" target="_blank">Zobacz więcej opinii</a>
      </div>
    </div>
    <!--{{ refs }}-->
  </section>

</template>
<script>
import PageTitle from "../../page-title.vue";
import ReferenceSingle from "./ReferenceSingle.vue";
import { mapGetters } from "vuex";
import { boundedChunksWithMutations } from "../../../js/helper";
import { swiper, swiperSlide } from "vue-awesome-swiper";

export default {
  name: "References",
  props: ["defines"],
  head: {
    // To use "this" in the component, it is necessary to return the object through a function
    title: function() {
      return {
        inner: this.$route.meta.site_title,
        separator: " "
      };
    }
  },
  components: {
    PageTitle,
    ReferenceSingle
  },
  computed: {
    ...mapGetters({
      refs: "getReferencesRefs",
      facebookLink: "getReferencesFacebookLink",
      text: "getReferencesContent"
    })
  },
  data() {
    return {
      title: "Referencje naszych Klientów",
      showSlider: false,
      swiperOption: {
        mousewheelControl: true,
        observeParents: true,
        nextButton: ".arrow-next",
        prevButton: ".arrow-prev",
        speed: 500,
        loop: false,
        autoplay: 4000,
        direction: "horizontal",
        watchSlidesProgress: true,
        onInit: swiper => {
          this.showSlider = true;
        }
      },
      swiperSlides: []
    };
  },
  created() {
    let ID = this.defines.referencesPage;
    this.$store.dispatch("fetchDataPage", {
      ID,
      chunks: boundedChunksWithMutations(ID)
    });

    this.$store.dispatch({
      ID,
      type: "fetchContentSite",
      setterType: "setReferencesContent"
    });
  }
};
</script>
