import './bootstrap';

import './assets/css/bootstrap.css';
import 'bootstrap/dist/js/bootstrap.js';
import './assets/css/style.css';
import './assets/css/dark-theme.css';
import './assets/css/responsive.css';
import { createApp } from 'vue';
import LaravelVuePagination from 'laravel-vue-pagination';
import store from './store'
import router from './routes/index'
import VueSweetalert2 from "vue-sweetalert2";
import { abilitiesPlugin } from '@casl/vue';
import ability from './services/ability';
import vSelect from "vue-select";
import useAuth from './composables/auth';
import i18n from "./plugins/i18n";

const app = createApp({
    created() {
        useAuth().getUser()
    }
});

import ExampleComponent from './components/ExampleComponent.vue';
import { createPinia } from 'pinia';
app.component('example-component', ExampleComponent);

const pinia = createPinia();

app.use(pinia)
app.use(router)
app.use(store)
app.use(VueSweetalert2)
app.use(i18n)
app.use(abilitiesPlugin, ability)
app.component('Pagination', LaravelVuePagination)
app.component("v-select", vSelect);
app.mount('#app')
