import { Login } from "../components";
import { Register } from "../components";

export default [
  {
    path: "/auth/login",
    component: Login,
    name: "login",
    meta: {}
  },
  {
    path: "/auth/register",
    component: Register,
    name: "register",
    meta: {}
  }
];
