<template>

    
  <section class="offer-block">
    <div class="container">
       <div class="row">
    <h1 class="offer-block__title">Zespół profesjonalnych DJ-ów i konferansjerów</h1>
</div>
      <div class="row content-row">
                <article v-html="text"></article>
            </div>
           
</div>
    <div class="col-md-12 col-lg-4 offer"  v-for="offer in offers">
      <i :class="setIcon(offer.offer_icon)" class="z-depth-1"></i>
      <h2 class="offer__title">{{ offer.offer_title }}</h2>
      <p class="offer__content" v-html="offer.offer_content"></p>
    </div>
  </section>
             
 </template>
<script>
import { mapGetters } from "vuex";

export default {
  props: ["defines", "text"],
  data() {
    return {
      msg: "hello vue"
    };
  },

  computed: {
    ...mapGetters({
      offers: "getHomeOffers"
    })
  },

  methods: {
    setIcon(string) {
      string = "icon icon-" + string;
      return string;
    }
  }
};
</script>
