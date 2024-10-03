<template>
    <div class="container   ">
        <span class="">Ordenar por fecha</span>
        <div class="w-50 d-flex gap-4">
          <div class="">
              <label>Tipo de fecha*</label>
              <select v-model="date" class="form-control" >
                  <option value=""> Seleccionar </option>
                  <option value="creation_date"> Creacion </option>
                  <option value="expiration_date"> Expira </option>
              </select>
          </div>

           <div>
               <label>Tipo de rden*</label>
               <select v-model="order" class="form-control" >
                   <option value=""> Seleccionar </option>
                   <option value="asc"> Asendente </option>
                   <option value="desc"> Desendente </option>
               </select>
           </div>
            <div>
                <button  @click="orderNote" class="btn btn-primary"> Filtrar</button>
            </div>

        </div>
        <div v-if="validation_error" class="error-messages  text-danger" style="height:50px;">
            {{validation_error }}
        </div>

       <div class="d-flex justify-content-end">
           <button @click="clearInput" type="button" class="btn btn-primary" data-toggle="modal" data-target="#create-note">
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
                    <th>Imagen</th>
                    <th>Acciones</th>
                </tr>
                </thead>
                <tbody>
                <div v-if="notes.length === 0" class="w-100 ">
                    <p class="">Sin Notas</p>
                </div>
                <tr v-for="note in notes" :key="note.id" >
                    <td>{{note.id}}</td>
                    <td>{{ note.title }}</td>
                    <td class="" style="width: 200px">{{note.description}}</td>
                    <td>{{note.user}}</td>
                    <td>{{note.tag}}</td>
                    <td>{{note.creation_date}}</td>
                    <td>{{ note.expiration_date ? note.expiration_date : 'No hay fecha de expiración' }}</td>
                    <td>
                        <img v-if="note.image" :src="getImageUrl(note.image)" alt="Imagen" width="50" />
                        <span v-else> Sin imagen </span>
                    </td>
                    <td class="d-flex gap-4">
                        <button @click="setNote(note)"  type="button" class="btn btn-primary" data-toggle="modal" data-target="#edit-note">
                        Actualizar
                       </button>
                        <button @click="deleteNote(note.id)" type="button" class="btn btn-danger" data-toggle="modal" >
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
                        <button @click="clearError" type="button" class="close btn btn-danger" data-dismiss="modal">&times;</button>
                    </div>

                    <!-- Modal Body -->
                    <div class="modal-body">
                        <form @submit.prevent="createNote" class="card card-body">
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Titulo</label>
                                        <input v-model="form.title"  class="form-control" placeholder="Titulo" >
                                        <span class="text-danger" v-if="form_error.title"> {{form_error.title}}</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Fecha de expiración</label>
                                        <input v-model="form.expiration_date"  class="form-control" type="date" >
                                        <span class="text-danger" v-if="form_error.expiration_date"> {{form_error.expiration_date}}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group my-4">
                                <input v-model="form.description"  class="form-control" type="text" placeholder="Descripción"  >
                                <span class="text-danger" v-if="form_error.description"> {{form_error.description}}</span>
                            </div>

                            <div class="form-group my-4">
                                <label>Imagen</label>
                                <input  @change="handleImageUpload"  class="form-control" type="file">
                                <span class="text-danger" v-if="form_error.image"> {{form_error.image}}</span>
                            </div>

                            <div class="form-group d-flex flex-column my-4">

                                <label>Categoría</label>
                                <select v-model="form.tag_id"  class="form-control" >
                                    <option v-for="(tag, index) in tags" :key="index" :value="tag.id">
                                        {{ tag.name }}
                                    </option>
                                </select>
                                <span class="text-danger" v-if="form_error.tag"> {{form_error.tag}}</span>
                            </div>

                            <button type="submit" class="btn btn-primary btn-block">Guardar</button>
                        </form>
                        <div v-if="errors && errors.length" class="error-messages">
                            <ul>
                                <li v-for="(error, index) in errors" :key="index">{{ error }}</li>
                            </ul>
                        </div>
                    </div>

                    <div  class="error-message text-center text-danger">

                    </div>
                </div>
            </div>
        </div>


        <!-- The Edit modal -->
        <div class="modal fade" id="edit-note">
            <div class="modal-dialog">
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Editar Nota</h4>
                        <button  @click="clearError" type="button" class="close btn btn-danger" data-dismiss="modal">&times;</button>
                    </div>

                    <!-- Modal Body -->
                    <div class="modal-body">
                        <form @submit.prevent="updateNote(selectedNote.id)" class="card card-body">
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Titulo</label>
                                        <input v-model="selectedNote.title" class="form-control" >
                                        <span class="text-danger" v-if="form_error.title"> {{form_error.title}}</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Fecha de expiración</label>
                                        <input  v-model="selectedNote.expiration_date" class="form-control" type="date" >
                                        <span class="text-danger" v-if="form_error.expiration_date"> {{form_error.expiration_date}}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group my-4">
                                <input  v-model="selectedNote.description"  class="form-control" type="text" placeholder="Descripción"  >
                                <span class="text-danger" v-if="form_error.description"> {{form_error.description}}</span>
                            </div>

                            <div class="form-group my-4">
                                <label>Imagen</label>
                                <input  @change="handleImageUploadUpdate"  class="form-control" type="file">
                                <span class="text-danger" v-if="form_error.image"> {{form_error.image}}</span>
                            </div>

                            <div class="form-group d-flex flex-column my-4">
                                <label>Categoría</label>
                                <select v-model="selectedNote.tag_id" class="form-control" >
                                    <option v-for="(tag, index) in tags" :key="index" :value="tag.id">
                                        {{ tag.name }}
                                    </option>
                                </select>
                                <span class="text-danger" v-if="form_error.tag"> {{form_error.tag}}</span>
                            </div>

                            <button type="submit" class="btn btn-primary btn-block">Guardar</button>
                        </form>
                        <div v-if="errors && errors.length" class="error-messages">
                            <ul>
                                <li v-for="(error, index) in errors" :key="index">{{ error }}</li>
                            </ul>
                        </div>
                    </div>

                    <div  class="error-message text-center text-danger">

                    </div>
                </div>
            </div>
        </div>

    </div>

