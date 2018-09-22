<template>
  <section id="recommend" class="content page__content">
    <div class="container">
      <div class="row">
        <page-title :title="title"></page-title>

      <div class="row content-row">
                <article v-html="text"></article>
            </div>
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
import PageTitle from "../../page-title.vue";
import SingleRecommend from "./RecommendSingle.vue";
import { mapGetters } from "vuex";

export default {
  name: "Recommend",
  props: ["defines"],
  components: {
    PageTitle,
    SingleRecommend
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
      recommendations: "getRecommendRecommendations",
      text: "getRecommendContent"
    })
  },
  data() {
    return {
      title: "Nasz team"
    };
  },
  created() {
    const ID = this.defines.recommendPage;
    this.$store.dispatch("fetchDataPage", {
      ID,
      chunks: [
        {
          method: "setRecommendRecommendations",
          chunkType: "recommendations"
        }
      ]
    });

    this.$store.dispatch({
      ID,
      type: "fetchContentSite",
      setterType: "setRecommendContent"
    });
  }
};
</script>
