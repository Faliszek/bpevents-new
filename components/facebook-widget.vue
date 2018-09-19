<template>
  <div :class="['facebook-social-wrap',  { loaded : loaded }, {showed: showed}]"
       v-on:mouseover="showWidget"
       v-on:mouseleave="hideWidget">
    <div class="fb-root-wrap">
      <div id="fb-root" >
        <div class="fb-page"
             :data-href="url"
             data-tabs="timeline"
             data-small-header="false"
             data-adapt-container-width="true"
             data-hide-cover="false"
             data-width="252"
             data-show-facepile="true">
        </div>
      </div>
    </div>
    <div class="fb-btn icon-facebook"></div>
  </div>
</template>
<script>
  import {FACEBOOK_DATA} from '../js/data';


  export default{
    name: 'FacebookWidget',
    data(){
      return {
        url: FACEBOOK_DATA.url,
        loaded: false,
        showed: false,
      }
    },
    beforeCreate(){
      const appID = FACEBOOK_DATA.app_id;
      const facebookWidget = this;
      (function (d, s, id) {
        let js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s);
        js.id = id;
        js.src = `//connect.facebook.net/pl_PL/sdk.js#xfbml=1&version=v2.10&appId=${appID}`;
        fjs.parentNode.insertBefore(js, fjs);
      }(document, 'script', 'facebook-jssdk'));

      window.fbAsyncInit = function() {
        FB.init({
          appId            : appID,
          autoLogAppEvents : true,
          xfbml            : true,
          version          : 'v2.10'
        });
        FB.AppEvents.logPageView();
        FB.Event.subscribe('xfbml.render', facebookWidget.finishRendering);

      };
    },
    methods: {
      finishRendering(){
        this.loaded = true;
      },

      showWidget(){
        this.showed = true;
      },

      hideWidget(){
        this.showed = false
      }
    }
  }
</script>
