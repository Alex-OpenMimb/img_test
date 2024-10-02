import { createStore } from 'vuex'

const store = createStore({

    state:{
        token : localStorage.getItem('token') || '',
        tags : [],
        notes: [],
        error: false,
    },
    mutations:{

        UPDATE_TOKEN(state,payload){
            state.token = payload
        },
        SET_TAGS(state, tags){
            state.tags = tags
        },
        SET_NOTES(state, notes){
            state.notes = notes
        },
        SET_ERROR( state, message ){
            state.error = message
        }

    },
    actions:{

        setToken(context,payload){
            localStorage.setItem('token',payload)
            context.commit('UPDATE_TOKEN',payload)
        },
        removeToken(context){
            localStorage.removeItem('token');
            context.commit('UPDATE_TOKEN', 0);
        },
        fetchTags({commit, state}){
            const token = state.token;
            axios.get(`/api/tags`,{
                headers: {
                    Authorization: `Bearer ${token}`
                }
            }).then( response =>{
                    let tags = response.data.data
                    commit('SET_TAGS', tags);
                }).catch(error => {

                console.error("Error:", error);
            });
        },
        fetchNote( {commit, state} ){
            const token = state.token;
            axios.get(`/api/notes`,{
                headers: {
                    Authorization: `Bearer ${token}`
                }
            }).then( response =>{
                let notes = response.data.data
                commit('SET_NOTES', notes);
            }).catch(error => {

                console.error("Error:", error);
            });
        },
        storeNote( {commit,state},data ){

            const token = state.token
            axios.post(`/api/notes`,data,{
                headers: {
                    Authorization: `Bearer ${token}`
                }
            }).then( response =>{
                let message = response.data.message
                console.log( response.data )
                if (!response.data.response) {
                    commit('SET_ERROR', message);
                }else{
                    commit('SET_ERROR', false);
                }
            }).catch(error => {
                console.error(error)
            });
        },
        updateNote( {commit,state},{id,data} ){
            const token = state.token
            axios.post(`/api/notes/${id}`,data,{
                headers: {
                    Authorization: `Bearer ${token}`
                }
            }).then( response =>{
                let note = response.data
                console.log(note)
                let message = response.data.message
                if (!response.data.response) {
                    commit('SET_ERROR', message);
                }else{
                    commit('SET_ERROR', false);
                }
            }).catch(error => {

                console.error("Error:", error)
            });
        },
        deleteNete({commit,state},id){
            const token = state.token
            axios.delete(`/api/notes/${id}`,{
                headers: {
                    Authorization: `Bearer ${token}`
                }
            }).then( response =>{
                let notes = response
                console.log(notes)
            }).catch(error => {

                console.error("Error:", error);
            });
        },
        clearError({commit}){
            commit('SET_ERROR', false);
        }

    },
    getters:{
        token: state => state.token,
        tags:  state => state.tags,
        notes: state => state.notes,
        error: state => state.error

    }

})

export default store;
