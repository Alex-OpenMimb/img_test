<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-sm-6 mt-4">

                <h2>Login</h2>

                <p class="text-danger">{{ error }}</p>

                <form @submit.prevent="login">
                    <div class="form-group">
                        <label for="email">Email Address:</label>
                        <input type="email" class="form-control" id="email" v-model="form.email">
                    </div>
                    <div class="form-group mb-5">
                        <label for="password">Password:</label>
                        <input type="password" class="form-control " id="password" v-model="form.password">
                    </div>
                    <button type="submit" class="btn btn-primary">Login</button>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
import { reactive,ref } from 'vue'
import { useRouter } from "vue-router"
import { useStore } from 'vuex'

export default {

    setup(){
        const router = useRouter()
        const store = useStore()

        const form = reactive({
            email: '',
            password: ''
        });

        let error = ref('');
        const login = async ()=>{

            try {
                await axios.post('api/login',form)
                    .then(res =>{
                        store.dispatch('setToken',res.data.authorisation.token);
                        router.push({name:'note'})
                        console.log(res)
                    });


            } catch (err) {
                error.value = err.response.data.message;

            }

        }

        return {
            form,
            login,
            error,

        }

    }

}
</script>
