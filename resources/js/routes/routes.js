import Cookies from 'js-cookie'
import store from "../store";

const GuestLayout = ()  => import('../layouts/Guest.vue');
const AuthLayout = ()  => import('../layouts/AuthLayout.vue');

function requireLogin(to, from, next) {
    let isLogin = false;
    isLogin = !!store.state.auth.authenticated;
    if (isLogin) {
        next()
    } else {
        next('/login')
    }
}

function guest(to, from, next) {
    let isLogin;
    isLogin = !!store.state.auth.authenticated;

    if (isLogin) {
        next('/')
    } else {
        next()
    }
}

export default [
    {
        path: '/',
        component: GuestLayout,
        children: [
            {
                path: '/',
                name: 'home',
                component: () => import('../views/pages/dashboard.vue'),
                beforeEnter: requireLogin,
            },

            
        ]
    },
    {
        path: '/',
        component: GuestLayout,
        beforeEnter: requireLogin,
        children: [
            {
                path: '/dashboard',
                name: 'dashboard',
                component: () => import('../views/pages/dashboard.vue'),
            },
            {
                path: 'balance',
                name: 'balance',
                component: () => import('../views/pages/balance.vue'),
            },
            {
                path: 'support-ticket',
                name: 'support-ticket',
                component: () => import('../views/pages/support-ticket.vue'),
            },
            {
                path: 'switch-account',
                name: 'switch-account',
                component: () => import('../views/pages/switch-account.vue'),
            },
            {
                path: 'ticket-detail/:id',
                name: 'ticket-detail',
                component: () => import('../views/pages/ticket-detail.vue'),
            },

            {
                path: 'manageUser-detail/:id/:email',
                name: 'manageUser-detail',
                component: () => import('../views/pages/permission-detail.vue'),
            },

            {
                path: 'settings',
                name: 'settings',
                component: () => import('../views/pages/settings.vue'),
            },

            {
                path: 'overview/:id',
                name: 'overview',
                component: () => import('../views/pages/overview.vue'),
            },

            {
                path: 'servers',
                name: 'servers',
                component: () => import('../views/pages/servers.vue'),
            },

            {
                path: 'create-vps-server',
                name: 'create-vps-server',
                component: () => import('../views/pages/create-vps-server.vue'),
            },

        ]
    },

    {
        path: '/',
        component: AuthLayout,
        children: [
            {
                path: 'login',
                name: 'auth.login',
                component: () => import('../views/login/Login.vue'),
                beforeEnter: guest,
            },
            {
                path: 'register',
                name: 'auth.register',
                component: () => import('../views/register/index.vue'),
                beforeEnter: guest,
            },
            {
                path: 'forgot-password',
                name: 'forgot-password',
                component: () => import('../views/forgot-password/index.vue'),
                beforeEnter: guest,
            },
            {
                path: 'noVNC/:id',
                name: 'noVNC',
                component: () => import('../views/pages/noVNC.vue'),
                beforeEnter: requireLogin,
            },
        ]
    },
    {
        path: "/:pathMatch(.*)*",
        name: 'NotFound',
        component: () => import("../views/errors/404.vue"),
    },
];
