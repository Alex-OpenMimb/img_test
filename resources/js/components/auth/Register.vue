<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-sm-6 mt-4">

                <h2>Register</h2>


                <form @submit.prevent="register" class="mb-4" >
                    <div class="mb-4">

                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name" v-model="form.name" >
                        </div>
                        <div class="form-group">
                            <label for="email">Email Address:</label>
                            <input type="email" class="form-control" id="email" v-model="form.email">
                        </div>

                        <div class="form-group">
                            <label for="password">Password:</label>
                            <input type="password" class="form-control" id="password" v-model="form.password" >
                        </div>

                    </div>

                    <button type="submit" class="btn btn-primary">Register</button>
                </form>
                <p class="text-danger" v-for="error in errors" :key="error">
                    <span v-for="err in error" :key="err">{{ err }}</span>
                </p>
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
            name: '',
            email: '',
            password: ''
        });

        let errors = ref('')

        const register = async ()=>{

            await axios.post('api/register',form)
                .then(res =>{
                    store.dispatch('setToken',res.data.authorisation.token);
                    router.push({name:'note'})
                    console.log(res)
                }).catch(e =>{
                    console.log(e.response.data.errors)
                    errors.value = e.response.data.errors
                })

        }

        return {
            form,
            register,
            errors
        }

    }

}
</script>
