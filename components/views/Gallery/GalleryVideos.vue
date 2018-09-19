<template>
    <ul class="gallery__videos videos-container">
      <li class="gallery__video gallery__item z-depth-1 scale-hover-effect gallery-item video-player"
          v-for="(video, index) in videos"
          :key="index">
        <div class="gallery__video-wrap video-player-wrap">
          <video-player
                         ref="videoPlayer"
                         v-render="'video'"
                         :options="{
                         sources: [{
                          type: 'video/mp4',
                          src: video.video.url
                         }],
                         poster: video.miniature.url
                         }">
          </video-player>
        </div>
      </li>
    </ul>
</template>
<script>
  import { videoPlayer } from 'vue-video-player'
  import {mapGetters} from 'vuex';

  export default{
    name: 'videos-gallery',
    components: {
      videoPlayer
    },
    computed: {
      ...mapGetters({
        videos: 'getGalleryVideos',
      }),
    },

  }
</script>
