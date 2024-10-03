import { createWebHistory, createRouter } from 'vue-router';

import Login from './components/auth/Login.vue'
import Register from './components/auth/Register.vue'
import Note from './components/home/Note.vue'
import store from './store/index.js';

export const routes = [
    {
        name: 'login',
        path: '/login',
        component: Login,
        meta: {
            requiresAuth:false
        }
    },
    {
        name: 'register',
        path: '/register',
        component: Register,
        meta: {
            requiresAuth:false
        }
    },
    {
        name: 'note',
        path: '/note',
        component: Note,
        meta: {
            requiresAuth:true
        }
    },
];


const router = createRouter({
    history: createWebHistory(),
    routes
});

router.beforeEach((to,from) =>{
    if(to.meta.requiresAuth && !localStorage.getItem('token') ){
        return {name: 'login'}
    }

})


export default router;
