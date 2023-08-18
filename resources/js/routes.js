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

//category
let store_category = require('./components/category/create.vue').default;
let category = require('./components/category/index.vue').default;
let edit_category = require('./components/category/edit.vue').default;

//product
let store_product = require('./components/product/create.vue').default;
let product = require('./components/product/index.vue').default;
let edit_product = require('./components/product/edit.vue').default;

//expense
let store_expense = require('./components/expense/create.vue').default;
let expense = require('./components/expense/index.vue').default;
let edit_expense = require('./components/expense/edit.vue').default;

//salary
let salary = require('./components/salary/all_employee.vue').default;
let pay_salary = require('./components/salary/create.vue').default;
let all_salary = require('./components/salary/index.vue').default;
let view_salary = require('./components/salary/view.vue').default;
let edit_salary = require('./components/salary/edit.vue').default;

//stock
let stock = require('./components/product/stock.vue').default;
let edit_stock = require('./components/product/edit_stock.vue').default;

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

    //category routes
    { path: '/store-category', component: store_category, name: 'store-category' },
    { path: '/category', component: category, name: 'category' },
    { path: '/edit-category/:id', component: edit_category, name: 'edit-category' },

    //product routes
    { path: '/store-product', component: store_product, name: 'store-product' },
    { path: '/product', component: product, name: 'product' },
    { path: '/edit-product/:id', component: edit_product, name: 'edit-product' },

    //expense routes
    { path: '/store-expense', component: store_expense, name: 'store-expense' },
    { path: '/expense', component: expense, name: 'expense' },
    { path: '/edit-expense/:id', component: edit_expense, name: 'edit-expense' },

    //salary routes
    { path: '/given-salary', component: salary, name: 'given-salary' },
    { path: '/pay-salary/:id', component: pay_salary, name: 'pay-salary' },
    { path: '/salary', component: all_salary, name: 'salary' },
    { path: '/view-salary/:id', component: view_salary, name: 'view-salary' },
    { path: '/edit-salary/:id', component: edit_salary, name: 'edit-salary' },

    //stock routes
    { path: '/stock', component: stock, name: 'stock' },
    { path: '/edit-stock/:id', component: edit_stock, name: 'edit-stock' },
]