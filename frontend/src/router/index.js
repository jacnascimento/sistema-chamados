import { createRouter, createWebHistory } from 'vue-router'
import { requireAuth, requireGuest } from './guards'
import Dashboard from '@/views/Dashboard.vue'
import TicketList from '@/views/TicketList.vue'
import Login from '@/views/Login.vue'
import Unauthorized from '@/views/Unauthorized.vue'

const routes = [
    {
        path: '/login',
        name: 'Login',
        component: Login,
        beforeEnter: requireGuest
    },
    {
        path: '/unauthorized',
        name: 'Unauthorized',
        component: Unauthorized
    },
    {
        path: '/',
        name: 'Chamados',
        component: TicketList,
        beforeEnter: requireAuth
    },
    {
        path: '/chamados',
        name: 'Chamados',
        component: TicketList,
        beforeEnter: requireAuth
    }
    // {
    //     path: '/usuarios',
    //     name: 'Usuarios',
    //     component: Usuarios,
    //     beforeEnter: requireAuth
    // }
]

const router = createRouter({
    history: createWebHistory(),
    routes
})

export default router
