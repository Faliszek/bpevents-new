<template>
  <div class="ref">
    <div class="ref__wrap">
      <div class="ref__img scale-hover-effect">
        <img v-img v-render class="img-responsive img z-depth-1"
             :src="reference.ref_autor_img.url"
             :alt="reference.ref_autor_img.alt"/>
      </div>
      <div class="ref__content">
        <h4 class="title">{{ reference.ref_autor }}</h4>
        <p class="text" v-html="reference.ref_opinion "></p>
        <a class="link" target="_blank" :href="reference.ref_link">Zobacz opinie</a>
      </div>
    </div>
  </div>
</template>
<script>
  export default{
    props: ['reference'],
  }
</script>
