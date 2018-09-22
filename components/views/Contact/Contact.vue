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

    <div class="row content-row-map">
<iframe src="
https://maps.google.pl/maps?ie=UTF8&q=%C5%81epkowskiego+5%2F14%2C+31-423+Krak%C3%B3w&gl=PL
&hl=pl&t=m&iwloc=A&output=embed" width="600" height="450" frameborder="0" style="border:0"
></iframe>

      </div>
  </section>

</template>
<script>
import PageTitle from "../../page-title.vue";
import ContactDesc from "./ContactDesc.vue";
import ContactForm from "./ContactForm.vue";

export default {
  name: "Contact",
  props: ["defines"],
  className: "contact",
  components: {
    PageTitle,
    ContactDesc,
    ContactForm
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
  data() {
    return {
      title: "Skontaktuj się ze mną!"
    };
  },
  created() {
    this.$store.dispatch("fetchDataPage", {
      ID: this.defines.contactPage,
      chunks: [
        { method: "setContactDesc", chunkType: "desc" },
        { method: "setContactImg", chunkType: "img" }
      ]
    });
  }
};
</script>
