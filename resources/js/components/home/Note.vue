<template>
    <div class="container   ">

       <div class="d-flex justify-content-end">
           <button  type="button" class="btn btn-primary" data-toggle="modal" data-target="#create-note">
               Crear Nota
           </button>
       </div>

        <div class="mx-4 w-100">
            <table class="table table-bordered mt-5">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Titulo</th>
                    <th>Descripción</th>
                    <th>Usuario</th>
                    <th>Etiqueta</th>
                    <th>Creada</th>
                    <th>Expira</th>
                    <th>Imagén</th>
                    <th>Acciones</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="note in notes" :key="note.id" >
                    <td>{{note.id}}</td>
                    <td>{{ note.title }}</td>
                    <td class="" style="width: 200px">{{note.description}}</td>
                    <td>{{note.user}}</td>
                    <td>{{note.tag}}</td>
                    <td>{{note.creation_date}}</td>
                    <td>{{ note.expiration_date ? note.expiration_date : 'No hay fecha de expiración' }}</td>
                    <td>
                        <img :src="getImageUrl(note.image)" alt="Imagen" width="50" />
                    </td>
                    <td class="d-flex gap-4">
                        <button  type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
                        Actualizar
                       </button>
                        <button  type="button" class="btn btn-danger" data-toggle="modal" data-target="#myModal">
                            Eliminar
                        </button>
                    </td>

                </tr>

                </tbody>
            </table>
        </div>


        <!-- The create modal -->
        <div class="modal fade" id="create-note">
            <div class="modal-dialog">
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Crear Nota</h4>
                        <button type="button" class="close btn btn-danger" data-dismiss="modal">&times;</button>
                    </div>

                    <!-- Modal Body -->
                    <div class="modal-body">
                        <form class="card card-body">
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input class="form-control" placeholder="Titulo" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input class="form-control" type="date" >
                                    </div>
                                </div>
                            </div>

                            <div class="form-group my-4">
                                <label>Fecha de expiración</label>
                                <input class="form-control" type="text" placeholder="Descripción"  required>
                            </div>

                            <div class="form-group my-4">
                                <label>Imagen</label>
                                <input class="form-control" type="file" required>
                            </div>

                            <div class="form-group d-flex flex-column my-4">
                                <label>Categoría</label>
                                <select class="form-control" required>
                                    <option selected>Seleccionar</option>
                                    <option v-for="(tag, index) in tags" :key="index" :value="tag.id">
                                        {{ tag.name }}
                                    </option>
                                </select>
                            </div>

                            <button type="submit" class="btn btn-primary btn-block">Guardar</button>
                        </form>
                        <div class="error-message mt-4 text-danger"></div>
                    </div>

                    <div  class="error-message text-center text-danger">

                    </div>
                </div>
            </div>
        </div>

    </div>

</template>

<script>
import { computed, ref, onMounted } from 'vue';
import { useStore  } from 'vuex';
export default {

    setup(){
        const store = useStore()
        const tags = computed(() => store.getters.tags);
        const notes = computed(() => store.getters.notes);
        onMounted(() => {
            store.dispatch('fetchTags');
            store.dispatch('fetchNote');


        });
        const getImageUrl = (imagePath) => {
            return `${window.location.origin}/storage/${imagePath}`
        };

        return{
            tags,
            notes,
            getImageUrl

        }
    }
}
</script>
