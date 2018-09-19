<template>
  <div class="banner-router-link-wrap">
    <button class="slide-content__link main-button">
      {{ slide.slide_btn_text }}
    </button>
  </div>
</template>
<script>
  import Waves from 'node-waves/dist/waves';
  import {getRouteComponentID, boundedChunksWithMutations} from '../../../js/helper'

  export default {
    name: 'HomeSliderBtn',
    props: ['slide'],
    beforeMount(){
    },
    mounted(){
      Waves.init();
      Waves.attach('.main-button');

      this.$el.addEventListener('mouseover', (e) => {
        let ID = getRouteComponentID(this.slide.slide_link).ID;
        this.$store.dispatch(
            'fetchDataPage',
            {ID, chunks: boundedChunksWithMutations(ID)}
        )
      });

      this.$el.addEventListener('click', (e) => {
        let route = getRouteComponentID(this.slide.slide_link);
        this.$router.push({name: route.name})
      });

    }
  }
</script>
