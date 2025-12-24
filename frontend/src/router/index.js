import { createRouter, createWebHistory } from "vue-router";
import Home from "../views/Home.vue";
import Login from "../views/Login.vue";
import Register from "../views/Register.vue";
import Profile from "../views/Profile.vue";
import ForgotPass from "../views/ForgotPass.vue";
import ResetPass from "../views/ResetPass.vue";

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    { path: "/", name: "home", component: Home },
    { path: "/login", name: "login", component: Login },
    { path: "/register", name: "register", component: Register },
    { path: "/profile", name: "profile", component: Profile },
    { path: "/forgot-password", name: "forgot-password", component: ForgotPass },
    { path:'/reset-password', name: 'reset-password', component: ResetPass}
  ],
});

export default router;
