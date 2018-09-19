<template>
  <section id="recommend" class="content page__content">
    <div class="container">
      <div class="row">
        <page-title :title="title"></page-title>
        <div class="recommendation__wrap">
          <single-recommend
            v-for="(rec, index) in recommendations"
            :key="index"
            :recommendation="rec">
          </single-recommend>
        </div>
      </div>
    </div>
    </div>
  </section>
</template>
<script>
  import PageTitle from '../../page-title.vue';
  import SingleRecommend from './RecommendSingle.vue';
  import {mapGetters} from 'vuex';

  export default{
    name: 'Recommend',
    props: ['defines'],
    components: {
      PageTitle,
      SingleRecommend
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
        recommendations: 'getRecommendRecommendations',
      })
    },
    data(){
      return {
        title: 'Polecamy',
      }
    },
    created(){
      this.$store.dispatch(
          'fetchDataPage', {
            ID: this.defines.recommendPage,
            chunks: [
              {
                method: 'setRecommendRecommendations',
                chunkType: 'recommendations'
              }
            ]
          });
    }
  }
</script>
