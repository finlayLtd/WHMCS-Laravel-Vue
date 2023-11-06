import { createStore } from 'vuex'
import createPersistedState from 'vuex-persistedstate'
import auth from '../store/auth'
import lang from '../store/lang'
import theme from '../store/theme'

const store = createStore({
    plugins:[
        createPersistedState()
    ],
    modules:{
        auth,
        lang,
        theme
    }
})

export default store
