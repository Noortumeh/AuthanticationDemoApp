import { createRouter, createWebHistory } from "vue-router";
import Home from "../views/Home.vue";
import Login from "../views/Login.vue";
import Register from "../views/Register.vue";
import Profile from "../views/Profile.vue";
import ForgotPass from "../views/ForgotPass.vue";
import ResetPass from "../views/ResetPass.vue";
import NotFound from "@/views/NotFound.vue";
import DashboardHome from "@/views/Admin/DashboardHome.vue";
import DashboardUsers from "../views/Admin/DashboardUsers.vue";
import Dashboard from "@/views/Admin/Dashboard.vue";
import AddNewUser from "@/views/Admin/AddNewUser.vue";
import ViewUser from "@/views/Admin/ViewUser.vue";

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: "/",
      name: "home",
      children: [
        { path: "", name: "home-home", component: Home },
        { path: "/login", name: "login", component: Login },
        { path: "/register", name: "register", component: Register },
        { path: "/profile", name: "profile", component: Profile },
        {
          path: "/forgot-password",
          name: "forgot-password",
          component: ForgotPass,
        },
        {
          path: "/reset-password",
          name: "reset-password",
          component: ResetPass,
        },
      ],
    },
    //Admin Dashboard
    { 
      path: "/dashboard", 
      name: "dashboard", 
      component: Dashboard, 
      children: [
        {
          path: "",
          name: "dashboard-home",
          component: DashboardHome,
        },
        {
          path: "users",
          name: "dashboard-users",
          component: DashboardUsers,
        },
        {
          path: "add-new-user",
          name: "dashboard-add-new-user",
          component: AddNewUser,
        },
        {
          path: "view-user/:id",
          name: "dashboard-view-user",
          component: ViewUser,
        },
      ]
    },
    //route for 404 page
    {
      path: '/:pathMatch(.*)*',
      name: 'NotFound',
      component: NotFound,
    },
  ],
});

export default router;
