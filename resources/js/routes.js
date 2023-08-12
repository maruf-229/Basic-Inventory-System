let login = require('./components/auth/login.vue').default;
let register = require('./components/auth/register.vue').default;
let forget = require('./components/auth/forget.vue').default;
let logout = require('./components/auth/logout.vue').default;
let home = require('./components/home.vue').default;
//employee
let store_employee = require('./components/emloyee/create.vue').default;
let employee = require('./components/emloyee/index.vue').default;
let edit_employee = require('./components/emloyee/edit.vue').default;
//supplier
let store_supplier = require('./components/supplier/create.vue').default;
let supplier = require('./components/supplier/index.vue').default;
let edit_supplier = require('./components/supplier/edit.vue').default;

export const routes = [
    { path: '/', component: login, name: '/' },
    { path: '/register', component: register, name: 'register' },
    { path: '/forget', component: forget, name: 'forget' },
    { path: '/logout', component: logout, name: 'logout' },
    { path: '/home', component: home, name: 'home' },


    //employee routes
    { path: '/store-employee', component: store_employee, name: 'store-employee' },
    { path: '/employee', component: employee, name: 'employee' },
    { path: '/edit-employee/:id', component: edit_employee, name: 'edit-employee' },

    //supplier routes
    { path: '/store-supplier', component: store_supplier, name: 'store-supplier' },
    { path: '/supplier', component: supplier, name: 'supplier' },
    { path: '/edit-supplier/:id', component: edit_supplier, name: 'edit-supplier' },
]