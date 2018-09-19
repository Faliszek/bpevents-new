<template>
    <ul class="gallery__eqs eqs-container">
      <li class="gallery__eq gallery__item z-depth-1 unvisible scale-hover-effect gallery-item"
          v-for="(eq, index) in equipment"
          :key="index">
        <img v-img v-render
             class="img-responsive img"
             :src="eq.picture.url"
             :alt="eq.picture.alt"
        />
        <figcaption class="description">
          <h5 class="text-center" v-if="eq.picture.description">{{eq.picture.description}}</h5>
        </figcaption>
      </li>
    </ul>
</template>
<script>
  import { mapGetters } from 'vuex';
  export default{
    name: 'equipment-gallery',
    computed: {
      ...mapGetters({
        equipment: 'getGalleryEquipment',
      }),
    },
  }
</script>
