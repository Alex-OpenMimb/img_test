<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-sm-6 mt-4">

                <h2>Login</h2>

                <p class="text-danger"></p>

                <form >
                    <div class="form-group">
                        <label for="email">Email Address:</label>
                        <input type="email" class="form-control" id="email">
                    </div>
                    <div class="form-group mb-5">
                        <label for="password">Password:</label>
                        <input type="password" class="form-control " id="password" >
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

    setup() {

    }
}
</script>
