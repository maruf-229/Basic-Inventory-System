let login = require('./components/auth/login.vue').default;
let register = require('./components/auth/register.vue').default;
let forget = require('./components/auth/forget.vue').default;
let logout = require('./components/auth/logout.vue').default;
let home = require('./components/home.vue').default;

let store_employee = require('./components/emloyee/create.vue').default;
let employee = require('./components/emloyee/index.vue').default;

export const routes = [
    { path: '/', component: login, name: '/' },
    { path: '/register', component: register, name: 'register' },
    { path: '/forget', component: forget, name: 'forget' },
    { path: '/logout', component: logout, name: 'logout' },
    { path: '/home', component: home, name: 'home' },


    { path: '/store-employee', component: store_employee, name: 'store-employee' },
    { path: '/employee', component: employee, name: 'employee' },
]
