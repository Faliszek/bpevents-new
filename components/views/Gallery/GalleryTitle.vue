<template>
  <h5 id="gallery-title" class="text-center gallery__title">
    <transition name="scale" mode="out-in" v-if="title">
      <span v-if="title === 'photos-gallery'">{{photosTitle}}</span>
      <span v-if="title === 'videos-gallery'">{{videosTitle}}</span>
      <span v-if="title === 'equipment-gallery'">{{equipmentTitle}}</span>
    </transition>

  </h5>
</template>
<script>
  import {mapGetters} from 'vuex';

  export default {
    props: ['title'],
    computed: {
      ...mapGetters({
        photosTitle: 'getGalleryPhotosTitle',
        videosTitle: 'getGalleryVideosTitle',
        equipmentTitle: 'getGalleryEquipmentTitle',
      })
    }
  }
</script>
