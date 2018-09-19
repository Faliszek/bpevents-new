<template>
  <header id="header">
    <nav class="main-nav">
      <div class="container">
        <div class="menu-main__row">
          <div class="menu-main__logo">
            <a class="logo" href="/"></a>
          </div>
          <div @click="toggleMenu" id="mobile-menu" :class="[{ active: showMenu }, 'menu-main__hamburger']">
            <div class="menu-main__hamburger-icon"></div>
          </div>
          <div class="menu-main__container">
            <ul class="menu-main__link-list">
              <li v-bind:key="link.object_id" @click="toggleMenu" class="menu-main__link" @mouseover="fetchData(link.object_id)" :data-id="link.object_id" v-for="link in links">
                <router-link
                  :to="{ path: link.object_slug }"
                  class="menu-item">
                  {{ link.title }}
                </router-link>

              </li>
            </ul>
          </div>
        </div>

      </div>
    </nav>
  </header>
</template>
<script type="text/babel">
import Waves from "node-waves/dist/waves";
import { mapGetters } from "vuex";
import { MAIN_MENU_ID } from "../js/data";
import { boundedChunksWithMutations } from "../js/helper";
export default {
  props: ["defines"],
  computed: {
    ...mapGetters({
      links: "getMenuLinks"
    })
  },
  data() {
    return {
      showMenu: false
    };
  },
  created() {
    this.$store.dispatch("getMenu", MAIN_MENU_ID);
  },
  methods: {
    fetchData(ID) {
      this.$store.dispatch("fetchDataPage", {
        ID,
        chunks: boundedChunksWithMutations(ID)
      });
    },

    toggleMenu() {
      this.showMenu = !this.showMenu;
    }
  }
};
</script>
