import {Dropdown} from 'boosted/dist/js/boosted.esm';
import VueRouter from 'vue-router';
import Vue from 'vue/dist/vue';
import './app.scss';

Vue.use(VueRouter);

Vue.directive('dropdown', {
    inserted(el) {
        console.debug('dropdown::create');
        new Dropdown(el.firstChild, {
            autoClose: true,
        });
    },
});

Vue.filter('d', value => value ? new Date(value).toLocaleDateString() : '-');
Vue.filter('t', value => value ? new Date(value).toLocaleTimeString() : '-');
Vue.filter('dt', value => {
    if (!value) {
        return '-';
    }

    const d = new Date(value);

    return d.toLocaleDateString() + ' ' + d.toLocaleTimeString();
});

const routes = [{
    name: 'home',
    path: '/',
    component: require('./js/routes/home.vue').default,
    children: [],
}];

const router = new VueRouter({mode: 'history', routes});
router.beforeEach((to, from, next) => {
    console.debug(`${from.name} => ${to.name}`);
    next();
});

const app = document.getElementById('app');

app.innerHTML = require('./app.pug');

new Vue({
    router,
}).$mount(app);
