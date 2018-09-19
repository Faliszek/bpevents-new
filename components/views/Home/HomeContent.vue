<template>
  <section class="content-block">
    <div class="container">
      <div class="row">
        <article class="content-block__article">
          <h1 class="content-block__title">{{ block.title }}</h1>
          <div class="content-block__wrapper">
            <p class="content-block__text" v-html="block.content"></p>
            <figure class="content-block__img scale-hover-effect">
              <img v-img :src="block.background.url" :alt="block.background.alt" class="img-responsive z-depth-3"/>
              <figcaption v-if="block.background.description">{{ block.background.description }}</figcaption>
            </figure>
          </div>
        </article>
      </div>
    </div>
  </section>
</template>
<script>
  import {mapGetters} from 'vuex';
  export default{
    props: ['block'],
  }
</script>
