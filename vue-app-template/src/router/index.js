import Vue from "vue";
import Router from "vue-router";
import { routes } from "@/app/index";
import User from "@/storage/user.storage";
import { TOKEN_STORAGE_KEY } from '@/config';

Vue.use(Router);

console.log(routes);

const router = new Router({
  mode: "history",
  base: process.env.BASE_URL,
  routes
});

router.beforeEach((to, from, next) => {
  const publicPages = ["/auth/login", "/auth/register"];
  const authRequired = !publicPages.includes(to.path);
  const hasAuth = User.get(TOKEN_STORAGE_KEY);

  if (authRequired && !hasAuth) {
    return next("/auth/login");
  } else if (!authRequired && hasAuth) {
    return next("/home");
  }

  next();
});

export default router;
