import { DATA_PAGE } from "./data";
import VueRouter from "vue-router";
import { scrollToTop } from "./helper.js";

const assignRoutesToComponents = dataRoutes => {
  let mappedRoutes = [];
  dataRoutes.forEach((route, index) => {
    mappedRoutes.push({
      name: route.name,
      path: route.path,
      component: require(`../components/views/${route.component}/${
        route.component
      }.vue`),
      meta: {
        site_title: route.site_title,
        title: route.meta_title,
        desc: route.meta_desc
      }
    });

    if (index + 1 === dataRoutes.length) {
      mappedRoutes.push({
        path: "*",
        component: require("../components/views/Home/Home.vue"),
        redirect: "/"
      });
    }
  });
  return mappedRoutes;
};

const routesCreator = () => {
  return assignRoutesToComponents(DATA_PAGE.routes);
};

const router = new VueRouter({
  mode: "history",
  root: "/",
  routes: routesCreator(),
  scrollBehavior(to, from, savedPosition) {
    scrollToTop(300);
  }
});

export default router;
