import Vue from "vue";
import Router from "vue-router";
import { routes } from "../app/index";

Vue.use(Router);

console.log(routes);

const router = new Router({
  mode: "history",
  base: process.env.BASE_URL,
  routes
});

export default router;
