<template>
    <ul class="gallery__photos photos-container">
      <li class="gallery__photo gallery__item z-depth-1 unvisible scale-hover-effect gallery-item"
          v-for="(photo, index) in photos"
          :key="index">

        <img v-img v-render
             class="img-responsive img"
             :src="photo.picture.url"
             :alt="photo.picture.alt"
        />
      </li>
    </ul>
</template>
<script>
  import {mapGetters} from 'vuex';

  export default{
    name: 'photos-gallery',
    computed: {
      ...mapGetters({
        photos: 'getGalleryPhotos',
      }),
    },
  }
</script>
