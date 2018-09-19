<!--suppress ALL -->
<template>
    <section id="default" class="default content page__content" v-cloak>
        <page-title :title="title"></page-title>
        <div class="container">
            <div class="row">
                <article v-html="content"></article>
            </div>
        </div>
    </section>
</template>
<script>
  import PageTitle from '../../page-title.vue';
  import { mapGetters } from 'vuex';
  import { getRouteComponentID } from '../../../js/helper'


  export default {
    name: 'Default',
    props: ['defines'],
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
    components: {
      PageTitle
    },
    computed: {
      ...mapGetters({
        content: 'getCmsData',
      }),
    },
    data(){
      return{
        title: this.$route.name
      }
    },
    updated(){
//      let ID = getRouteComponentID(this.$route.name).ID
//      this.$store.dispatch({
//        ID,
//        type: 'fetchContentSite',
//      })
    },
    mounted(){
        this.updateView(this.$route)
    },
    methods: {
      updateView(nextView) {
        let ID = getRouteComponentID(nextView.name).ID
        this.$store.dispatch({
          ID,
          type: 'fetchContentSite',
        })
      }
    },
    watch: {
      '$route' (to, from) {
        this.updateView(to)
        this.title = to.name
      }
    }
  }
</script>
