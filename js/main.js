import '../css/main.scss';
import 'node-waves/dist/waves.js'
import Vue from 'vue';
import VueResource from 'vue-resource';
import VueHead from 'vue-head';
import VueRouter from 'vue-router'
import VueAwesomeSwiper from 'vue-awesome-swiper'
import VueImg from 'v-img';
import VueVideoPlayer from 'vue-video-player'

import store from './store';
import router from './router'
import { sync } from 'vuex-router-sync';

Vue.use(VueRouter);
Vue.use(VueResource);
Vue.use(VueHead);
Vue.use(VueAwesomeSwiper);
Vue.use(VueImg);
Vue.use(VueVideoPlayer);

Vue.directive('render', {
    bind: function(el, binding){
      if(binding.value === 'video'){
        let poster = new Image();
        let checkVideoImg = setInterval(() => {
          let getStyleBackground =
              el.querySelector('.vjs-poster') !== null ?
              el.querySelector('.vjs-poster').getAttribute('style') : false;
          if(getStyleBackground) {
            let findImgSrc =
                getStyleBackground
                    .substring(
                        getStyleBackground.lastIndexOf('(')+1,
                        getStyleBackground.lastIndexOf(')')
                    ).replace(/"/g, '');
            poster.setAttribute('src', findImgSrc);
            if(poster.complete) {
                el.parentNode.classList.add('opacity-show');
                if (el.parentNode.classList.contains('opacity-show')) {
                  clearInterval(checkVideoImg)
                }
            }
          } else {
            el.parentNode.classList.add('opacity-show');
          }
        }, 300)
      } else {
        let checkImg = setInterval(() => {
          if (el.complete) {
            el.parentNode.classList.remove('unvisible');
            el.classList.add('opacity-show');
            if (el.classList.contains('opacity-show')) {
              clearInterval(checkImg)
            }
          }
        }, 300)
      }
    },

});



Vue.config.devtools = true;
Vue.http.options.emulateJSON = true;

sync(store, router);
import App from '../App.vue';
const Root = new Vue({
  el: '#app',
  router,
  store,
  template: '<App/>',
  components: { App }
});


