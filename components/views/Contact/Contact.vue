<template>
  <section id="contact" class="contact page__content">
    <page-title :title="title"></page-title>
    <div class="container">
      <div class="row">
        <div class="contact-wrap contact__wrap">
          <contact-desc></contact-desc>
          <contact-form :defines="defines"></contact-form>
        </div>
      </div>
    </div>
  </section>

</template>
<script>
  import PageTitle from '../../page-title.vue';
  import ContactDesc from './ContactDesc.vue';
  import ContactForm from './ContactForm.vue';

  export default{
    name: 'Contact',
    props: ['defines'],
    className: 'contact',
    components: {
      PageTitle,
      ContactDesc,
      ContactForm
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
    data(){
      return {
        title: 'Skontaktuj się ze mną!'
      }
    },
    created(){
      this.$store.dispatch(
          'fetchDataPage',
          {
            ID: this.defines.contactPage,
            chunks: [
              {method: 'setContactDesc', chunkType: 'desc'},
              {method: 'setContactImg', chunkType: 'img'}
            ]
          });
    }
  }
</script>
