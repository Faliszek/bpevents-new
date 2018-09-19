<template>
  <main id="page">
    <header-theme :defines="this.variables"></header-theme>
    <transition name="flash" mode="out-in" >
      <!--<keep-alive>-->
        <router-view :defines="this.variables"></router-view>
      <!--</keep-alive>-->
    </transition>
    <footer-theme :defines="this.variables"></footer-theme>
    <facebook-widget></facebook-widget>
  </main>
</template>
<script>
  import Vue from 'vue';
  import { DATA_PAGE } from './js/data';
  import HeaderTheme from './components/header-theme.vue';
  import FooterTheme from './components/footer-theme.vue';
  import FacebookWidget from './components/facebook-widget.vue';
  export default {
    name: 'App',
    components: {
      HeaderTheme,
      FooterTheme,
      FacebookWidget
    },
    data(){
      return {
        variables: DATA_PAGE,
      }
    },
  }
</script>
