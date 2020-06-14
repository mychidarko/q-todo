import Vue from "vue";
import Router from "vue-router";
import { routes } from "@/app/index";
import User from "@/storage/user.storage";

Vue.use(Router);

const router = new Router({
  mode: "history",
  base: process.env.BASE_URL,
  routes
});

router.beforeEach((to, from, next) => {
  const publicPages = ["/auth/login", "/auth/register"];
  const authRequired = !publicPages.includes(to.path);
  const hasAuth = User.get();

  if (authRequired && !hasAuth) {
    return next("/auth/login");
  } else if (!authRequired && hasAuth) {
    return next("/home");
  }

  next();
});

export default router;
