<template>
    <main>
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary ">
            <ul class=" navbar-nav me-auto mb-2 mb-lg-0 d-flex justify-content-between " style="width: 100%">
                <div class="d-flex me-auto " style="">
                    <li class="nav-item" v-if="(token !== 0)">
                        <router-link exact-active-class="active" to="/note" class="nav-link"  aria-current="page">Notas</router-link>
                    </li>
                </div>

                <div class="d-flex " style="">
                    <li class="nav-item" v-if="(token === 0)">
                        <router-link exact-active-class="active" to="/register" class="nav-link">Registrar</router-link>
                    </li>
                    <li class="nav-item" v-if="(token === 0)" >
                        <router-link exact-active-class="active" to="/login" class="nav-link">Login</router-link>
                    </li>

                    <div v-if="(token !== 0)">
                        <button type="button" class="btn btn-danger mt-2" @click="logout">Logout</button>
                    </div>
                </div>
            </ul>


        </nav>
        <div class="container mt-5">

            <router-view></router-view>
        </div>
    </main>
</template>

<script>
import { useRouter } from "vue-router"
import { useStore } from 'vuex'
import { computed } from 'vue'
export default {
    setup() {

        const router = useRouter()
        const store = useStore();
        const token = computed(() => store.getters.token);

        function logout(){
            store.dispatch('removeToken');
            router.push({name:'login'})
        }


        return {
            logout,
            token

        }

    }
}
</script>
