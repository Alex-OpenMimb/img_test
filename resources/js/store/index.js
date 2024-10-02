import { createStore } from 'vuex'

const store = createStore({

    state:{
        token : localStorage.getItem('token') || '',
        tags : [],
        notes: [],
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

                console.error("Error adding task:", error);
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

                console.error("Error adding task:", error);
            });
        }
    },
    getters:{
        token: state => state.token,
        tags:  state => state.tags,
        notes:  state => state.notes

    }

})

export default store;
