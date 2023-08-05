import { ref, reactive, inject } from 'vue'
import { useRouter } from "vue-router";
import { AbilityBuilder, Ability } from '@casl/ability';
import { ABILITY_TOKEN } from '@casl/vue';
import store from '../store';
import { useToast } from "vue-toast-notification";
import "vue-toast-notification/dist/theme-sugar.css";
const $toast = useToast();

import { showLoader } from '@/plugins/loading.js';


let user = reactive({
    name: '',
    email: '',
})

export default function useAuth() {
    const processing = ref(false)
    const validationErrors = ref({})
    const router = useRouter()
    const swal = inject('$swal')
    const ability = inject(ABILITY_TOKEN)

    const loginForm = reactive({
        email: '',
        password: '',
        remember: false
    })

    const registerForm = reactive({
        name: '',
        email: '',
        password: '',
        password_confirmation: ''
    })

    const submitLogin = async () => {
        if (processing.value) return

        processing.value = true
        validationErrors.value = {}

        showLoader(true);
        await axios.post('/login', loginForm)
            .then(async response => {
                await store.dispatch('auth/getUser')
                await loginUser()
                const { accessToken, userData, userAbilities } = response.data
                localStorage.setItem('userAbilities', JSON.stringify(userAbilities))
                ability.update(userAbilities)
                localStorage.setItem('userData', JSON.stringify(userData))
                localStorage.setItem('accessToken', JSON.stringify(accessToken))
                showLoader(false);
                $toast.success("Login successfully!");
                await router.push({ name: 'dashboard' })
            })
            .catch(error => {
                showLoader(false);
                if (error.response?.data) {
                    validationErrors.value = error.response.data.errors
                }
            })
            .finally(() => {
                showLoader(false);
                processing.value = false;
            })
    }

    const submitRegister = async () => {
        if (processing.value) return

        processing.value = true
        validationErrors.value = {}

        await axios.post('/register', registerForm)
            .then(async response => {
                $toast.success("Registration successfully!");
                await router.push({ name: 'auth.login' })
            })
            .catch(error => {
                if (error.response?.data) {
                    validationErrors.value = error.response.data.errors
                }
            })
            .finally(() => processing.value = false)
    }

    const loginUser = () => {
        user = store.state.auth.user
        getAbilities()
    }

    const getUser = async () => {
        if (store.getters['auth/authenticated']) {
            await store.dispatch('auth/getUser')
            await loginUser()
        }
    }

    const logout = async () => {
        if (processing.value) return

        processing.value = true

        axios.post('/logout')
            .then(response => {
                user.name = ''
                user.email = ''
                store.dispatch('auth/logout')
                router.push({ name: 'auth.login' })
            })
            .catch(error => {
                console.log(error);
            })
            .finally(() => {
                processing.value = false
            })
    }

    const getAbilities = async() => {
        await axios.get('/api/abilities')
            .then(response => {
                const permissions = response.data
                const { can, rules } = new AbilityBuilder(Ability)

                can(permissions)

                ability.update(rules)
            })
    }

    return {
        loginForm,
        registerForm,
        validationErrors,
        processing,
        submitLogin,
        submitRegister,
        user,
        getUser,
        logout,
        getAbilities
    }
}
