import { createRouter, createWebHistory } from "vue-router";
import routes from './routes.js'

const router = createRouter({
    history: createWebHistory(),
    routes
})

router.beforeEach((to, from, next) => {
    // Perform actions before each route navigation
    // For example, you can check if the user is authenticated
    // and redirect to the login page if necessary
    NProgress.start();
    NProgress.set(0.1);
    return next();
});

router.afterEach((to, from) => {
    setTimeout(() => NProgress.done(), 200);
});

export default router;
