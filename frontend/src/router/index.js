import { createRouter, createWebHistory } from "vue-router";
import store from "@/store";
import HomePage from "../views/HomePage";
import SignIn from "../views/SignIn";
import SignUp from "../views/SignUp";
import UserProfile from "../views/UserProfile";
import NewsLine from "../views/NewsLine";
import Tag from "../components/TagList";

const routes = [
  {
    path: "/",
    name: "HomePage",
    component: HomePage,
  },
  {
    path: "/login",
    name: "SignIn",
    component: SignIn,
    meta: { guest: true },
  },
  {
    path: "/register",
    name: "SignUp",
    component: SignUp,
    meta: { guest: true },
  },
  {
    path: "/profile/:name",
    name: "UserProfile",
    component: UserProfile,
    meta: { requireAuth: true },
  },
  {
    path: "/news",
    name: "NewsLine",
    component: NewsLine,
    meta: { requireAuth: true },
  },
  {
    path: "/tag/:name",
    name: "PostListByTag",
    component: Tag,
    meta: { requireAuth: true },
  },
];

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes,
  scrollBehavior() {
    document.getElementById("app").scrollIntoView({ behavior: "smooth" });
  },
});

router.beforeEach((to, from, next) => {
  if (to.matched.some((record) => record.meta.requireAuth)) {
    if (store.getters.isLoggedIn) {
      return next();
    }
    return next({ name: "SignIn" });
  } else {
    return next();
  }
});

router.beforeEach((to, from, next) => {
  if (to.matched.some((record) => record.meta.guest)) {
    if (store.getters.isLoggedIn) {
      return next({ name: "UserProfile" });
    }
    return next();
  } else {
    return next();
  }
});

export default router;
