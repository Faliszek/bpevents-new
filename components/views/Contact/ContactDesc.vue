<template>
  <div class="contact__desc">
    <div class="contact__logo"><img :src="picture.url" :alt="picture.alt"/></div>
    <div class="contact__info" v-html="desc"></div>
  </div>
</template>

<script>
  import {mapGetters} from 'vuex';
  export default{
    name: 'contact-desc',
    computed: {
      ...mapGetters({
        desc: 'getContactDesc',
        picture: 'getContactImg'
      })
    }
  }
</script>
