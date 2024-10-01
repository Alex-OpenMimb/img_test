<template>
    <main>
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary ">
            <ul class=" navbar-nav me-auto mb-2 mb-lg-0 d-flex justify-content-between " style="width: 100%">
                <div class="d-flex me-auto " style="">
                    <li class="nav-item">
                        <a exact-active-class="active" to="/home" class="nav-link" aria-current="page">Etiquetas</a>
                    </li>
                    <li class="nav-item">
                        <a exact-active-class="active" to="/home" class="nav-link" aria-current="page">Notas</a>
                    </li>
                </div>

                <div class="d-flex " style=""> <!-- Alineado a la derecha -->
                    <li class="nav-item">
                        <a exact-active-class="active" to="/login" class="nav-link">Register</a>
                    </li>
                    <li class="nav-item">
                        <a exact-active-class="active" to="/login" class="nav-link">Login</a>
                    </li>

                    <div>
                        <button type="button" class="btn btn-danger mt-2">Logout</button>
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

export default {
    // `setup` is a special hook dedicated for the Composition API.
    setup() {


        // expose the ref to the template

    }
}
</script>
