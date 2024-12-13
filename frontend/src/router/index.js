import { createRouter, createWebHistory } from "vue-router";

const routes = [
  {
    path: "/",
    name: "Dashboard",
    component: () => import("../views/Dashboard.vue"),
  },
  {
    path: "/stock",
    name: "Stock",
    component: () => import("../views/Stock.vue"),
  },
  {
    path: "/sales",
    name: "Sales",
    component: () => import("../views/Sales.vue"),
  },
  {
    path: "/test",
    name: "Test",
    component: () => import("../views/Test.vue"),
  },
];

const router = createRouter({
  history: createWebHistory(), // Removed "/" argument
  routes,
});

export default router;