</template>

<script>
import { computed, ref, onMounted, reactive, watch } from 'vue'
import { useStore  } from 'vuex'
import { validateBlankSpace, validateDate, validateImageFile } from '@/helpers/validator.js'
export default {

    setup(){
        const store = useStore()
        const tags = computed(() => store.getters.tags)
        const notes = computed(() => store.getters.notes)
        const errors = computed(() => store.getters.error)
        const form = reactive({
            title: '',
            description: '',
            expiration_date: null,
            tag_id: '',
            image: null
        })
        const selectedNote = ref({
            id:'',
            title: '',
            description: '',
            expiration_date: '',
            tag_id: '',
            tag:'',
        })
        const order = ref('')
        const date = ref('')
        const validation_error = ref('')
        const form_error = ref({
            title: '',
            description: '',
            expiration_date: '',
            tag:'',
            image:'',
        })

        onMounted(() => {
            store.dispatch('fetchTags')
            store.dispatch('fetchNote')

        })

        const handleImageUpload = (event) => {
            form.image = event.target.files[0]

        }

        const handleImageUploadUpdate = (event)=>{
            selectedNote.value.image = event.target.files[0]

        }


        //Clear inputs and the error messages
        const clearInput = ()=>{
            for (let key in form) {
                form[key] = ''
            }
            form.image = null
            for (let key in form_error.value) {
                form_error.value[key] = ''
            }

        }

        const createNote = () => {

            let flag_validator = true

            if(!form.title || !validateBlankSpace( form.title ) ){
                flag_validator = false;
                form_error.value.title = 'El titulo es obligatorio';
            }else{
                form_error.value.title = '';
            }
            if(!form.description || !validateBlankSpace( form.description )){
                flag_validator = false;
                form_error.value.description = 'El descripción es obligatoria';
            }else{
                form_error.value.description = '';
            }
            if( !form.tag_id ){
                flag_validator = false;
                form_error.value.tag = 'El categoría es obligatoria';
            }else{
                form_error.value.tag = '';
            }
            if( form.expiration_date ){
                if( !validateDate( form.expiration_date ) ){
                    flag_validator = false;
                    form_error.value.expiration_date = 'Formato  invalido';
                }
            }
          if( form.image ){
              if(!validateImageFile(form.image)){
                  flag_validator = false;
                  form_error.value.image = 'Formato de archivo invalido';
              }else{
                  form_error.value.image = '';
              }
          }

            if( flag_validator ){
                //Pass the validations
                const formData = new FormData()
                formData.append('title', form.title)
                formData.append('description', form.description)
                if( form.expiration_date ) formData.append('expiration_date', form.expiration_date )
                formData.append('tag_id', form.tag_id)
                if (form.image) formData.append('image', form.image);
                store.dispatch('storeNote', formData).then(() => {
                    console.log(errors.value,'test')
                    if(!errors.value){
                        store.dispatch('fetchNote')
                        form.title = ''
                        form.description = ''
                        form.expiration_date = ''
                        form.tag_id = ''
                        form.image = null
                        $('#create-note').modal('hide')
                    }
                }).catch(error => {

                    console.error(error)
                })
            }

        }

        const setNote = (note) =>{
            selectedNote.value = {...note}
            if(note.image) selectedNote.value.image = null

        }

        const updateNote = (note)=>{

            let flag_validator = true

            if(!selectedNote.value.title || !validateBlankSpace( selectedNote.value.title ) ){
                flag_validator = false;
                form_error.value.title = 'El titulo es obligatorio';
            }else{
                form_error.value.title = '';
            }
            if(!selectedNote.value.description || !validateBlankSpace( selectedNote.value.description )){
                flag_validator = false;
                form_error.value.description = 'El descripción es obligatoria';
            }else{
                form_error.value.description = '';
            }
            if( !selectedNote.value.tag_id ){
                flag_validator = false;
                form_error.value.tag = 'El categoría es obligatoria';
            }else{
                form_error.value.tag = '';
            }
            if( selectedNote.value.expiration_date ){
                if( !validateDate( selectedNote.value.expiration_date ) ){
                    flag_validator = false;
                    form_error.value.expiration_date = 'Formato  invalido';
                }
            }
            if( selectedNote.value.image ){
                if(!validateImageFile( selectedNote.value.image  )){
                    flag_validator = false;
                    form_error.value.image = 'Formato de archivo invalido';
                }else{
                    form_error.value.image = '';
                }
            }
            if( flag_validator ){
                //Pass the validations
                const formData = new FormData()
                formData.append('title', selectedNote.value.title)
                formData.append('description', selectedNote.value.description)
                if( selectedNote.value.expiration_date  ) formData.append('expiration_date', selectedNote.value.expiration_date)
                formData.append('tag_id', selectedNote.value.tag_id)
                if (selectedNote.value.image) formData.append('image', selectedNote.value.image);
                store.dispatch('updateNote',  { note, data:formData }).then(() => {
                    store.dispatch('fetchNote')
                    $('#edit-note').modal('hide')

                }).catch(error => {

                    console.error(error)
                })
            }

        }
        const deleteNote = (id) => {
            Swal.fire({
                title: "¿Estás seguro de esta acción?",
                text: "El registro será eliminado permanentemente!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Si!"
            }).then((result) => {
                if (result.isConfirmed) {
                    store.dispatch('deleteNete', id).then(() => {
                        store.dispatch('fetchNote')
                    }).catch(error => {
                        console.error(error)
                    })
                }
            });

        }
        const getImageUrl = (imagePath) => {
            return `${window.location.origin}/storage/${imagePath}`
        }

        const orderNote = () =>{
            if(!order.value || !date.value) validation_error.value = 'Selecciona un valor valido*.'
            else{
                validation_error.value = '';
                store.dispatch('orderNote',{order:order.value, date:date.value})
            }
        }

        const clearError = ()=>{
            store.dispatch('clearError')
        }

        return{
            tags,
            notes,
            form,
            errors,
            selectedNote,
            order,
            date,
            validation_error,
            form_error,
            getImageUrl,
            createNote,
            setNote,
            updateNote,
            handleImageUpload,
            deleteNote,
            clearInput,
            handleImageUploadUpdate,
            orderNote,
            clearError,

        }
    }
}
</script>
